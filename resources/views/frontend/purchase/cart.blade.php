@extends('layouts.guest')

@section('title', 'Cart')

@section('content')
<main>
    <div class="content">
        <!-- cart top section start -->
        <section class="banner-box">
            <div class="bg-banner-box"
                style="background-image: linear-gradient( rgb(0 0 0/ 50%), rgb(0 0 0 / 50%)), url('{{ asset('frontend-css/img/webimg/port-1-gallery.jpg') }}');">
                <h1 class="jacques text-uppercase px-4">cart</h1>
            </div>
        </section>

    <section class="cart-box section-gap px-4" data-aos="fade-up" data-aos-duration="2000">
        <div class="cart-all-box">
        <div class="row">
            <div class="col-md-9">
            <div class="cart-box px-4 poppins mb-4">
                <div class="table-responsive">
                <table class="table align-middle text-center">
                    <thead>
                    <tr>
                        <th>#SL</th>
                        <th>Art Info</th>
                        <th>QTY</th>
                        <th>Price</th>
                        <th>Variant</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="cart-items-body">
                    {{-- rows injected here --}}
                    </tbody>
                </table>
                </div>
            </div>
            </div>

            <div class="col-md-3 cormorant">
            <div class="box-border border border-1 border-light p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                <p class="m-0"><span class="total_qty">0</span> Item</p>
                <strong class="poppins">$ <span class="subtotal">0.00</span></strong>
                </div>
                <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                <p class="m-0">Shipping</p>
                <strong class="poppins">$ <span class="shipping">10.00</span></strong>
                </div>
                <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                <p class="m-0">Total</p>
                <strong class="poppins">$ <span class="grand_total">0.00</span></strong>
                </div>
              <a href="javascript:void(0)"
                id="btn-proceed-checkout"
                class="btn btn-outline-light w-100 rounded-0 mt-3">
                Proceed to checkout
              </a>
            </div>
            </div>
        </div>
        </div>
    </section>
        <!-- cart section end -->
        <!-- feature image start -->
        <section class="cart-box section-gap px-4" data-aos="fade-up" data-aos-duration="2000">
            <div class="section-title-box mb-5">
                <div class="row">
                    <div class="col-sm-4 p-0">
                        <div class="bg-shape-title title-l d-none d-sm-flex"></div>
                    </div>
                    <div class="col-sm-4 p-0">
                        <div class="bg-shape-title title-c">
                            <center>
                                <h2 class="m-0 text-uppercase jacques">Feature Art's</h2>
                            </center>
                        </div>
                    </div>
                    <div class="col-sm-4 p-0">
                        <div class="bg-shape-title title-r d-none d-sm-flex"></div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                @forelse($featuredWorks as $work)
                    <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-2 col-01-5 p-2">
                        <a href="{{ route('frontend.works.show', $work->id) }}" 
                        class="feature-portrait-box card text-white bg-transparent" 
                        data-aos="zoom-in-down" data-aos-duration="2000"
                        title="{{ $work->name }}">
                            <div class="overflow-hidden">
                                <img class="card-img" src="{{ $work->work_image_url }}" alt="{{ $work->name }}" loading="lazy">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">{{ $work->name }}</h4>
                                <p class="card-text limited-text">
                                    {{ Str::limit($work->details, 150) }}
                                </p>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-center">No featured works available.</p>
                @endforelse
            </div>
        </section>
        <!-- feature image end -->
    </div>
