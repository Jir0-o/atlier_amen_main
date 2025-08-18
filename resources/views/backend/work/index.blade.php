@extends('layouts.app')

@section('title', 'Works')

<style>
    .modal .select2-container {
        z-index: 1061;
    }
    .modal .select2-container .select2-dropdown {
        z-index: 1061;
    }
</style>

@section('content')
    <div class="content-wrapper">
        {{-- Table --}}
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center">
                            <h3 class="font-weight-bold">Works</h3>
                            <button class="btn btn-primary mb-3" id="addWorkBtn">Add Work</button>
                        </div>
                        <div class="table-responsive">
                            <table id="workTable" class="table table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Name</th>
                                        <th>Work Type</th>
                                        <th>Date</th>
                                        <th>Work Image</th>
                                        <th>Left</th>
                                        <th>Right</th>
                                        {{-- <th>Price</th>
                                    <th>Quantity</th> --}}
                                        <th>Tags</th>
                                        <th>Featured</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                {{-- DataTables will fill tbody --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal: Create/Edit Work --}}
        <div class="modal fade" id="workModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Work</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="workForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="work_id">

                        <div class="modal-body">
                            <div class="row g-3">

                                {{-- Category --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="work_category_id">Category</label>
                                    <select name="category_id" id="work_category_id" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text category_id_error"></span>
                                </div>

                                {{-- Work Type --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="work_type">Work Type</label>
                                    <select name="work_type" id="work_type" class="form-control">
                                        <option value="art" selected>Art Work</option>
                                        <option value="book">Books</option>
                                    </select>
                                    <span class="text-danger error-text work_type_error"></span>
                                </div>

                                {{-- Name --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="work_name">Name</label>
                                    <input type="text" name="name" id="work_name" class="form-control">
                                    <span class="text-danger error-text name_error"></span>
                                </div>

                                {{-- Date --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="work_date">Date</label>
                                    <input type="date" name="work_date" id="work_date" class="form-control">
                                    <span class="text-danger error-text work_date_error"></span>
                                </div>

                                {{-- Tags --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="work_tags">Tags (comma)</label>
                                    <input type="text" name="tags" id="work_tags" class="form-control"
                                        placeholder="swim, portrait, latest">
                                    <span class="text-danger error-text tags_error"></span>
                                </div>

                                {{-- Is Active --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="work_is_active">Active</label>
                                    <select name="is_active" id="work_is_active" class="form-control">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <span class="text-danger error-text is_active_error"></span>
                                </div>

                                {{-- Work Image (Art only) --}}
                                <div class="col-md-6 art-only">
                                    <label class="form-label" for="work_image">Work Image</label>
                                    <input type="file" name="work_image" id="work_image" class="form-control" accept="image/*">
                                    <span class="text-danger error-text work_image_error"></span>
                                    <div class="mt-2">
                                        <img id="preview_work_image" src="" alt=""
                                            style="max-width:120px;display:none;border:1px solid #ddd;padding:2px;">
                                    </div>
                                </div>

                                {{-- Left (Art only) --}}
                                <div class="col-md-6 art-only">
                                    <label class="form-label" for="work_image_left">Left Image</label>
                                    <input type="file" name="image_left" id="work_image_left" class="form-control" accept="image/*">
                                    <span class="text-danger error-text image_left_error"></span>
                                    <div class="mt-2">
                                        <img id="preview_work_image_left" src="" alt=""
                                            style="max-width:120px;display:none;border:1px solid #ddd;padding:2px;">
                                    </div>
                                </div>

                                {{-- Right (Art only) --}}
                                <div class="col-md-6 art-only">
                                    <label class="form-label" for="work_image_right">Right Image</label>
                                    <input type="file" name="image_right" id="work_image_right" class="form-control" accept="image/*">
                                    <span class="text-danger error-text image_right_error"></span>
                                    <div class="mt-2">
                                        <img id="preview_work_image_right" src="" alt=""
                                            style="max-width:120px;display:none;border:1px solid #ddd;padding:2px;">
                                    </div>
                                </div>

                                {{-- Art Video (Art only) --}}
                                <div class="col-md-6 art-only">
                                    <label class="form-label" for="art_video">Art Video</label>
                                    <input type="file" name="art_video" id="art_video" class="form-control"
                                        accept="video/mp4,video/ogg,video/webm">
                                    <span class="text-danger error-text art_video_error"></span>
                                    <div class="mt-2">
                                        <video id="preview_art_video"
                                            style="max-width:120px;display:none;border:1px solid #ddd;padding:2px;"
                                            muted playsinline autoplay controls></video>
                                    </div>
                                </div>

                                {{-- Book PDF (Book only) --}}
                                <div class="col-md-6 book-only" style="display:none;">
                                <label class="form-label" for="book_pdf">PDF Book</label>
                                <input type="file" name="book_pdf" id="book_pdf" class="form-control" accept="application/pdf">
                                <span class="text-danger error-text book_pdf_error"></span>

                                {{-- Current PDF link (edit mode) --}}
                                <div class="mt-2" id="book_pdf_info" style="display:none;"></div>

                                {{-- Inline PDF preview for edit --}}
                                <iframe id="book_pdf_preview"
                                        style="width:100%;height:360px;border:1px solid #444;margin-top:8px;display:none;"></iframe>
                                </div>

                                {{-- Fallback Base Price --}}
                                {{-- <div class="col-md-6">
                                <label class="form-label" for="work_price">Base Price (if no variants)</label>
                                <input type="number" name="price" id="work_price" class="form-control" step="0.01" min="0">
                                <span class="text-danger error-text price_error"></span>
                            </div> --}}

                                {{-- Fallback Base Quantity --}}
                                {{-- <div class="col-md-6">
                                <label class="form-label" for="work_quantity">Base Quantity (if no variants)</label>
                                <input type="number" name="quantity" id="work_quantity" class="form-control" min="0">
                                <span class="text-danger error-text quantity_error"></span>
                            </div> --}}
                            <div class="col-md-12">
                             <label class="form-label" for="attributes">Attributes & Variants</label>
                                <p class="text-muted small">Pick multiple values per attribute. Then configure SKU / price
                                    / stock for each combination.</p>

                                <div class="row g-3 mb-3" id="variant-attributes-wrapper">
                                    @php
$allAttributes = \App\Models\Attribute::with('values')->get();
                                    @endphp

                                    @foreach ($allAttributes as $attribute)
                                        <div class="col-md-6">
                                            <label class="form-label">{{ $attribute->name }}</label>
                                            <select multiple class="form-select variant-attribute select2-attribute"
                                                data-attribute-id="{{ $attribute->id }}"
                                                data-attribute-name="{{ $attribute->name }}"
                                                data-attribute-slug="{{ \Illuminate\Support\Str::slug($attribute->name) }}">
                                                @foreach ($attribute->values as $val)
                                                    <option value="{{ $val->id }}" data-slug="{{ $val->slug }}">
                                                        {{ $val->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endforeach
                                </div>
                                </div>

                                <div class="table-responsive mb-2">
                                    <table class="table table-bordered text-light" id="variantTable">
                                        <thead>
                                            <tr>
                                                <th>Combination</th>
                                                <th>SKU</th>
                                                <th style="width:120px;">Price</th>
                                                <th style="width:120px;">Stock</th>
                                                <th style="width:80px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <input type="hidden" name="variants" id="variants_input">

                                {{-- Details --}}
                                <div class="col-12">
                                    <label class="form-label" for="work_details">Details</label>
                                    <textarea name="details" id="work_details" rows="4" class="form-control"></textarea>
                                    <span class="text-danger error-text details_error"></span>
                                </div>

                                {{-- Gallery --}}
                                <div class="col-12">
                                    <label class="form-label" for="work_gallery">Image Gallery (multiple)</label>
                                    <input type="file" name="gallery_images[]" id="work_gallery" class="form-control"
                                        accept="image/*" multiple>
                                    <span class="text-danger error-text gallery_images_error"></span>
                                    <div class="mt-2 d-flex flex-wrap gap-2" id="work_gallery_preview"></div>
                                </div>

                                {{-- Existing gallery (edit mode) --}}
                                <div class="col-12" id="existing_gallery_wrapper" style="display:none;">
                                    <hr>
                                    <h6>Existing Gallery</h6>
                                    <div class="d-flex flex-wrap gap-2" id="existing_gallery_list"></div>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closeWorkModalBtn"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="workSaveBtn">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- Modal: View Work --}}
        <div class="modal fade" id="viewWorkModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="viewWorkModalTitle" class="modal-title">Work Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6 text-center">
                                {{-- ART ONLY (view) --}}
                                <div class="art-only-view">
                                    <img id="view_work_image" src="" class="img-fluid mb-3" alt=""
                                        style="max-height:250px;object-fit:contain;">
                                    <div class="d-flex justify-content-center gap-3">
                                        <img id="view_work_left" src="" class="img-thumbnail" style="max-width:100px;">
                                        <img id="view_work_right" src="" class="img-thumbnail" style="max-width:100px;">
                                    </div>
                                    <div class="mt-3">
                                        <video id="view_work_video"
                                            style="max-width:100%;max-height:260px;border-radius:6px;display:none;"
                                            controls playsinline></video>
                                    </div>
                                </div>

                                {{-- BOOK ONLY (view) --}}
                                <div class="book-only-view" style="display:none;">
                                    <div id="view_book_pdf_info" class="mb-2"></div>
                                    <iframe id="view_work_pdf_frame"
                                        style="width:100%;height:420px;border:1px solid #444;display:none;"></iframe>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <dl class="row mb-0">
                                    <dt class="col-sm-4">Category:</dt>
                                    <dd class="col-sm-8" id="view_work_category"></dd>

                                    <dt class="col-sm-4">Name:</dt>
                                    <dd class="col-sm-8" id="view_work_name"></dd>

                                    <dt class="col-sm-4">Date:</dt>
                                    <dd class="col-sm-8" id="view_work_date"></dd>

                                    <dt class="col-sm-4">Tags:</dt>
                                    <dd class="col-sm-8" id="view_work_tags"></dd>

                                    <dt class="col-sm-4">Status:</dt>
                                    <dd class="col-sm-8" id="view_work_status"></dd>

                                    <dt class="col-sm-4">Created:</dt>
                                    <dd class="col-sm-8" id="view_work_created"></dd>

                                    <dt class="col-sm-4">Updated:</dt>
                                    <dd class="col-sm-8" id="view_work_updated"></dd>
                                </dl>
                            </div>

                            <div class="col-12">
                                <hr>
                                <h6>Variants</h6>
                                <div id="view_work_variants" class="table-responsive mb-3 text-light">

                                </div>
                                <div id="view_work_total_stock" class="small text-light"></div>
                            </div>

                        </div>

                        <div class="col-12">
                            <hr>
                            <h6>Details</h6>
                            <div id="view_work_details" class="small"></div>
                        </div>

                        <div class="col-12">
                            <hr>
                            <h6>Gallery</h6>
                            <div id="view_work_gallery" class="d-flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Close</button>
                </div>

            </div>
        </div>
    </div>

    {{-- Image Lightbox Preview (re-use from category) --}}
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0 shadow-none">
                <div class="modal-body text-center p-0">
                    <img id="previewImage" src="" class="img-fluid"
                        style="max-height: 500px; border-radius: 6px;">
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                }
            });

            function resolveAbsUrl(u) {
                if (!u) return null;
                if (/^https?:\/\//i.test(u)) return u;
                return window.location.origin + '/' + u.replace(/^\/+/, '');
                }

                function showVideo(url) {
                const v = document.getElementById('preview_art_video');
                if (!v) return;

                const abs = resolveAbsUrl(url);
                if (!abs) {
                    $(v).hide();
                    return;
                }

                // Clear any previous src then set new
                v.removeAttribute('src');
                v.src = abs;

                // (Re)load and show
                v.load();
                $(v).show();

                // Try to play (some browsers require user gesture)
                const p = v.play();
                if (p && typeof p.catch === 'function') {
                    p.catch(() => {
                    // If autoplay is blocked, keep controls visible so user can start it
                    v.controls = true;
                    });
                }
                }

            function setAndPlayVideo($videoEl, url) {
                const v = $videoEl.get(0);
                if (!v) return;
                const abs = resolveAbsUrl(url);
                if (!abs) {
                    $videoEl.hide();
                    v.pause?.();
                    v.removeAttribute('src');
                    return;
                }
                // Reset previous src to force reload
                v.pause?.();
                v.removeAttribute('src');
                v.src = abs;
                v.load();
                $videoEl.show();
                const p = v.play?.();
                if (p && typeof p.catch === 'function') {
                    p.catch(() => {
                    // If autoplay is blocked, keep controls visible
                    v.controls = true;
                    });
                }
            }

        let workTable = $('#workTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('works.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'category', name: 'category' },
                { data: 'name', name: 'name' },
                { data: 'work_type', name: 'work_type', orderable: true, searchable: true },

                { data: 'work_date', name: 'work_date' },
                { data: 'work_image', name: 'work_image', orderable: false, searchable: false },
                { data: 'image_left', name: 'image_left', orderable: false, searchable: false },
                { data: 'image_right', name: 'image_right', orderable: false, searchable: false },
                { data: 'tags', name: 'tags' },
                { data: 'featured', name: 'featured', orderable: false, searchable: false },
                { data: 'is_active', name: 'is_active', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        function toggleTypeUI(type) {
        if (type === 'book') {
            // Hide art-only; show book-only
            $('.art-only').hide();
            $('.book-only').show();

            // Clear art inputs + previews
            $('#work_image, #work_image_left, #work_image_right, #art_video').val('');
            $('#preview_work_image, #preview_work_image_left, #preview_work_image_right').hide().attr('src', '');

            const v = $('#preview_art_video').get(0);
            if (v) { v.pause?.(); v.removeAttribute('src'); }
            $('#preview_art_video').hide();

            // PDF preview stays controlled in the edit handler below
        } else {
            // Show art-only; hide book-only
            $('.art-only').show();
            $('.book-only').hide();

            // Clear PDF input + preview
            $('#book_pdf').val('');
            $('#book_pdf_info').hide().empty();
            $('#book_pdf_preview').hide().attr('src','');
        }
        }


            // Change handler
            $(document).on('change', '#work_type', function() {
                toggleTypeUI(this.value);
            });

            // When opening modal for "Add"
            $(document).on('click', '.openWorkCreateModalBtn', function(){
                // default to "art" unless you prefer last used
                $('#work_type').val('art').trigger('change');
            });

            // Preview click (lightbox)
            $(document).on('click', '.preview-img', function() {
                let src = $(this).data('src');
                $('#previewImage').attr('src', src);
                $('#imagePreviewModal').modal('show');
            });

            // Add Work
            $('#addWorkBtn').click(function() {
                resetWorkForm();
                $('.modal-title', '#workModal').text('Add Work');
                $('#workModal').modal('show');
            });
            // --- SELECT2 INIT ---
            function initAttributeSelects() {
                $('.select2-attribute').each(function () {
                    if (!$(this).data('select2')) {
                    $(this).select2({
                        placeholder: 'Select ' + $(this).data('attribute-name'),
                        allowClear: true,
                        width: '100%',
                        theme: 'bootstrap-5',
                        dropdownParent: $('#workModal') // good
                    });
                    }
                });
            }

            // Force Select2 to open downward inside the modal by scrolling it into view
            function forceSelect2DropDown($select) {
                const $modalBody = $('#workModal .modal-body');
                const $container = $select.next('.select2-container');

                // position() is relative to the first positioned ancestor (modal-body)
                const offsetTop = $container.position().top;
                const pad = 12;

                // Prevent re-entrancy loops
                if ($select.data('s2fixing')) return;
                $select.data('s2fixing', true);

                // Close → scroll → reopen so Select2 recalculates placement
                $select.select2('close');
                $modalBody.stop(true).animate(
                    { scrollTop: $modalBody.scrollTop() + offsetTop - pad },
                    120,
                    function () {
                        $select.select2('open');
                        // clear the guard shortly after reopening
                        setTimeout(() => $select.removeData('s2fixing'), 150);
                    }
                );
            }

            $(document).on('select2:open', '.select2-attribute', function () {
                // wait a tick so Select2 renders, then force downward
                const $sel = $(this);
                setTimeout(() => forceSelect2DropDown($sel), 0);
            });

            $('#art_video').on('change', function () {
                const file = this.files && this.files[0];
                if (!file) return;

                const objectUrl = URL.createObjectURL(file);
                showVideo(objectUrl);

                // Free the blob URL after it’s loaded
                $('#preview_art_video').one('loadeddata', function(){
                    URL.revokeObjectURL(objectUrl);
                });
            });


            // Cartesian product
            function cartesian(arrays) {
                if (!arrays.length) return [];
                return arrays.reduce((a, b) => a.flatMap(d => b.map(e => [...d, e])), [
                    []
                ]);
            }

            // Build variant rows
            function buildVariantsTable(workName = '') {
                const groups = [];
                $('.variant-attribute').each(function() {
                    const attrName = $(this).data('attribute-name');
                    const selected = $(this).select2('data') || [];
                    if (!selected.length) return;

                    const values = selected.map(opt => ({
                        id: opt.id,
                        value: opt.text,
                        slug: $(this).find(`option[value="${opt.id}"]`).data('slug') || opt.text
                            .toLowerCase().replace(/\s+/g, '-'),
                        attribute_name: attrName,
                    }));
                    groups.push(values);
                });

                const combinations = groups.length ? cartesian(groups) : [];
                const $tbody = $('#variantTable tbody');

                // preserve existing user input
                const existingMap = {};
                $tbody.find('tr').each(function() {
                    const key = $(this).data('combo-key');
                    existingMap[key] = {
                        price: $(this).find('.variant-price').val(),
                        stock: $(this).find('.variant-stock').val(),
                        sku: $(this).find('.variant-sku').val(),
                    };
                });

                $tbody.empty();

                if (!combinations.length) {
                    syncVariantsInput();
                    return;
                }

                combinations.forEach(combo => {
                    // group by attribute for display
                    const grouped = combo.reduce((acc, cur) => {
                        if (!acc[cur.attribute_name]) acc[cur.attribute_name] = [];
                        acc[cur.attribute_name].push(cur.value);
                        return acc;
                    }, {});
                    const comboText = Object.entries(grouped)
                        .map(([attr, vals]) => `${attr}: ${vals.join(', ')}`)
                        .join(' / ');

                    // combo key using slugs
                    const slugParts = combo.map(c => c.slug);
                    const comboKey = slugParts.join('|');

                    // default SKU
                    let baseSku = workName.toString().toLowerCase().trim()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                    if (!baseSku) baseSku = 'variant';
                    const combinationSlug = slugParts.join('-');
                    const defaultSku = baseSku + (combinationSlug ? '-' + combinationSlug : '');

                    const preserved = existingMap[comboKey] || {};
                    const priceVal = preserved.price || '';
                    const stockVal = preserved.stock || '';
                    const skuVal = preserved.sku || defaultSku;

                    const row = `
                <tr data-attribute-value-ids='${JSON.stringify(combo.map(c => c.id))}' data-combo-key="${comboKey}">
                    <td>${comboText}</td>
                    <td><input type="text" class="form-control form-control-sm variant-sku" value="${skuVal}" /></td>
                    <td><input type="number" min="0" step="0.01" class="form-control form-control-sm variant-price" value="${priceVal}" /></td>
                    <td><input type="number" min="0" class="form-control form-control-sm variant-stock" value="${stockVal}" /></td>
                    <td><button type="button" class="btn btn-sm btn-danger remove-variant">&times;</button></td>
                </tr>
            `;
                    $tbody.append(row);
                });

                syncVariantsInput();
            }

            // Sync hidden input
            function syncVariantsInput() {
                const variants = [];
                $('#variantTable tbody tr').each(function() {
                    const attrValueIds = $(this).data('attribute-value-ids') || [];
                    const sku = $(this).find('.variant-sku').val();
                    const price = $(this).find('.variant-price').val();
                    const stock = $(this).find('.variant-stock').val();
                    if (!attrValueIds.length) return;
                    variants.push({
                        attribute_value_ids: attrValueIds,
                        sku: sku,
                        price: price,
                        stock: stock,
                    });
                });
                $('#variants_input').val(JSON.stringify(variants));
            }

            // Remove variant row
            $(document).on('click', '.remove-variant', function() {
                $(this).closest('tr').remove();
                syncVariantsInput();
            });

            // Rebuild when attributes change
            $(document).on('change', '.variant-attribute', function() {
                const workName = $('#work_name').val() || '';
                buildVariantsTable(workName);
            });

            // Rebuild when work name changes (to update SKU base)
            $('#work_name').on('input', function() {
                const workName = $(this).val();
                buildVariantsTable(workName);
            });

            // Keep hidden input in sync when editing inputs
            $(document).on('input change', '.variant-price, .variant-stock, .variant-sku', function() {
                syncVariantsInput();
            });

            // Populate existing variant data on edit
            function populateVariantsOnEdit(payload) {
                if (!payload.variants) return;

                // Build map of attribute_id => Set of value ids used across all variants
                const attrValuesMap = {}; // attribute_id -> Set
                payload.variants.forEach(v => {
                    if (Array.isArray(v.attribute_values)) {
                        v.attribute_values.forEach(av => {
                            if (!attrValuesMap[av.attribute_id]) {
                                attrValuesMap[av.attribute_id] = new Set();
                            }
                            attrValuesMap[av.attribute_id].add(av.id);
                        });
                    } else if (Array.isArray(v.attribute_value_ids)) {
                        // fallback: we don't know attribute_id here, so can't assign to specific select
                        v.attribute_value_ids.forEach(avId => {
                            // nothing to do in this fallback
                        });
                    }
                });

                // Set each attribute multi-select with the aggregated values
                $('.variant-attribute').each(function() {
                    const attrId = $(this).data('attribute-id');
                    const valuesSet = attrValuesMap[attrId];
                    if (valuesSet) {
                        const valuesArray = Array.from(valuesSet);
                        $(this).val(valuesArray).trigger('change');
                    } else {
                        // clear if none
                        $(this).val(null).trigger('change');
                    }
                });

                // Rebuild table based on selected attributes and current work name
                const workName = $('#work_name').val() || '';
                buildVariantsTable(workName);

                // Fill in existing variant fields
                payload.variants.forEach(v => {
                    // derive comboKey (slugs) – prefer attribute_values if present
                    let slugs = [];
                    if (Array.isArray(v.attribute_values)) {
                        slugs = v.attribute_values.map(av => av.slug);
                    } else if (Array.isArray(v.attribute_value_ids)) {
                        slugs = v.attribute_value_ids.map(id => {
                            const opt = $(`.variant-attribute option[value="${id}"]`);
                            return opt.data('slug') || '';
                        }).filter(Boolean);
                    }
                    const comboKey = slugs.join('|');
                    const row = $(`#variantTable tbody tr[data-combo-key="${comboKey}"]`);
                    if (row.length) {
                        row.find('.variant-price').val(v.price);
                        row.find('.variant-stock').val(v.stock);
                        row.find('.variant-sku').val(v.sku);
                    }
                });

                // Sync hidden input
                syncVariantsInput();
            }


            $(document).on('shown.bs.modal', '#workModal', function() {
                initAttributeSelects();
                $('.select2-attribute').trigger('change.select2');
            });
            $('#work_name').on('input', function() {
                const workName = $(this).val();
                buildVariantsTable(workName);
            });

            function showErrors(errors) {
                // clear previous
                $('.error-text').text('');
                $('#variant_errors').text('');

                Object.entries(errors).forEach(([key, msgs]) => {
                    const message = Array.isArray(msgs) ? msgs[0] : msgs;
                    if (key.startsWith('variants')) {

                        const humanKey = key.replace(/\./g, ' ');
                        $('#variant_errors').append(`<div>${humanKey}: ${message}</div>`);
                    } else {
                        const safe = key.replace(/\./g, '_');
                        const selector = `.${safe}_error`;
                        if ($(selector).length) {
                            $(selector).text(message);
                        } else {
                            console.warn('Unmapped error field', key, message);
                        }
                    }
                });
            }

            //edit work
            $('body').on('click', '.editWorkBtn', function() {
                const id = $(this).data('id');
                resetWorkForm();
                $('.modal-title', '#workModal').text('Edit Work');

                $.get("{{ url('works') }}/" + id + "/edit", function(data) {
                    console.log(data);
                    $('#work_id').val(data.id);
                    $('#work_category_id').val(data.category_id);
                    $('#work_name').val(data.name);
                    $('#work_date').val(data.work_date);
                    $('#work_tags').val(data.tags);
                    $('#work_details').val(data.details);
                    $('#work_is_active').val(data.is_active ? "1" : "0");

                    var type = (data.work_type === 'book') ? 'book' : 'art';
                    $('#work_type').val(type);
                    toggleTypeUI(type);

                    if (type === 'book') {
                    if (data.book_pdf_url) {
                        $('#book_pdf_info')
                        .show()
                        .html('<small class="text-muted">Current PDF: <a target="_blank" href="'+data.book_pdf_url+'">Open in new tab</a></small>');

                        // Show inline preview
                        $('#book_pdf_preview')
                        .attr('src', data.book_pdf_url)
                        .show();
                    } else {
                        $('#book_pdf_info').hide().empty();
                        $('#book_pdf_preview').hide().attr('src','');
                    }
                    }

                    // Previews (only for art)
                    if (type === 'art') {
                    if (data.art_video_url) {
                        showVideo(data.art_video_url);
                    } else {
                        $('#preview_art_video').hide().get(0)?.pause();
                        $('#preview_art_video').removeAttr('src');
                    }

                    if (data.work_image_url) {
                        $('#preview_work_image').attr('src', data.work_image_url).show();
                    }
                    if (data.image_left_url) {
                        $('#preview_work_image_left').attr('src', data.image_left_url).show();
                    }
                    if (data.image_right_url) {
                        $('#preview_work_image_right').attr('src', data.image_right_url).show();
                    }
                    }

                    // existing gallery thumbs
                    if (data.gallery && data.gallery.length) {
                        $('#existing_gallery_wrapper').show();
                        const $list = $('#existing_gallery_list').empty();
                        data.gallery.forEach(function(g) {
                            $list.append(`
                                <div class="d-inline-flex align-items-center me-2 mb-2" data-gid="${g.id}">
                                    <img src="${g.image_url}" class="img-thumbnail" style="width:80px;height:80px;object-fit:cover;">
                                    <button type="button" class="btn btn-sm btn-danger ms-1 deleteGalleryImgBtn" data-id="${g.id}" title="Delete">×</button>
                                </div>
                            `);
                        });
                    } else {
                        $('#existing_gallery_wrapper').hide();
                    }

                    initAttributeSelects();
                    setTimeout(() => { populateVariantsOnEdit(data); }, 0);

                    $('#workModal').modal('show');
                });
            });


            // View Work
            $('body').on('click', '.viewWorkBtn', function() {
                const id = $(this).data('id');
                clearViewWorkModal();

                $.get("{{ url('works') }}/" + id, function(data) {
                    $('#viewWorkModalTitle').text(data.name);
                    $('#view_work_category').text(data.category || '—');
                    $('#view_work_name').text(data.name);
                    $('#view_work_date').text(data.work_date || '—');
                    $('#view_work_tags').text(data.tags || '—');
                    $('#view_work_status').html(data.is_active ?
                        '<span class="badge bg-success">Active</span>' :
                        '<span class="badge bg-secondary">Inactive</span>');
                    $('#view_work_created').text(data.created_at || '—');
                    $('#view_work_updated').text(data.updated_at || '—');
                    $('#view_work_details').html(data.details || '<em>No details.</em>');

                    const type = (data.work_type === 'book') ? 'book' : 'art';

                    if (type === 'book') {
                    $('.art-only-view').hide();
                    $('.book-only-view').show();

                    if (data.book_pdf_url) {
                        $('#view_book_pdf_info').html(
                        '<a target="_blank" href="'+data.book_pdf_url+'" class="btn btn-sm btn-outline-light">Open PDF in new tab</a>'
                        );
                        $('#view_work_pdf_frame').attr('src', data.book_pdf_url).show();
                    } else {
                        $('#view_book_pdf_info').html('<em>No PDF attached.</em>');
                        $('#view_work_pdf_frame').hide().attr('src','');
                    }
                    } else {
                    $('.book-only-view').hide();
                    $('.art-only-view').show();

                    // Be flexible about keys: *_url or bare
                    const mainImg  = data.work_image_url  || data.work_image;
                    const leftImg  = data.image_left_url  || data.image_left;
                    const rightImg = data.image_right_url || data.image_right;
                    const videoSrc = data.art_video_url   || data.art_video;

                    if (mainImg) { $('#view_work_image').attr('src', mainImg).show(); }
                    else { $('#view_work_image').hide().attr('src',''); }

                    if (leftImg) { $('#view_work_left').attr('src', leftImg).show(); }
                    else { $('#view_work_left').hide().attr('src',''); }

                    if (rightImg) { $('#view_work_right').attr('src', rightImg).show(); }
                    else { $('#view_work_right').hide().attr('src',''); }

                    if (videoSrc) {
                        setAndPlayVideo($('#view_work_video'), videoSrc);
                    } else {
                        const v = $('#view_work_video').get(0);
                        if (v) { v.pause?.(); v.removeAttribute('src'); }
                        $('#view_work_video').hide();
                    }
                    }

                    // Variants table (unchanged)
                    const $variantContainer = $('#view_work_variants').empty();
                    let totalStock = 0;
                    if (data.variants && data.variants.length) {
                        let rows = '';
                        data.variants.forEach(v => {
                            totalStock += parseInt(v.stock || 0, 10);
                            rows += `
                                <tr>
                                    <td>${escapeHtml(v.combination_text)}</td>
                                    <td>${escapeHtml(v.sku)}</td>
                                    <td>${v.price !== null ? parseFloat(v.price).toFixed(2) : '—'}</td>
                                    <td>${v.stock !== null ? v.stock : '—'}</td>
                                </tr>
                            `;
                        });

                        $variantContainer.html(`
                            <table class="table table-sm table-bordered text-light">
                                <thead>
                                    <tr>
                                        <th>Combination</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>${rows}</tbody>
                            </table>
                        `);
                        $('#view_work_total_stock').text(`Total stock across variants: ${totalStock}`);
                    } else {
                        $variantContainer.html('<div><em>No variants. Showing base price/quantity if available.</em></div>');
                        $('#view_work_total_stock').text('');
                    }

                    // Gallery (unchanged)
                    const $vwGal = $('#view_work_gallery').empty();
                    if (data.gallery && data.gallery.length) {
                        data.gallery.forEach(g => {
                            $vwGal.append(`<img src="${g.url}" class="img-thumbnail preview-img" data-src="${g.url}" style="max-width:100px;cursor:pointer;">`);
                        });
                    } else {
                        $vwGal.html('<em>No gallery images.</em>');
                    }

                    $('#viewWorkModal').modal('show');
                });
            });


            function escapeHtml(str) {
                if (typeof str !== 'string') return str;
                return str
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            // Delete Work
            $('body').on('click', '.deleteWorkBtn', function() {
                const id = $(this).data('id');
                confirmDeleteWork(id);
            });

            // Delete gallery image (edit modal)
            $('body').on('click', '.deleteGalleryImgBtn', function() {
            const gid = $(this).data('id');

            Swal.fire({
                title: 'Delete image?',
                text: 'This cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete'
            }).then(res => {
                if (!res.isConfirmed) return;

                $.ajax({
                url: "{{ url('works/gallery') }}/" + gid,
                type: 'DELETE',
                success: function(resp) {
                    Swal.fire('Deleted', resp.message || 'Gallery image removed.', 'success');

                    // Remove the thumbnail wrapper
                    $('#existing_gallery_list').find(`[data-gid="${gid}"]`).remove();

                    // Hide wrapper if empty
                    if (!$('#existing_gallery_list').children().length) {
                    $('#existing_gallery_wrapper').hide();
                    }
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Failed to delete.';
                    Swal.fire('Error', msg, 'error');
                }
                });
            });
            });

            // Feature button
            $('body').on('click', '.featureWorkBtn', function() {
                const id = $(this).data('id');
                confirmToggleFeature(id, true);
            });

            // Unfeature button
            $('body').on('click', '.unfeatureWorkBtn', function() {
                const id = $(this).data('id');
                confirmToggleFeature(id, false);
            });

            // Unified Feature/Unfeature Confirmation
            function confirmToggleFeature(id, makeFeature) {
                const action = makeFeature ? 'Feature' : 'Unfeature';
                Swal.fire({
                    title: `${action} this work?`,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: action
                }).then(res => {
                    if (res.isConfirmed) {
                        $.ajax({
                            url: "{{ url('works/toggle-feature') }}/" + id,
                            type: 'POST',
                            data: {
                                _method: 'PUT',
                                _token: '{{ csrf_token() }}',
                                is_featured: makeFeature ? 1 : 0
                            },
                            success: function(resp) {
                                Swal.fire(action + 'd', resp.message, 'success');
                                workTable.ajax.reload(null, false);
                            },
                            error: function() {
                                Swal.fire('Error', `Failed to ${action.toLowerCase()} work.`,
                                    'error');
                            }
                        });
                    }
                });
            }

            // Save Work (create/update)
            $('#workForm').submit(function(e) {
                e.preventDefault();
                syncVariantsInput();

                $('#workSaveBtn').text('Saving...').prop('disabled', true);
                $('.error-text').text('');
                $('#variant_errors').text('');

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('works.store') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(resp) {
                        $('#workModal').modal('hide');
                        $('#workSaveBtn').text('Save').prop('disabled', false);
                        Swal.fire('Success', resp.message, 'success');
                        workTable.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        $('#workSaveBtn').text('Save').prop('disabled', false);
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors || {};
                            showErrors(errors);
                            Swal.fire('Validation Error', 'Please fix the highlighted fields.',
                                'error');
                        } else {
                            Swal.fire('Error', 'Something went wrong.', 'error');
                        }
                    }
                });
            });


            // Confirm + delete helper
            function confirmDeleteWork(id) {
                Swal.fire({
                    title: 'Delete?',
                    text: 'This work and its images will be deleted!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('works') }}/" + id,
                            type: 'DELETE',
                            success: function(resp) {
                                Swal.fire('Deleted', resp.message, 'success');
                                workTable.ajax.reload(null, false);
                            },
                            error: function() {
                                Swal.fire('Error', 'Failed to delete.', 'error');
                            }
                        });
                    }
                });
            }

            // Reset form
            function resetWorkForm() {
                $('#workForm')[0].reset();
                $('#work_id').val('');
                $('.error-text').text('');
                $('#preview_work_image, #preview_work_image_left, #preview_work_image_right').hide();
                $('#work_gallery_preview').empty();
                $('#existing_gallery_wrapper').hide();
                $('#work_is_active').prop('checked', true);
                $('#art_video').val('');
                $('#preview_art_video').removeAttr('src').hide();
                //reset variants
                $('#variants').empty();
                $('#variant_errors').text('');
                $('#variant_name').val('');
                $('#variant_price').val('');
                $('#variant_sku').val('');
                $('#variant_quantity').val('');
                $('#variantTable tbody').empty();
                $('#variants_input').val('[]');

            }

            // Clear view modal
            function clearViewWorkModal() {
                $('#viewWorkModalTitle').text('Work Details');
                $('#view_work_image').attr('src', '');
                $('#view_work_left').attr('src', '');
                $('#view_work_right').attr('src', '');
                $('#view_work_category,#view_work_name,#view_work_date,#view_work_tags,#view_work_status,#view_work_created,#view_work_updated')
                    .text('');
                $('#view_work_details').empty();
                $('#view_work_gallery').empty();
            }

            // Local file preview helpers
            function previewImg(input, targetSel) {
                const file = input.files && input.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => $(targetSel).attr('src', e.target.result).show();
                reader.readAsDataURL(file);
            }
            $('#work_image').on('change', function() {
                previewImg(this, '#preview_work_image');
            });
            $('#work_image_left').on('change', function() {
                previewImg(this, '#preview_work_image_left');
            });
            $('#work_image_right').on('change', function() {
                previewImg(this, '#preview_work_image_right');
            });

            // Multi gallery preview
            $('#work_gallery').on('change', function() {
                const files = this.files;
                const $wrap = $('#work_gallery_preview').empty();
                if (!files.length) return;
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        $wrap.append(
                            `<img src=\"${e.target.result}\" class=\"img-thumbnail\" style=\"max-width:80px;\">`
                            );
                    };
                    reader.readAsDataURL(file);
                });
            });

        });
    </script>
@endpush
