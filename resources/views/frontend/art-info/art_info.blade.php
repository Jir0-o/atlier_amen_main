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
            <div class="row justify-content-xxl-center">

              {{-- Main Image + Video + Gallery --}}
              <div class="col-sm-5 mb-4">
                <div class="indi-img-box recent-img-box" data-aos="flip-left" data-aos-duration="2000" style="position:relative;">

                    {{-- Keep BOTH elements in DOM. Toggle visibility with inline style --}}
                    @php 
                      $hasVideo    = !empty($work->art_video);
                      $videoUrl    = $hasVideo ? asset($work->art_video) : '';
                      $bookPdf      = !empty($work->book_pdf);
                      $bookPdfUrl  = $bookPdf ? asset($work->book_pdf) : '';
                    @endphp


                    <iframe
                        src="{{ $bookPdfUrl }}"
                        class="indi-video-preview indi-img-preview"
                        id="book_previewer"
                        style="height:500px; width:100%;border-radius:12px; {{ $bookPdf ? '' : 'display:none;' }}">
                    </iframe>
                    {{-- Main video (shown first if exists) --}}
                    <video
                        src="{{ $videoUrl }}"
                        class="indi-video-preview indi-img-preview"
                        id="video_previewer"
                        controls
                        autoplay
                        style="width:100%;border-radius:12px; {{ $hasVideo ? '' : 'display:none;' }}">
                    </video>

                    @if($work->work_type === 'art')
                    {{-- Main image (always present; hidden if video is active initially) --}}
                    <img
                        src="{{ $work->work_image_url ?? $work->work_image_low_url ?? '' }}"
                        alt="{{ $work->name }}"
                        id="indi-img-preview"
                        loading="lazy"
                        class="img-fluid w-100"
                        style="{{ $hasVideo ? 'display:none;' : '' }}">

                    {{-- Hover Images: ALWAYS render if provided (so they work after switching to image) --}}
                    @if(!empty($work->image_left))
                        <img class="recent-img-hover img-left"
                            src="{{ asset($work->image_left) }}"
                            alt="{{ $work->name }} Left Hover"
                            loading="lazy"
                            style="{{ $hasVideo ? 'display:none;' : '' }}">
                    @endif

                    @if(!empty($work->image_right))
                        <img class="recent-img-hover img-right"
                            src="{{ asset($work->image_right) }}"
                            alt="{{ $work->name }} Right Hover"
                            loading="lazy"
                            style="{{ $hasVideo ? 'display:none;' : '' }}">
                    @endif
                    @endif
                </div>

                {{-- Gallery Thumbs --}}
                <div class="indi-img-gallery my-4">
                  <div class="row">

                    {{-- 1st thumb: VIDEO as POSTER IMG (if main video exists) --}}
                    @php
                      $videoPoster = asset('frontend-css/img/webimg/video-placeholder.jpg');
                    @endphp
                    @if (!empty($work->book_pdf))
                      <div class="col-3 p-3">
                        <div class="active">
                          <div class="video-thumb-wrapper" style="position:relative;">
                            <iframe
                                src="{{ asset($work->book_pdf) }}#toolbar=1&navpanes=1&scrollbar=1"
                                type="application/pdf"
                                frameborder="0"
                                style="width:100%; height:300px; border-radius:8px;"></iframe>
                          </div>
                        </div>
                      </div>
                    @endif
                    @if(!empty($work->art_video))
                      <div class="col-3 p-3">
                        <div class="active">
                          <div class="video-thumb-wrapper" style="position:relative;">
                            <img
                              src="{{ $videoPoster }}"
                              alt="Video"
                              class="indi-thumb-video-img img-thumb"
                              data-type="video"
                              data-src="{{ asset($work->art_video) }}"
                              loading="lazy"
                              style="width:100%;border-radius:8px;cursor:pointer">
                            <span class="thumb-play-badge" aria-hidden="true">▶</span>
                          </div>
                        </div>
                      </div>
                    @endif

                    @if ($work->work_type === 'art')
                    {{-- 2nd thumb: main IMAGE --}}
                    @if(!empty($work->work_image_url ?? $work->work_image_low_url))
                      <div class="col-3 p-3">
                        <div @if(empty($work->art_video)) class="active" @endif>
                          <img
                            src="{{ $work->work_image_low_url ?? $work->work_image_url }}"
                            data-full="{{ $work->work_image_url ?? $work->work_image_low_url }}"
                            data-type="img"
                            alt="Main Image"
                            class="indi-thumb-img img-thumb"
                            loading="lazy"
                            style="width:100%;border-radius:8px;cursor:pointer">
                        </div>
                      </div>
                    @endif
                    @endif

                    {{-- Remaining gallery images/videos --}}
                    @if($work->gallery && $work->gallery->isNotEmpty())
                      @foreach($work->gallery as $g)
                        @php
                          $isVideo  = !empty($g->video_url);
                          $thumbSrc = $g->image_low_url ?? $g->image_url ?? '';
                          $fullSrc  = $g->image_url ?? $thumbSrc;
                        @endphp
                        <div class="col-3 p-3">
                          <div>
                            @if($isVideo)
                              <div class="video-thumb-wrapper" style="position:relative;">
                                <img
                                  src="{{ $videoPoster }}"
                                  alt="Video"
                                  class="indi-thumb-video-img img-thumb"
                                  data-type="video"
                                  data-src="{{ asset($g->video_url) }}"
                                  loading="lazy"
                                  style="width:100%;border-radius:8px;cursor:pointer">
                                <span class="thumb-play-badge" aria-hidden="true">▶</span>
                              </div>
                            @else
                              <img
                                src="{{ $thumbSrc }}"
                                data-full="{{ $fullSrc }}"
                                data-type="img"
                                alt="Gallery Image"
                                class="indi-thumb-img img-thumb"
                                loading="lazy"
                                style="width:100%;border-radius:8px;cursor:pointer">
                            @endif
                          </div>
                        </div>
                      @endforeach
                    @endif
                  </div>
                </div>
              </div>

                {{-- Info --}}
                <div class="col-sm-8 col-md-7 mb-4">
                    <div class="px-xxl-5" data-aos="fade-up" data-aos-duration="2000">
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

                            {{-- Live Variant Price/Stock --}}
                            <div class="mt-3">
                                <h4 class="playfair fw-bold mb-2">Price: <strong id="variantPrice">—</strong></h4>
                                <h4 class="playfair fw-bold mb-3"> Stock: <strong id="variantStock"></strong></h4>
                                <small id="lowStockHint" class="text-warning" style="display:none;">Only <span id="lowStockCount">0</span> left — order soon.</small>
                            </div>

                            <div id="outOfStockGlobal" class="alert alert-warning mt-3" style="display:none;">
                              Product is out of stock.
                            </div>

                            {{-- Cart / Buy --}}
                            @feature('shop_enabled')
                            <div class="row">
                                @feature('cart_enabled')
                                <div class="col-md-4 mb-2">
                                    <div class="d-flex flex-column">
                                        <button
                                            type="button"
                                            class="btn btn-outline-light btn-add-to-cart"
                                            data-work-id="{{ $work->id }}"
                                            data-action-url="{{ route('cart.add') }}">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                                @endfeature
                                @feature('buy_now_enabled')
                                <div class="col-md-4 mb-2">
                                    <div class="d-flex flex-column">
                                        <button
                                            type="button"
                                            class="btn btn-warning text-white btn-buy-now"
                                            data-work-id="{{ $work->id }}"
                                            data-action-url="{{ route('cart.buyNow') }}">
                                            Buy Now
                                        </button>
                                    </div>
                                </div>
                                @endfeature
                                @feature('wishlist_enabled')
                                <div class="col-md-4">
                                    <div class="d-flex flex-column">
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger btn-add-to-wishlist"
                                            data-work-id="{{ $work->id }}"
                                            data-action-url="{{ route('wishlist.add') }}">
                                            Add to Wishlist
                                        </button>
                                    </div>
                                </div>
                                @endfeature
                            </div>
                            @endfeature

                            
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
                                    Copy Link
                                </button>
                            </div>
                            {{-- Hidden state for selected variant --}}
                            <input type="hidden" id="selectedVariantId" value="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- portrait information end -->
    </div>