</main>
<!-- main content end -->
@push('scripts')
<script>
$(function(){
  var shippingCost = 10.00;
  var assetBase    = "{{ asset('') }}";

  function formatPrice(n){ return Number(n || 0).toFixed(2); }
  function safeImg(src){
    if (!src) return "{{ asset('frontend-css/img/webimg/port-1-gallery.jpg') }}";
    // If it's already an absolute URL (starts with http or /storage/...), return as-is
    return /^https?:\/\//.test(src) || src.startsWith('/') ? src : (assetBase + src);
  }

  function variantLabel(item){
    if (item.variant_text) return item.variant_text;              // snapshot from DB
    if (item.work_variant && item.work_variant.attribute_values) { // <- updated
      var groups = {};
      item.work_variant.attribute_values.forEach(function(v){
        var attr = v.attribute ? v.attribute.name : 'Option';
        (groups[attr] = groups[attr] || []).push(v.value);
      });
      var parts = [];
      Object.keys(groups).forEach(function(attr){
        parts.push(attr + ': ' + groups[attr].join(', '));
      });
      return parts.join(' / ');
    }
    return '—';
  }


  function updateSummary(items){
    var totalQty = 0, subtotal = 0;
    items.forEach(function(it){
      totalQty += Number(it.quantity || 0);
      subtotal += Number(it.unit_price || 0) * Number(it.quantity || 0);
    });
    $('.total_qty').text(totalQty);
    $('.subtotal').text(formatPrice(subtotal));
    $('.grand_total').text(formatPrice(subtotal + shippingCost));
    $('#mini-cart-count').text(totalQty);
  }

  function renderRows(items){
    if (!items.length) {
      $('#cart-items-body').html('<tr><td colspan="6">Your cart is empty</td></tr>');
      updateSummary([]);
      return;
    }

    var rows = '';
    items.forEach(function(item, i){
      var price     = Number(item.unit_price || 0);
      var lineTotal = price * Number(item.quantity || 0);
      var title     = item.work_name || (item.work ? item.work.name : 'Artwork');
      var imgSrc    = item.work_image || (item.work ? item.work.work_image : null);
      var variant   = variantLabel(item);

      rows += `
        <tr data-id="${item.id}">
          <td>${i+1}.</td>
          <td>
            <div class="d-flex align-items-center gap-2 text-start">
              <img src="${safeImg(imgSrc)}" width="60" class="art-thumb" alt="${title}">
              <div>
                <h6 class="m-0">${title}</h6>
                <small class="text-muted">$ ${formatPrice(price)}/unit</small>
              </div>
            </div>
          </td>
          <td style="max-width:110px;">
            <input type="number" class="form-control qty-number-field" value="${item.quantity}" min="1" max="999">
          </td>
          <td class="text-end">$ ${formatPrice(lineTotal)}</td>
          <td class="text-start">${variant}</td>
          <td>
            <button class="btn btn-outline-warning btn-delete" title="Remove">
              <i class="ri-delete-bin-line"></i>
            </button>
          </td>
        </tr>`;
    });

    $('#cart-items-body').html(rows);
    updateSummary(items);
  }

  function loadCart(){
    $.getJSON("{{ route('cart.index') }}")
      .done(function(resp){
        renderRows(resp.items || []);
      })
      .fail(function(){
        $('#cart-items-body').html('<tr><td colspan="6">Failed to load cart.</td></tr>');
      });
  }

  // Quantity change (server for everyone)
  $('#cart-items-body').on('change', '.qty-number-field', function(){
    var $row = $(this).closest('tr');
    var id   = $row.data('id');
    var qty  = parseInt($(this).val(), 10);
    if (!qty || qty < 1) { qty = 1; $(this).val(qty); }

    $.ajax({
      url: `{{ url('cart') }}/${id}/quantity`,
      method: 'PATCH',
      dataType: 'json',
      data: { quantity: qty },
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    })
    .always(loadCart);
  });

  // Delete line
  $('#cart-items-body').on('click', '.btn-delete', function(){
    var id = $(this).closest('tr').data('id');
    $.ajax({
      url: `{{ url('cart') }}/${id}`,
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    }).always(loadCart);
  });

  // Proceed to checkout — no client sync needed; server has guest cart via session
  $('#btn-proceed-checkout').on('click', function(e){
    e.preventDefault();
    window.location.href = "{{ route('checkout.form') }}";
  });

  // First load
  loadCart();
});
</script>
@endpush


@endsection