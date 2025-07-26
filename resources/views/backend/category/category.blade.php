@extends('layouts.app')

@section('title', 'Category')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Category</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-success mb-3" id="addCategoryBtn">Add Category</button>
                        <div class="table-responsive">
                            <table id="categoryTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Category Image</th>
                                        <th>Left Image</th>
                                        <th>Right Image</th>
                                        <th>VIP Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="categoryForm">
                        @csrf
                        <input type="hidden" name="id" id="category_id">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control">
                                <span class="text-danger error-text slug_error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="category_image" class="form-label">Category Image</label>
                                <input type="file" name="category_image" id="category_image" class="form-control" accept="image/*">
                                <span class="text-danger error-text category_image_error"></span>
                                <div class="mt-2">
                                    <img id="preview_category_image" src="" alt="" style="max-width:120px;display:none;border:1px solid #ddd;padding:2px;">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image_left" class="form-label">Left Image</label>
                                <input type="file" name="image_left" id="image_left" class="form-control" accept="image/*">
                                <span class="text-danger error-text image_left_error"></span>
                                <div class="mt-2">
                                    <img id="preview_image_left" src="" alt="" style="max-width:120px;display:none;border:1px solid #ddd;padding:2px;">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image_right" class="form-label">Right Image</label>
                                <input type="file" name="image_right" id="image_right" class="form-control" accept="image/*">
                                <span class="text-danger error-text image_right_error"></span>
                                <div class="mt-2">
                                    <img id="preview_image_right" src="" alt="" style="max-width:120px;display:none;border:1px solid #ddd;padding:2px;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="checkbox" name="vip" id="is_vip" class="form-check-input">
                                <label for="is_vip" class="form-check-label">Is VIP</label>
                                <span class="text-danger error-text is_vip_error"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img id="previewImage" src="" class="img-fluid" style="max-height: 500px; border-radius: 6px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    
<script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    let table = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('categories.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'category_image', name: 'category_image', orderable: false, searchable: false },
            { data: 'image_left', name: 'image_left', orderable: false, searchable: false },
            { data: 'image_right', name: 'image_right', orderable: false, searchable: false },
            { data: 'vip', name: 'vip', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Auto-generate slug
    $('#name').on('keyup', function () {
        let text = $(this).val();
        let slug = text.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
        $('#slug').val(slug);
    });

    $(document).on('click', '.preview-img', function() {
        let src = $(this).data('src');
        $('#previewImage').attr('src', src);
        $('#imagePreviewModal').modal('show');
    });

    // Add Category Button
    $('#addCategoryBtn').click(function () {
        $('#categoryForm')[0].reset();
        $('#preview_category_image').hide();
        $('#preview_image_left').hide();
        $('#preview_image_right').hide();
        $('#category_id').val('');
        $('.error-text').text('');
        $('.modal-title').text('Add Category');
        $('#categoryModal').modal('show');
    });


    // Save or Update
    $('#categoryForm').submit(function (e) {
        e.preventDefault();
        $('#saveBtn').text('Saving...').prop('disabled', true);
        $('.error-text').text('');

        const formEl = this;
        const formData = new FormData(formEl); // picks up file inputs

        $.ajax({
            url: "{{ route('categories.store') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (resp) {
                $('#categoryModal').modal('hide');
                $('#saveBtn').text('Save').prop('disabled', false);
                Swal.fire('Success', resp.message, 'success');
                table.ajax.reload(null, false);
            },
            error: function (xhr) {
                $('#saveBtn').text('Save').prop('disabled', false);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                    Swal.fire('Validation Error', 'Please fix the highlighted fields.', 'error');
                } else {
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            }
        });
    });


    // Edit
    $('body').on('click', '.editBtn', function () {
        let id = $(this).data('id');
        $.get("{{ url('categories') }}/" + id + "/edit", function (data) {
            $('#category_id').val(data.id);
            $('#name').val(data.name);
            $('#slug').val(data.slug);
            $('.error-text').text('');
            $('.modal-title').text('Edit Category');

            // preview existing images
            if (data.category_image_url) {
                $('#preview_category_image').attr('src', data.category_image_url).show();
            } else {
                $('#preview_category_image').hide();
            }
            if (data.image_left_url) {
                $('#preview_image_left').attr('src', data.image_left_url).show();
            } else {
                $('#preview_image_left').hide();
            }
            if (data.image_right_url) {
                $('#preview_image_right').attr('src', data.image_right_url).show();
            } else {
                $('#preview_image_right').hide();
            }

            $('#categoryModal').modal('show');
        });
    });

    // Delete
    $('body').on('click', '.deleteBtn', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Delete?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('categories') }}/" + id,
                    type: 'DELETE',
                    success: function (resp) {
                        Swal.fire('Deleted', resp.message, 'success');
                        table.ajax.reload();
                    },
                    error: function () {
                        Swal.fire('Error', 'Failed to delete', 'error');
                    }
                });
            }
        });
    });

    // Make VIP
    $('body').on('click', '.make-vip', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Make VIP?',
            text: 'This will promote the category to VIP status. Your previous VIP category will be changed.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Make VIP'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('categories') }}/" + id + "/make-vip",
                    type: 'POST',
                    data: {_method: 'PUT', _token: '{{ csrf_token() }}'},
                    success: function (resp) {
                        Swal.fire('Success', resp.message, 'success');
                        table.ajax.reload();
                    },
                    error: function () {
                        Swal.fire('Error', 'Failed to update category', 'error');
                    }
                });
            }
        });
    });

    function readAndPreview(input, imgSelector) {
        const file = input.files && input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            $(imgSelector).attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
    }

    $('#category_image').on('change', function(){ readAndPreview(this, '#preview_category_image'); });
    $('#image_left').on('change', function(){ readAndPreview(this, '#preview_image_left'); });
    $('#image_right').on('change', function(){ readAndPreview(this, '#preview_image_right'); });

});
</script>
@endpush
@endsection