</main>

{{-- Variant Picker Modal --}}
<div class="modal fade" id="variantPickerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Choose Options</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        {{-- Attribute dropdowns --}}
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
            <div><strong id="variantStockModal"></strong></div>
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

  var ALL_OUT = @json($allOut ?? false);

    var IN_STOCK_VALUE_IDS = new Set();
  (VARIANTS || []).forEach(function(v) {
    if (v.stock == null || +v.stock > 0) {
      (v.value_ids || []).forEach(function(valId){
        IN_STOCK_VALUE_IDS.add(parseInt(valId,10));
      });
    }
  });

  // ====== Helpers ======
  function csrfHeader() { return { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }; }
  function toastOk(msg){ if (window.Swal) Swal.fire({icon:'success',title:msg,timer:1200,showConfirmButton:false}); else alert(msg); }
  function toastErr(msg){ if (window.Swal) Swal.fire({icon:'error',title:msg,timer:1500,showConfirmButton:false}); else alert(msg); }
  function money(n){ n = parseFloat(n||0); if (isNaN(n)) n = 0; return n.toFixed(2); }

    $('.btn-add-to-wishlist').off('click').on('click', function(e){
        e.preventDefault();
        const $btn = $(this);
        const url  = $btn.data('action-url');
        const wid  = parseInt($btn.data('work-id'),10);

        $btn.prop('disabled', true).text('Adding...');
        $.ajax({
          url: url,
          method: 'POST',
          headers: csrfHeader(),
          contentType: 'application/json',
          data: JSON.stringify({ work_id: wid })
        })
        .done(function(resp){
          if (resp.status === 'success') {
            $('#mini-wishlist-count').text(resp.count || 0);
            toastOk('Added to wishlist');
          } else {
            toastErr(resp.message || 'Failed to add to wishlist');
          }
        })
        .fail(function(xhr){
          toastErr(xhr.responseJSON?.message || 'Failed to add to wishlist');
        })
        .always(function(){
          $btn.prop('disabled', false).text('Add to Wishlist');
        });
      });

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
    if (stock > 0) {
      $el.text(stock).addClass('text-danger');
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

  if (ALL_OUT) {
    $('.btn-add-to-cart, .btn-buy-now').hide();
    $('#outOfStockGlobal').show();
  } else {
    $('.btn-add-to-cart, .btn-buy-now').show();
    $('#outOfStockGlobal').hide();
  }

  var $box       = $('.indi-img-box.recent-img-box');
  var $mainImg   = $('#indi-img-preview');
  var $mainVideo = $('#video_previewer');

  function setActive($thumb){
    $('.indi-img-gallery .active').removeClass('active');
    $thumb.closest('.col-3').children('div').first().addClass('active');
  }

  function showImage(src){
    if (src) $mainImg.attr('src', src);
    $mainVideo.get(0)?.pause?.();
    $mainVideo.hide();
    $mainImg.show();
    $box.find('.recent-img-hover').show();
  }

  function showVideo(src){
    if (src) $mainVideo.attr('src', src);
    $mainImg.hide();
    $box.find('.recent-img-hover').hide();
    $mainVideo.show();
    // Ensure playback starts
    const el = $mainVideo.get(0);
    try {
      el?.pause?.();
      el?.load?.();   
      const p = el?.play?.();
      if (p && typeof p.then === 'function') { p.catch(()=>{}); }
    } catch(e){}
  }

  // Image thumb -> show image
  $(document).on('click', '.indi-thumb-img', function(){
    var fullSrc = $(this).data('full') || $(this).attr('src');
    showImage(fullSrc);
    setActive($(this));
  });

  // NEW: Video poster image thumb -> show video
  $(document).on('click', '.indi-thumb-video-img', function(){
    var vidSrc = $(this).data('src');
    showVideo(vidSrc);
    setActive($(this));
  });

  // (Optional) if you still keep <video> thumbs anywhere:
  $(document).on('click', '.indi-thumb-video', function(){
    var vidSrc = $(this).data('src') || $(this).attr('src');
    showVideo(vidSrc);
    setActive($(this));
  });

  // On load: if video exists, make sure it's visible/playing and hover overlays are hidden
  if ($mainVideo.length && $mainVideo.attr('src')) {
    showVideo($mainVideo.attr('src'));
    const $firstVidThumb = $('.indi-img-gallery .indi-thumb-video').first();
    if ($firstVidThumb.length) setActive($firstVidThumb);
  } else {
    showImage($mainImg.attr('src'));
    const $firstImgThumb = $('.indi-img-gallery .indi-thumb-img').first();
    if ($firstImgThumb.length) setActive($firstImgThumb);
  }


  // Copy link (unchanged but resilient)
  $(document).on('click', '.js-copy-link', function(){
    var url = $(this).data('copy');
    if (!url) return;
    if (navigator.clipboard?.writeText) {
      navigator.clipboard.writeText(url).then(function(){
        if (typeof Swal !== 'undefined') {
          Swal.fire({icon:'success', title:'Copied', text:'Link copied to clipboard.'});
        } else if (typeof toastOk === 'function') {
          toastOk('Link copied!');
        } else {
          alert('Link copied!');
        }
      });
    } else {
      prompt('Copy this link:', url);
    }
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
      $('#variantPriceModal').text('');
      $('#variantStockModal').text('');
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

      // Disable options that are always OOS
      $('.js-attr-select-modal').each(function(){
        $(this).find('option').each(function(){
          var val = parseInt($(this).attr('value') || '0', 10);
          if (!val) return; // skip placeholder
          var ok = IN_STOCK_VALUE_IDS.has(val);
          $(this).prop('disabled', !ok);
          // Optional: mark text
          var t = $(this).text().replace(/\s*\(Out of stock\)$/, '');
          if (!ok) t += ' (Out of stock)';
          $(this).text(t);
        });
      });

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
        //refesh the page
        window.location.reload();
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


