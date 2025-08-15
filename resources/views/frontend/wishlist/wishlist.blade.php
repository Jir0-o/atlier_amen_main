@extends('layouts.guest')

@section('title', 'Wishlist')

@section('content')
    <!-- main content start -->
    <main>
        <div class="content">
            <!-- wishlist top section start -->
            <section class="banner-box">
                <div class="bg-banner-box"
                    style="background-image: linear-gradient( rgb(0 0 0/ 50%), rgb(0 0 0 / 50%)), url('{{ asset('frontend-css/img/webimg/port-1-gallery.jpg') }}');">
                    <h1 class="jacques text-uppercase px-4">Wishlist</h1>
                </div>
            </section>
            <!-- wishlist top section end -->

            <!-- wishlist table start -->
            <section class="pt-4" data-aos="fade-up" data-aos-duration="2000">
                <div class="cart-box wishlist-cart px-4 poppins mb-4">
                    <div class="table-responsive">
                        <table class="table align-middle text-center">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th>Art Info</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="wishlist-body">
                                @forelse($items as $i => $w)
                                @php
                                    $work = $w->work;
                                    $img  = $work?->work_image_low ?? $work?->work_image ?? null;
                                    $displayPrice = $work->variants_min_price ?? $work->price ?? 0;
                                @endphp
                                <tr data-work-id="{{ $work->id }}">
                                    <td>{{ $i+1 }}.</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                        <img class="art-thumb" width="60"
                                            src="{{ $img ? asset($img) : 'https://via.placeholder.com/60x60?text=Art' }}"
                                            alt="{{ $work->name }}" loading="lazy">
                                        <div class="text-start">
                                            <h6 class="mb-2">{{ $work->name }}</h6>

                                            {{-- Show "From $X.XX" when variants exist --}}
                                            @if(!is_null($work->variants_min_price))
                                            <p class="m-0">From $ {{ number_format($displayPrice, 2) }} / unit</p>
                                            @else
                                            <p class="m-0">$ {{ number_format($displayPrice, 2) }} / unit</p>
                                            @endif
                                        </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        $ {{ number_format($displayPrice, 2) }}
                                    </td>

                                    <td>
                                        <a href="{{ route('frontend.works.show', $work->id) }}" class="btn btn-primary" title="View">
                                        <i class="ri-eye-line"></i>
                                        </a>
                                        <button class="btn btn-outline-warning btn-remove-wishlist"
                                                data-remove-url="{{ route('wishlist.remove.work', $work->id) }}"
                                                title="Remove">
                                        <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4">Your wishlist is empty.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- wishlist table end -->
        </div>
    </main>
    <!-- main content end -->
 @push('scripts')
<script>
$(function(){
  function csrfHeader(){ return {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}; }
  function toastOk(m){ if (window.Swal) Swal.fire({icon:'success',title:m,timer:1200,showConfirmButton:false}); else alert(m); }
  function toastErr(m){ if (window.Swal) Swal.fire({icon:'error',title:m,timer:1500,showConfirmButton:false}); else alert(m); }

  $('#wishlist-body').on('click', '.btn-remove-wishlist', function(e){
    e.preventDefault();
    const $btn = $(this);
    const url  = $btn.data('remove-url');
    const $tr  = $btn.closest('tr');

    $btn.prop('disabled', true);
    $.ajax({
      url: url,
      method: 'DELETE',
      headers: csrfHeader()
    })
    .done(function(resp){
      if (resp.status === 'success') {
        $('#mini-wishlist-count').text(resp.count || 0);
        $tr.remove();
        toastOk('Removed from wishlist');
        if (!$('#wishlist-body tr').length) {
          $('#wishlist-body').html('<tr><td colspan="4">Your wishlist is empty.</td></tr>');
        }
      } else {
        toastErr(resp.message || 'Failed to remove');
      }
    })
    .fail(function(xhr){
      toastErr(xhr.responseJSON?.message || 'Failed to remove');
    })
    .always(function(){ $btn.prop('disabled', false); });
  });
});
</script>
@endpush   
@endsection