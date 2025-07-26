@extends('layouts.app')

@section('title', 'Works')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <h3 class="font-weight-bold">Works</h3>
        </div>
    </div>

    {{-- Table --}}
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-success mb-3" id="addWorkBtn">Add Work</button>
                    <div class="table-responsive">
                        <table id="workTable" class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Work Image</th>
                                    <th>Left</th>
                                    <th>Right</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text category_id_error"></span>
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
                                <input type="text" name="tags" id="work_tags" class="form-control" placeholder="swim, portrait, latest">
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

                            {{-- Work Image --}}
                            <div class="col-md-6">
                                <label class="form-label" for="work_image">Work Image</label>
                                <input type="file" name="work_image" id="work_image" class="form-control" accept="image/*">
                                <span class="text-danger error-text work_image_error"></span>
                                <div class="mt-2">
                                    <img id="preview_work_image" src="" alt="" style="max-width:120px;display:none;border:1px solid #ddd;padding:2px;">
                                </div>
                            </div>

                            {{-- Left --}}
                            <div class="col-md-6">
                                <label class="form-label" for="work_image_left">Left Image</label>
                                <input type="file" name="image_left" id="work_image_left" class="form-control" accept="image/*">
                                <span class="text-danger error-text image_left_error"></span>
                                <div class="mt-2">
                                    <img id="preview_work_image_left" src="" alt="" style="max-width:120px;display:none;border:1px solid #ddd;padding:2px;">
                                </div>
                            </div>

                            {{-- Right --}}
                            <div class="col-md-6">
                                <label class="form-label" for="work_image_right">Right Image</label>
                                <input type="file" name="image_right" id="work_image_right" class="form-control" accept="image/*">
                                <span class="text-danger error-text image_right_error"></span>
                                <div class="mt-2">
                                    <img id="preview_work_image_right" src="" alt="" style="max-width:120px;display:none;border:1px solid #ddd;padding:2px;">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="art_video">Art Video</label>
                                <input type="file"
                                    name="art_video"
                                    id="art_video"
                                    class="form-control"
                                    accept="video/mp4,video/ogg,video/webm">
                                <span class="text-danger error-text art_video_error"></span>
                                <div class="mt-2">
                                <video id="preview_art_video" controls style="max-width:120px; display:none;">
                                    <source src="" type="video/mp4">
                                </video>
                                </div>
                            </div>

                            {{-- product Price --}}
                            <div class="col-md-6">
                                <label class="form-label" for="work_price">Price</label>
                                <input type="number" name="price" id="work_price" class="form-control" step="0.01" min="0">
                                <span class="text-danger error-text price_error"></span>
                            </div>

                            {{-- Product Quantity --}}
                            <div class="col-md-6">
                                <label class="form-label" for="work_quantity">Quantity</label>
                                <input type="number" name="quantity" id="work_quantity" class="form-control" min="0">
                                <span class="text-danger error-text quantity_error"></span>
                            </div>

                            {{-- Details --}}
                            <div class="col-12">
                                <label class="form-label" for="work_details">Details</label>
                                <textarea name="details" id="work_details" rows="4" class="form-control"></textarea>
                                <span class="text-danger error-text details_error"></span>
                            </div>

                            {{-- Gallery --}}
                            <div class="col-12">
                                <label class="form-label" for="work_gallery">Image Gallery (multiple)</label>
                                <input type="file" name="gallery_images[]" id="work_gallery" class="form-control" accept="image/*" multiple>
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
                        <button type="button" class="btn btn-secondary closeWorkModalBtn" data-bs-dismiss="modal">Close</button>
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
                            <img id="view_work_image" src="" class="img-fluid mb-3" alt="" style="max-height:250px;object-fit:contain;">
                            <div class="d-flex justify-content-center gap-3">
                                <img id="view_work_left" src="" class="img-thumbnail" style="max-width:100px;">
                                <img id="view_work_right" src="" class="img-thumbnail" style="max-width:100px;">
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
                    <img id="previewImage" src="" class="img-fluid" style="max-height: 500px; border-radius: 6px;">
                </div>
            </div>
        </div>
    </div>

</div><!-- /.content-wrapper -->
@endsection


