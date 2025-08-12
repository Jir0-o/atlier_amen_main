@extends('layouts.guest')

@section('title', $work->name ?? 'Art Information')

@php
    $pageUrl   = url()->current(); 
    $shareText = $work->name ? $work->name.' by '.$category->name : 'Check this artwork';

    $facebookShare = 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($pageUrl);
    $twitterShare  = 'https://twitter.com/intent/tweet?'.http_build_query([
        'url'  => $pageUrl,
        'text' => $shareText,
    ]);
@endphp

@section('content')
<!-- main content start -->
<main>
    <div class="content">
        <!-- portrait information start -->
        <section class="section-gap px-4">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="indi-img-box" data-aos="flip-left" data-aos-duration="2000">
                        <video src={{ $work->art_video}} controls autoplay></video>
                    </div>
                </div>
                {{-- Main Image + Gallery --}}
                <div class="col-sm-4 mb-4">
                    <div class="indi-img-box recent-img-box" data-aos="flip-left" data-aos-duration="2000">
                        {{-- Main Image --}}
                        <img 
                            src="{{ $work->work_image_url ?? $work->work_image_low_url ?? '' }}" 
                            alt="{{ $work->name }}" 
                            id="indi-img-preview" 
                            loading="lazy"
                            class="img-fluid w-100">

                        {{-- Hover Images --}}
                        @if(!empty($work->image_left))
                            <img class="recent-img-hover img-left" 
                                src="{{ asset($work->image_left) }}" 
                                alt="{{ $work->name }} Left Hover" 
                                loading="lazy">
                        @endif
                        @if(!empty($work->image_right))
                            <img class="recent-img-hover img-right" 
                                src="{{ asset($work->image_right) }}" 
                                alt="{{ $work->name }} Right Hover" 
                                loading="lazy">
                        @endif
                    </div>

                    {{-- Gallery Thumbs --}}
                    @if($work->gallery->isNotEmpty())
                        <div class="indi-img-gallery my-4">
                            <div class="row">
                                @foreach($work->gallery as $gIndex => $g)
                                    @php
                                        $thumbSrc = $g->image_low_url ?? $g->image_url;
                                        $fullSrc  = $g->image_url; // Full-size image
                                        $isActive = $gIndex === 0 ? 'active' : '';
                                    @endphp
                                    <div class="col-3 p-3">
                                        <div class="{{ $isActive }}">
                                            <img src="{{ $thumbSrc }}"
                                                data-full="{{ $fullSrc }}"
                                                alt="portrait preview"
                                                class="indi-thumb-img img-thumb"
                                                loading="lazy">
                                            {{-- If thumbs have hover states --}}
                                            @if(!empty($g->image_left))
                                                <img class="recent-img-hover img-left" 
                                                    src="{{ asset($g->image_left) }}" 
                                                    alt="Thumb Hover Left" 
                                                    loading="lazy">
                                            @endif
                                            @if(!empty($g->image_right))
                                                <img class="recent-img-hover img-right" 
                                                    src="{{ asset($g->image_right) }}" 
                                                    alt="Thumb Hover Right" 
                                                    loading="lazy">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                {{-- Info --}}
                <div class="col-sm-4 mb-4">
                    <div data-aos="fade-up" data-aos-duration="2000">
                        <div class="bg-shape-title title-c">
                            <center>
                                <h2 class="m-0 text-uppercase jacques">Art information</h2>
                            </center>
                        </div>

                        <div class="art-info playfair mt-4">
                            <table>
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>: {{ $work->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>:
                                            @if($work->work_date)
                                                {{ $work->work_date->format('M d, Y') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tag</th>
                                        <td>:
                                            @if($work->tags)
                                                {{ $work->tags }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td>: {{ $category->name ?? '—' }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            {{-- Details --}}
                            <h4 class="text-decoration-underline playfair fw-bold mb-3 mt-4">Details:</h4>
                            <div class="poppins">
                                {!! $work->details ?: '<p>No details added.</p>' !!}
                            </div>
                            <br>
                            <h4 class="playfair fw-bold mb-3">Price: <strong id="variantPrice">—</strong></div></h4>
                            <h4 class="playfair fw-bold mb-3">Stock: <strong id="variantStock">—</strong></div></h4>

                            {{-- Share --}}
                            <h4 class="text-decoration-underline playfair fw-bold mb-3 mt-4">Share:</h4>
                            <div class="d-flex gap-3 flex-wrap jacques mb-4">
                                <a href="{{ $facebookShare }}" target="_blank" rel="noopener" class="btn btn-outline-light rounded-5">
                                    <i class="ri-facebook-line"></i>
                                    Facebook
                                </a>
                                <a href="{{ $twitterShare }}" target="_blank" rel="noopener" class="btn btn-outline-light rounded-5">
                                    <i class="ri-twitter-line"></i>
                                    Twitter
                                </a>
                                <button type="button" class="btn btn-outline-light rounded-5 js-copy-link" data-copy="{{ $pageUrl }}">
                                    <i class="ri-instagram-line"></i>
                                    Instagram
                                </button>
                            </div>
                            {{-- Cart / Buy --}}
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex flex-column">
                                            <button 
                                                type="button"
                                                class="btn btn-outline-light btn-add-to-cart"
                                                data-work-id="{{ $work->id }}">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex flex-column">
                                            <button type="button" class="btn btn-warning text-white btn-buy-now" data-work-id="{{ $work->id }}">
                                                Buy Now
                                            </button>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                    {{-- <div>Selected Price: <strong id="variantPrice">—</strong></div>
                                    <div>Stock: <strong id="variantStock">—</strong></div> --}}
                                </div>
                                <input type="hidden" id="selectedVariantId" value="">
                                </div>
                            </div><!-- /.row buttons -->
                        </div><!-- /.art-info -->
                        <div class="modal fade" id="variantPickerModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Choose Options</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">

                                <div class="row g-2">
                                    @foreach($attributes as $attr)
                                        <div class="col-12">
                                            <label class="form-label">{{ $attr['name'] }}</label>
                                            <select class="form-select js-attr-select-modal" data-attribute-id="{{ $attr['id'] }}">
                                                <option value="">-- Select {{ $attr['name'] }} --</option>
                                                @foreach($attr['values'] as $v)
                                                    <option value="{{ $v['id'] }}">{{ $v['value'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="d-flex align-items-center gap-3 mt-3">
                                    <div>Selected Price: <strong id="variantPriceModal">—</strong></div>
                                    <div>Stock: <strong id="variantStockModal">—</strong></div>
                                </div>

                                <div class="mt-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="buyQtyModal" value="1" min="1" style="max-width:120px;">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary" id="variantConfirmBtn" disabled>Confirm</button>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div><!-- /.aos wrapper -->
                </div><!-- /.col info -->
            </div><!-- /.row -->
        </section>
        <!-- portrait information end -->
    </div>
</main>
<!-- main content end -->
@endsection

@push('scripts')
<script>
$(function () {
  // ====== Data from server ======
  var VARIANTS = @json($variants ?? []); 
  var ATTRS    = @json($attributes ?? []); 
  var WORK_ID  = {{ $work->id }};
  var BASE_PRICE = {{ (float)($work->price ?? 0) }}; 

  var ADD_TO_CART_URL = "{{ route('cart.add') }}";
  var BUY_NOW_URL     = "{{ route('cart.buyNow') }}";

  // ====== Helpers ======
  function csrfHeader() { return { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }; }
  function toastOk(msg){ if (window.Swal) Swal.fire({icon:'success',title:msg,timer:1200,showConfirmButton:false}); else alert(msg); }
  function toastErr(msg){ if (window.Swal) Swal.fire({icon:'error',title:msg,timer:1500,showConfirmButton:false}); else alert(msg); }
  function money(n){ n = parseFloat(n||0); if (isNaN(n)) n = 0; return n.toFixed(2); }

  // Lowest variant price (if any)
  function getMinVariantPrice(){
    var min = Infinity;
    (VARIANTS || []).forEach(function(v){
      var p = parseFloat(v.price);
      if (!isNaN(p) && p < min) min = p;
    });
    return isFinite(min) ? min : null;
  }

  // Stock UI: only show number & note if 1..3 left; otherwise show "—"
  function applyStockUI($el, stock){
    $el.text('—').removeClass('text-danger');
    $el.siblings('.low-note').remove();
    if (stock != null && !isNaN(+stock) && +stock > 0 && +stock <= 3) {
      $el.text(+stock).addClass('text-danger')
        .after('<span class="low-note text-warning ms-2">(Only ' + (+stock) + ' left)</span>');
    }
  }

  // Set main (page) UI
  function setMainVariantUI(v){
    if (!v) {
      $('#selectedVariantId').val('');
      var min = getMinVariantPrice();
      $('#variantPrice').text(money(min != null ? min : BASE_PRICE));
      applyStockUI($('#variantStock'), null);
      return;
    }
    $('#selectedVariantId').val(v.id);
    $('#variantPrice').text(money(v.price));
    applyStockUI($('#variantStock'), v.stock);
  }

  // Seed initial UI with lowest price (or base)
  setMainVariantUI(null);

  // ====== Gallery small helpers ======
  $('.indi-thumb-img').on('click', function(){
    var fullSrc = $(this).data('full') || $(this).attr('src');
    $('#indi-img-preview').attr('src', fullSrc);
    $('.indi-img-gallery .active').removeClass('active');
    $(this).parent().addClass('active');
  });
  $('.js-copy-link').on('click', function(){
    var url = $(this).data('copy');
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(url).then(function(){ toastOk('Link copied!'); });
    } else { prompt('Copy this link:', url); }
  });

  // ====== Variant selection (Modal) ======
  var selectedValues = {};  // attribute_id => attribute_value_id
  var pendingAction  = null; // "add" or "buy"

  function variantFromSelected() {
    if (!ATTRS || ATTRS.length === 0) return null;
    for (var i = 0; i < ATTRS.length; i++) {
      if (!selectedValues[ATTRS[i].id]) return null;
    }
    // Build a set of chosen value ids (order-agnostic)
    var chosenSet = {};
    ATTRS.forEach(function(a){ chosenSet[ selectedValues[a.id] ] = true; });

    for (var k = 0; k < VARIANTS.length; k++) {
      var v = VARIANTS[k];
      if (!v.value_ids || v.value_ids.length !== ATTRS.length) continue;
      var ok = true;
      for (var j = 0; j < v.value_ids.length; j++) {
        if (!chosenSet[ parseInt(v.value_ids[j],10) ]) { ok = false; break; }
      }
      if (ok) return v;
    }
    return null;
  }

  function refreshModalSummary(){
    var v = variantFromSelected();
    if (!v) {
      $('#variantPriceModal').text('—');
      $('#variantStockModal').text('—');
      $('#buyQtyModal').attr('max','');
      $('#variantConfirmBtn').prop('disabled', true);
      applyStockUI($('#variantStockModal'), null);
    } else {
      $('#variantPriceModal').text(money(v.price));
      applyStockUI($('#variantStockModal'), v.stock);

      // cap qty to available stock if provided
      if (v.stock != null && !isNaN(+v.stock) && +v.stock > 0) {
        $('#buyQtyModal').attr('max', +v.stock);
      } else {
        $('#buyQtyModal').attr('max', '');
      }
      // disable confirm if out of stock
      $('#variantConfirmBtn').prop('disabled', (v.stock != null && +v.stock <= 0));
    }
  }

  function openVariantModal(action){
    pendingAction = action;
    selectedValues = {};                 
    $('.js-attr-select-modal').val('');  
    $('#buyQtyModal').val(1).attr('max','');
    refreshModalSummary();
    $('#variantPickerModal').modal('show');
  }

  // keep qty within [1..max]
  $('#buyQtyModal').on('input change', function(){
    var max = parseInt($(this).attr('max') || '0', 10);
    var val = parseInt($(this).val() || '1', 10);
    if (isNaN(val) || val < 1) val = 1;
    if (max > 0 && val > max) val = max;
    $(this).val(val);
  });

  $(document).on('change', '.js-attr-select-modal', function(){
    var attrId = parseInt($(this).data('attribute-id'), 10);
    var valId  = $(this).val() ? parseInt($(this).val(), 10) : null;
    if (valId) selectedValues[attrId] = valId; else delete selectedValues[attrId];
    refreshModalSummary();
  });

  $('#variantConfirmBtn').on('click', function(){
    var v = variantFromSelected();
    if (!v) return;
    setMainVariantUI(v);
    var qty = parseInt($('#buyQtyModal').val() || '1', 10);
    if (isNaN(qty) || qty < 1) qty = 1;
    if (v.stock != null && !isNaN(+v.stock) && qty > +v.stock) qty = +v.stock;

    $('#variantPickerModal').modal('hide');

    if (pendingAction === 'add') doAddToCart(v.id, qty);
    else doBuyNow(v.id, qty);
  });

  // ====== AJAX Actions ======
  function doAddToCart(variantId, qty) {
    var payload = { work_id: WORK_ID, qty: qty };
    if (variantId) payload.variant_id = variantId;

    var $btn = $('.btn-add-to-cart');
    $btn.prop('disabled', true).text('Adding...');

    $.ajax({
      url: ADD_TO_CART_URL,
      method: 'POST',
      headers: csrfHeader(),
      contentType: 'application/json',
      data: JSON.stringify(payload)
    })
    .done(function(resp){
      if (resp && resp.status === 'success') {
        if (typeof resp.cart_count !== 'undefined') $('#mini-cart-count').text(resp.cart_count);
        toastOk('Added to cart');
      } else {
        toastErr(resp && resp.message ? resp.message : 'Failed to add');
      }
    })
    .fail(function(xhr){
      var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to add';
      toastErr(msg);
    })
    .always(function(){ $btn.prop('disabled', false).text('Add to Cart'); });
  }

  function doBuyNow(variantId, qty) {
    var payload = { work_id: WORK_ID, qty: qty };
    if (variantId) payload.variant_id = variantId;

    var $btn = $('.btn-buy-now');
    $btn.prop('disabled', true).text('Processing...');

    $.ajax({
      url: BUY_NOW_URL,
      method: 'POST',
      headers: csrfHeader(),
      contentType: 'application/json',
      data: JSON.stringify(payload)
    })
    .done(function(resp){
      if (resp && resp.status === 'success' && resp.redirect) {
        window.location.href = resp.redirect;
      } else {
        toastErr(resp && resp.message ? resp.message : 'Failed to start checkout');
      }
    })
    .fail(function(xhr){
      var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Purchase failed';
      toastErr(msg);
    })
    .always(function(){ $btn.prop('disabled', false).text('Buy Now'); });
  }

  // ====== Buttons ======
  $('.btn-add-to-cart').off('click').on('click', function(e){
    e.preventDefault();
    if (ATTRS && ATTRS.length > 0) {
      openVariantModal('add'); // always re-open
    } else {
      doAddToCart(null, 1);
    }
  });

  $('.btn-buy-now').off('click').on('click', function(e){
    e.preventDefault();
    if (ATTRS && ATTRS.length > 0) {
      openVariantModal('buy'); 
    } else {
      doBuyNow(null, 1);
    }
  });
});
</script>
@endpush


