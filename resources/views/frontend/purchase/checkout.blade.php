{{-- resources/views/checkout.blade.php --}}
@extends('layouts.guest')

@section('title', 'Checkout')

@section('content')
<main>
  <!-- Banner -->
  <section class="banner-box">
    <div class="bg-banner-box"
         style="background-image:
            linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
            url('{{ asset("frontend-css/img/webimg/port-3-gallery.jpg") }}');">
      <h1 class="jacques text-uppercase px-4">Checkout Now</h1>
    </div>
  </section>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
            </ul>
        </div>
    @endif

  <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST">
    @csrf
    <input type="hidden" name="buy_now_id" value="{{ request('buy_now_id') }}">
    <input type="hidden" name="cart_line_id" value="{{ request('cart_line_id') }}">
    <input type="hidden" name="buy_qty" value="{{ request('buy_qty') }}">
    <section class="section-gap px-4">
      <div class="row">
        {{-- Shipping & Billing Form --}}
        <div class="col-sm-6 col-md-7 col-xxl-8">
          <div class="bg-form-dark playfair mb-4 p-4">
            <h4 class="mb-3 d-flex justify-content-between align-items-end">
              <span>Contact & Shipping</span>
              <small>* Required</small>
            </h4>

            {{-- Shipping --}}
            <h5 class="mt-3">Shipping Address</h5>
            <div class="row">
              @foreach(['f_name'=>'First Name','l_name'=>'Last Name'] as $field=>$label)
                <div class="col-md-6 p-2">
                  <label class="form-label" for="{{ $field }}">{{ $label }}</label>
                  <input type="text"
                         class="form-control @error($field) is-invalid @enderror"
                         name="{{ $field }}"
                         id="{{ $field }}"
                         value="{{ old($field) }}"
                         placeholder="Enter your {{ strtolower($label) }}">
                  @error($field)
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              @endforeach

              <div class="col-12 p-2">
                <label class="form-label" for="address">Street Address</label>
                <textarea class="form-control @error('address') is-invalid @enderror"
                          name="address"
                          id="address"
                          rows="3"
                          placeholder="Write your street information">{{ old('address') }}</textarea>
                @error('address')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              @foreach(['city','state','zip','country'] as $field)
                <div class="col-md-{{ $field==='city' ? '4' : ($field==='country'? '12':'4') }} p-2">
                  <label class="form-label" for="{{ $field }}">{{ ucfirst($field) }}</label>
                  <input type="text"
                         class="form-control @error($field) is-invalid @enderror"
                         name="{{ $field }}"
                         id="{{ $field }}"
                         value="{{ old($field) }}"
                         placeholder="Enter your {{ $field }}">
                  @error($field)
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                @if($field==='country') @break @endif
              @endforeach

            </div>

            {{-- Billing --}}
            <h5 class="mt-4">Billing Address</h5>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox"
                     name="billing_form" id="billing_form"
                     {{ old('billing_form', true) ? 'checked' : '' }}>
              <label class="form-check-label" for="billing_form">
                Same as shipping address
              </label>
            </div>

            <div id="billing_fields" @if(old('billing_form', true)) style="display:none;" @endif>
              <div class="row">
                @foreach([ 
                  'bill_f_name'=>'First Name','bill_l_name'=>'Last Name',
                  'bill_address'=>'Street Address'
                ] as $field=>$label)
                  <div class="col-md-{{ $field==='bill_address' ? '12':'6' }} p-2">
                    <label class="form-label" for="{{ $field }}">{{ $label }}</label>
                    @if($field==='bill_address')
                      <textarea class="form-control @error($field) is-invalid @enderror"
                                name="{{ $field }}" id="{{ $field }}"
                                rows="3" placeholder="Write your street info">{{ old($field) }}</textarea>
                    @else
                      <input type="text"
                             class="form-control @error($field) is-invalid @enderror"
                             name="{{ $field }}" id="{{ $field }}"
                             value="{{ old($field) }}"
                             placeholder="Enter your {{ strtolower($label) }}">
                    @endif
                    @error($field)
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                @endforeach

                @foreach(['bill_city'=>'City','bill_state'=>'State','bill_zip'=>'Zip/Postal Code','bill_country'=>'Country'] as $field=>$label)
                  <div class="col-md-{{ $field==='bill_country' ? '12':'4' }} p-2">
                    <label class="form-label" for="{{ $field }}">{{ $label }}</label>
                    <input type="text"
                           class="form-control @error($field) is-invalid @enderror"
                           name="{{ $field }}"
                           id="{{ $field }}"
                           value="{{ old($field) }}"
                           placeholder="Enter your {{ strtolower($label) }}">
                    @error($field)
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  @if($field==='bill_country') @break @endif
                @endforeach
              </div>
            </div>
          </div>
        </div>
        {{-- Product Information --}}
        <div class="col-sm-6 col-md-5 col-xxl-4 cormorant">
          <h4>Product Information</h4>
          <div class="table-responsive">
            <table class="w-100 align-middle">
              <tbody>
                @foreach($items as $item)
                  @php
                    $unitPrice = $item->unit_price ?? ($item->work->price ?? 0);
                    $lineTotal = $unitPrice * $item->quantity;

                    // Build a variant label if no snapshot text exists
                    $variantText = $item->variant_text ?? null;
                    if (!$variantText && $item->workVariant) {
                        $groups = [];
                        foreach ($item->workVariant->attributeValues as $v) {
                            $attr = optional($v->attribute)->name ?: 'Option';
                            $groups[$attr][] = $v->value;
                        }
                        $parts = [];
                        foreach ($groups as $attr => $vals) {
                            $parts[] = $attr . ': ' . implode(', ', $vals);
                        }
                        $variantText = implode(' / ', $parts);
                    }

                    // Pick an image
                    $imgSrc = $item->work_image_low
                              ?: optional($item->work)->work_image_url
                              ?: asset('frontend-css/img/webimg/port-3-gallery.jpg');
                  @endphp

                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <img class="p-1" width="65" src="{{ is_string($imgSrc) && Str::startsWith($imgSrc, ['http','/']) ? $imgSrc : asset($imgSrc) }}"
                            alt="{{ $item->work_name }}" loading="lazy">
                        <div>
                          <h5 class="m-0">{{ $item->work_name }} (x{{ $item->quantity }})</h5>
                          @if($variantText)
                            <div class="small text-muted">{{ $variantText }}</div>
                          @endif
                          <div class="small text-muted">$ {{ number_format($unitPrice, 2) }} / unit</div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <h5 class="text-end">$ {{ number_format($lineTotal, 2) }}</h5>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td><h5 class="m-0">Total</h5></td>
                  <td><h5 class="text-end">$ {{ number_format($subtotal, 2) }}</h5></td>
                </tr>
                <tr>
                  <td><h5 class="m-0">Shipping charge</h5></td>
                  <td><h5 class="text-end">$ {{ number_format($shippingCharge, 2) }}</h5></td>
                </tr>
                <tr>
                  <td><h5 class="m-0">Grand Total</h5></td>
                  <td><h5 class="text-end">$ {{ number_format($grandTotal, 2) }}</h5></td>
                </tr>
              </tfoot>
            </table>
          </div>
          <hr>
          <button type="submit" class="btn btn-dark w-100">
            Process to pay
          </button>
        </div>

      </div>
    </section>
  </form>
</main>

{{-- Toggle billing fields --}}
@push('scripts')
<script>
$(function(){
  $('#billing_form').on('change', function(){
    if (this.checked) {
      $('#billing_fields').slideUp(300);
    } else {
      $('#billing_fields').slideDown(300);
    }
  });

  if ($('#billing_form').is(':checked')) {
    $('#billing_fields').hide();
  } else {
    $('#billing_fields').show();
  }
});

$(function(){
  const $form = $('#checkoutForm');

  // 1) on submit, show confirmation
  $form.on('submit', function(e){
    e.preventDefault();
    Swal.fire({
      title: 'Confirm Purchase',
      text: 'Are you sure you want to place this order?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, place order',
      cancelButtonText: 'Cancel'
    }).then(result => {
      if (result.isConfirmed) {
        // remove this handler and submit for real
        $form.off('submit').submit();
      }
    });
  });

  // 2) after redirect back, show thank‑you if success flash exists
  @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Thank you!',
      text: "{{ session('success') }}",
      confirmButtonText: 'Close'
    });
  @endif
});
</script>
@endpush

@endsection