@push('scripts')
<script>
$(function () {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')}
    });

    // DataTable
    let workTable = $('#workTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('works.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'category',   name: 'category' },
            { data: 'name',       name: 'name' },
            { data: 'work_date',  name: 'work_date' },
            { data: 'work_image', name: 'work_image', orderable:false, searchable:false },
            { data: 'image_left', name: 'image_left', orderable:false, searchable:false },
            { data: 'image_right',name: 'image_right', orderable:false, searchable:false },
            { data: 'price',      name: 'price' },
            { data: 'quantity',   name: 'quantity' },
            { data: 'tags',       name: 'tags' },
            { data: 'featured',   name: 'featured', orderable:false, searchable:false },
            { data: 'is_active',  name: 'is_active', orderable:false, searchable:false },
            { data: 'action',     name: 'action', orderable:false, searchable:false },
        ]
    });

    $('#art_video').on('change', function(){
        const file = this.files[0];
        if (!file) return;
        const url  = URL.createObjectURL(file);
        $('#preview_art_video source').attr('src', url);
        $('#preview_art_video').show()[0].load();
    });

    // Preview click (lightbox)
    $(document).on('click', '.preview-img', function(){
        let src = $(this).data('src');
        $('#previewImage').attr('src', src);
        $('#imagePreviewModal').modal('show');
    });

    // Add Work
    $('#addWorkBtn').click(function(){
        resetWorkForm();
        $('.modal-title', '#workModal').text('Add Work');
        $('#workModal').modal('show');
    });

    // Edit Work
    $('body').on('click', '.editWorkBtn', function(){
        const id = $(this).data('id');
        resetWorkForm();
        $('.modal-title', '#workModal').text('Edit Work');
        $.get("{{ url('works') }}/" + id + "/edit", function(data){
            $('#work_id').val(data.id);
            $('#work_category_id').val(data.category_id);
            $('#work_name').val(data.name);
            $('#work_date').val(data.work_date);
            $('#work_tags').val(data.tags);
            $('#work_details').val(data.details);
            $('#work_is_active').prop('checked', data.is_active);

            // main previews
            if (data.work_image_url) {
                $('#preview_work_image').attr('src', data.work_image_url).show();
            }
            if (data.image_left_url) {
                $('#preview_work_image_left').attr('src', data.image_left_url).show();
            }
            if (data.image_right_url) {
                $('#preview_work_image_right').attr('src', data.image_right_url).show();
            }
            //image price
            $('#work_price').val(data.work_price || '');
            $('#work_quantity').val(data.work_quantity || '');

            // existing gallery thumbs
            if (data.gallery && data.gallery.length) {
                $('#existing_gallery_wrapper').show();
                const $list = $('#existing_gallery_list').empty();
                data.gallery.forEach(function(g){
                    $list.append(`
                        <div class=\"position-relative d-inline-block\">
                            <img src=\"${g.image_url}\" class=\"img-thumbnail\" style=\"max-width:80px;\">
                            <button type=\"button\" class=\"btn btn-sm btn-danger position-absolute top-0 end-0 deleteGalleryImgBtn\" data-id=\"${g.id}\" title=\"Delete\">×</button>
                        </div>`);
                });
            } else {
                $('#existing_gallery_wrapper').hide();
            }

            $('#workModal').modal('show');
        });
    });

    // View Work
    $('body').on('click', '.viewWorkBtn', function(){
        const id = $(this).data('id');
        clearViewWorkModal();
        $.get("{{ url('works') }}/" + id, function(data){
            $('#viewWorkModalTitle').text(data.name);
            $('#view_work_image').attr('src', data.work_image);
            $('#view_work_left').attr('src', data.image_left);
            $('#view_work_right').attr('src', data.image_right);
            $('#view_work_category').text(data.category || '—');
            $('#view_work_name').text(data.name);
            $('#view_work_date').text(data.work_date || '—');
            $('#view_work_tags').text(data.tags || '—');
            $('#view_work_status').html(data.is_active ? '<span class=\"badge bg-success\">Active</span>' : '<span class=\"badge bg-secondary\">Inactive</span>');
            $('#view_work_created').text(data.created_at || '—');
            $('#view_work_updated').text(data.updated_at || '—');
            $('#view_work_details').html(data.details || '<em>No details.</em>');
            const $vwGal = $('#view_work_gallery').empty();
            if (data.gallery && data.gallery.length){
                data.gallery.forEach(g=>{
                    $vwGal.append(`<img src=\"${g.url}\" class=\"img-thumbnail preview-img\" data-src=\"${g.url}\" style=\"max-width:100px;cursor:pointer;\">`);
                });
            } else {
                $vwGal.html('<em>No gallery images.</em>');
            }
        });
        $('#viewWorkModal').modal('show');
    });

    // Delete Work
    $('body').on('click', '.deleteWorkBtn', function(){
        const id = $(this).data('id');
        confirmDeleteWork(id);
    });

    // Delete gallery image (edit modal)
    $('body').on('click', '.deleteGalleryImgBtn', function(){
        const gid = $(this).data('id');
        Swal.fire({
            title: 'Delete image?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete'
        }).then(res=>{
            if (res.isConfirmed) {
                $.ajax({
                    url: "{{ url('works/gallery') }}/" + gid,
                    type: 'DELETE',
                    success: function(resp){
                        Swal.fire('Deleted', resp.message, 'success');
                        // Remove thumbnail
                        $('.deleteGalleryImgBtn[data-id=\"'+gid+'\"]').closest('div.position-relative').remove();
                        // Hide wrapper if empty
                        if (!$('#existing_gallery_list').children().length) {
                            $('#existing_gallery_wrapper').hide();
                        }
                    },
                    error: function(){
                        Swal.fire('Error','Failed to delete.','error');
                    }
                });
            }
        });
    });

    // Feature button
    $('body').on('click', '.featureWorkBtn', function () {
        const id = $(this).data('id');
        confirmToggleFeature(id, true);
    });

    // Unfeature button
    $('body').on('click', '.unfeatureWorkBtn', function () {
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
                    success: function (resp) {
                        Swal.fire(action + 'd', resp.message, 'success');
                        workTable.ajax.reload(null, false);
                    },
                    error: function () {
                        Swal.fire('Error', `Failed to ${action.toLowerCase()} work.`, 'error');
                    }
                });
            }
        });
    }

    // Save Work (create/update)
    $('#workForm').submit(function(e){
        e.preventDefault();
        $('#workSaveBtn').text('Saving...').prop('disabled', true);
        $('.error-text').text('');

        let formData = new FormData(this);
        // is_active toggle (checkbox unchecked won't post)
        if (!$('#work_is_active').is(':checked')) {
            formData.set('is_active', '0');
        }

        $.ajax({
            url: "{{ route('works.store') }}",
            method: 'POST',
            data: formData,
            processData:false,
            contentType:false,
            dataType:'json',
            success: function(resp){
                $('#workModal').modal('hide');
                $('#workSaveBtn').text('Save').prop('disabled', false);
                Swal.fire('Success', resp.message, 'success');
                workTable.ajax.reload(null, false);
            },
            error: function(xhr){
                $('#workSaveBtn').text('Save').prop('disabled', false);
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key,val){
                        $('.'+key+'_error').text(val[0]);
                    });
                    Swal.fire('Validation Error','Please fix the highlighted fields.','error');
                } else {
                    Swal.fire('Error','Something went wrong.','error');
                }
            }
        });
    });

    // Confirm + delete helper
    function confirmDeleteWork(id){
        Swal.fire({
            title: 'Delete?',
            text: 'This work and its images will be deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete'
        }).then(result=>{
            if(result.isConfirmed){
                $.ajax({
                    url: "{{ url('works') }}/" + id,
                    type: 'DELETE',
                    success: function(resp){
                        Swal.fire('Deleted', resp.message, 'success');
                        workTable.ajax.reload(null, false);
                    },
                    error: function(){
                        Swal.fire('Error','Failed to delete.','error');
                    }
                });
            }
        });
    }

    // Reset form
    function resetWorkForm(){
        $('#workForm')[0].reset();
        $('#work_id').val('');
        $('.error-text').text('');
        $('#preview_work_image, #preview_work_image_left, #preview_work_image_right').hide();
        $('#work_gallery_preview').empty();
        $('#existing_gallery_wrapper').hide();
        $('#work_is_active').prop('checked', true);
    }

    // Clear view modal
    function clearViewWorkModal(){
        $('#viewWorkModalTitle').text('Work Details');
        $('#view_work_image').attr('src','');
        $('#view_work_left').attr('src','');
        $('#view_work_right').attr('src','');
        $('#view_work_category,#view_work_name,#view_work_date,#view_work_tags,#view_work_status,#view_work_created,#view_work_updated').text('');
        $('#view_work_details').empty();
        $('#view_work_gallery').empty();
    }

    // Local file preview helpers
    function previewImg(input, targetSel){
        const file = input.files && input.files[0];
        if(!file) return;
        const reader = new FileReader();
        reader.onload = e => $(targetSel).attr('src', e.target.result).show();
        reader.readAsDataURL(file);
    }
    $('#work_image').on('change', function(){ previewImg(this, '#preview_work_image'); });
    $('#work_image_left').on('change', function(){ previewImg(this, '#preview_work_image_left'); });
    $('#work_image_right').on('change', function(){ previewImg(this, '#preview_work_image_right'); });

    // Multi gallery preview
    $('#work_gallery').on('change', function(){
        const files = this.files;
        const $wrap = $('#work_gallery_preview').empty();
        if(!files.length) return;
        Array.from(files).forEach(file=>{
            const reader = new FileReader();
            reader.onload = e => {
                $wrap.append(`<img src=\"${e.target.result}\" class=\"img-thumbnail\" style=\"max-width:80px;\">`);
            };
            reader.readAsDataURL(file);
        });
    });

});
</script>
@endpush
