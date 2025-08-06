@extends('layouts.app')

@section('title', 'Attributes')

@section('content')
<div class="content-wrapper">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h3 class="font-weight-bold">Attributes</h3>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <button class="btn btn-success mb-3" id="addAttributeBtn">Add Attribute</button>
            <div class="table-responsive">
                <table id="attributeTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Values</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Attribute Modal -->
<div class="modal fade" id="attributeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="attributeForm">
            @csrf
            <input type="hidden" name="id" id="attribute_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Attribute</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="attribute_name" class="form-label">Name</label>
                        <input type="text" name="name" id="attribute_name" class="form-control" autocomplete="off">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="attribute_slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="attribute_slug" class="form-control" autocomplete="off">
                        <span class="text-danger error-text slug_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="saveAttributeBtn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    // CSRF header
    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

    // Attributes DataTable
    let attributeTable = $('#attributeTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.attributes.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (row) {
                    // link to attribute values filtered by this attribute
                    return `<a href="{{ route('admin.attribute-values.index') }}?attribute_id=${row.id}" class="btn btn-sm btn-info">Manage Values</a>`;
                }
            },
            { data: 'action', name: 'action', orderable:false, searchable:false }
        ],
        drawCallback: function(){ /* optional post-draw logic */ }
    });

    // Auto slug from name
    $('#attribute_name').on('keyup', function () {
        let text = $(this).val();
        let slug = text.toLowerCase().trim()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        $('#attribute_slug').val(slug);
    });

    // Open create modal
    $('#addAttributeBtn').click(function () {
        $('#attributeForm')[0].reset();
        $('#attribute_id').val('');
        $('.error-text').text('');
        $('.modal-title').text('Add Attribute');
        $('#saveAttributeBtn').text('Save').prop('disabled', false);
        $('#attributeModal').modal('show');
    });

    // Submit create/update
    $('#attributeForm').submit(function (e) {
        e.preventDefault();
        $('#saveAttributeBtn').text('Saving...').prop('disabled', true);
        $('.error-text').text('');

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('admin.attributes.store') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (resp) {
                $('#attributeModal').modal('hide');
                attributeTable.ajax.reload(null, false);
                Swal.fire('Success', resp.message, 'success');
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errs = xhr.responseJSON.errors;
                    if (errs.name) $('.name_error').text(errs.name[0]);
                    if (errs.slug) $('.slug_error').text(errs.slug[0]);
                    Swal.fire('Validation Error', 'Fix highlighted fields.', 'error');
                } else {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                }
            },
            complete: function () {
                $('#saveAttributeBtn').text('Save').prop('disabled', false);
            }
        });
    });

    // Edit
    $('body').on('click', '.editBtn', function () {
        let slug = $(this).data('slug');
        $.get(`/admin/attributes/${slug}/edit`, function (data) {
            $('#attribute_id').val(data.id);
            $('#attribute_name').val(data.name);
            $('#attribute_slug').val(data.slug);
            $('.error-text').text('');
            $('.modal-title').text('Edit Attribute');
            $('#saveAttributeBtn').text('Update').prop('disabled', false);
            $('#attributeModal').modal('show');
        });
    });

    // Delete
    $('body').on('click', '.deleteBtn', function () {
        let slug = $(this).data('slug');
        Swal.fire({
            title: 'Delete Attribute?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete'
        }).then(res => {
            if (!res.isConfirmed) return;
            $.ajax({
                url: `/admin/attributes/${slug}`,
                type: 'DELETE',
                success: function (resp) {
                    attributeTable.ajax.reload();
                    Swal.fire('Deleted', resp.message, 'success');
                },
                error: function () {
                    Swal.fire('Error', 'Failed to delete', 'error');
                }
            });
        });
    });
});
</script>
@endpush
