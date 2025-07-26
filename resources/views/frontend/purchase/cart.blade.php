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
  const shippingCost = 10.00;
  const isLoggedIn  = @json(auth()->check());
  // since you’re storing uploads directly in public/, assetBase should point to your public root
  const assetBase   = "{{ asset('') }}";  

  function formatPrice(n){ return n.toFixed(2); }
  function updateSummary(totalQty, subtotal){
    $('.total_qty').text(totalQty);
    $('.subtotal').text(formatPrice(subtotal));
    $('.grand_total').text(formatPrice(subtotal + shippingCost));
    $('#mini-cart-count').text(totalQty);
  }

  // ── GUEST CART ─────────────────
  function loadGuestCart(){
    const cart = JSON.parse(localStorage.getItem('guest_cart')||'{}');
    const ids  = Object.keys(cart);
    if (!ids.length) {
      $('#cart-items-body').html('<tr><td colspan="5">Your cart is empty</td></tr>');
      return updateSummary(0,0);
    }
    let rows='', totalQty=0, subtotal=0, pending=ids.length;
    ids.forEach((id,i) => {
      const qty = cart[id];
      totalQty += qty;
      $.getJSON("/works/json/" + id, function(work) {
        const price     = parseFloat(work.price||0);
        const lineTotal = price*qty;
        subtotal += lineTotal;
        rows += `
          <tr data-id="${id}">
            <td>${i+1}.</td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <img src="${assetBase}${work.work_image_low}" width="60" class="art-thumb">
                <div><h6>${work.name}</h6><p>$${formatPrice(price)}/unit</p></div>
              </div>
            </td>
            <td>
              <input type="number"
                    class="form-control qty-number-field"
                    value="${qty}"
                    min="1" max="999">
            </td>
            <td class="text-end">$${formatPrice(lineTotal)}</td>
            <td>
              <button class="btn btn-outline-warning btn-guest-delete" data-id="${id}">
                <i class="ri-delete-bin-line"></i>
              </button>
            </td>
          </tr>`;
      })
      .always(()=> {
        if (!--pending) {
          $('#cart-items-body').html(rows);
          updateSummary(totalQty, subtotal);
        }
      });
    });
  }

  // ── GUEST QTY CHANGE ───────────────────
  $('#cart-items-body').on('change', '.qty-number-field', function(){
    if (!isLoggedIn) {
      const $tr     = $(this).closest('tr');
      const id      = $tr.data('id');
      let   newQty  = parseInt($(this).val(), 10) || 1;
      if (newQty < 1) newQty = 1;

      // update localStorage
      const cart = JSON.parse(localStorage.getItem('guest_cart')||'{}');
      cart[id] = newQty;
      localStorage.setItem('guest_cart', JSON.stringify(cart));

      // re-render
      loadGuestCart();
    }
  });


  // ── USER CART ───────────────────────────────────────────
  function loadUserCart(){
    $.getJSON("{{ route('cart.index') }}", resp => {
      let rows= '', totalQty=0, subtotal=0;
      if (!resp.items.length) {
        $('#cart-items-body').html('<tr><td colspan="5">Your cart is empty</td></tr>');
        return updateSummary(0,0);
      }
      resp.items.forEach((item,i) => {
        const price     = parseFloat(item.work.price || 0);
        const lineTotal = price * item.quantity;
        totalQty += item.quantity;
        subtotal += lineTotal;
        const imgUrl = assetBase + item.work.work_image;
        rows += `
          <tr data-id="${item.id}">
            <td>${i+1}.</td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <img src="${imgUrl}" width="60" class="art-thumb" alt="${item.work_name}">
                <div>
                  <h6>${item.work_name}</h6>
                  <p class="m-0">$ ${formatPrice(price)}/unit</p>
                </div>
              </div>
            </td>
            <td>
              <input type="number" class="form-control qty-number-field" value="${item.quantity}" min="1" max="999">
            </td>
            <td class="text-end">$ ${formatPrice(lineTotal)}</td>
            <td>
              <button class="btn btn-outline-warning btn-delete"><i class="ri-delete-bin-line"></i></button>
            </td>
          </tr>`;
      });
      $('#cart-items-body').html(rows);
      updateSummary(resp.cart_count, subtotal);
    });
  }

    // ── BRANCH ─────────────────────
  function loadCart(){
    return isLoggedIn ? loadUserCart() : loadGuestCart();
  }

  // ── ENTRY POINT ─────────────────────────────────────────
  function loadCart(){
    if (!isLoggedIn) {
      loadGuestCart();
    } else {
      loadUserCart();
    }
  }

  // ── GUEST DELETE ───────────────────────────────────────
  $('#cart-items-body').on('click', '.btn-guest-delete', function(){
    const id = $(this).data('id');
    const cart = JSON.parse(localStorage.getItem('guest_cart')||'{}');
    delete cart[id];
    localStorage.setItem('guest_cart', JSON.stringify(cart));
    loadGuestCart();
  });

  // ── USER UPDATE & DELETE ───────────────────────────────
  $('#cart-items-body').on('change', '.qty-number-field', function(){
    if (!isLoggedIn) return;
    const $row = $(this).closest('tr'),
          id   = $row.data('id'),
          qty  = +$(this).val();
    $.ajax({
      url: `{{ url('cart') }}/${id}/quantity`,
      method: 'PATCH',
      data: { quantity: qty },
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    }).always(loadUserCart);
  });
  $('#cart-items-body').on('click', '.btn-delete', function(){
    if (!isLoggedIn) return;
    const id = $(this).closest('tr').data('id');
    $.ajax({
      url: `{{ url('cart') }}/${id}`,
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    }).always(loadUserCart);
  });

  // ── ADD TO CART ────────────────────────────────────────
  $('.btn-add-to-cart').on('click', function(e){
    e.preventDefault();
    const workId = $(this).data('work-id');
    if (!workId) return;
    if (!isLoggedIn) {
      const cart = JSON.parse(localStorage.getItem('guest_cart')||'{}');
      cart[workId] = (cart[workId]||0) + 1;
      localStorage.setItem('guest_cart', JSON.stringify(cart));
      $('#mini-cart-count').text(Object.values(cart).reduce((a,b)=>a+b,0));
      return;
    }
    $.post("{{ route('cart.add') }}",
      { work_id: workId },
      data => { $('#mini-cart-count').text(data.cart_count); },
      'json'
    );
  });

  // ── PROCEED TO CHECKOUT ─────────────────────────────────
  $('#btn-proceed-checkout').on('click', function(e){
    e.preventDefault();
    const target = "{{ route('checkout.form') }}";
    if (!isLoggedIn) {
      $.ajax({
        url: "{{ route('cart.sync') }}",
        method: 'POST',
        contentType: 'application/json',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: JSON.stringify({ items: JSON.parse(localStorage.getItem('guest_cart')||'{}') })
      }).always(() => {
        window.location.href = target;
      });
    } else {
      window.location.href = target;
    }
  });

  // Initial load
  loadCart();
});
</script>

@endpush

@endsection