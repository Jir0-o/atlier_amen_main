@extends('layouts.app')

@section('title', 'Attribute Values')

<style>
    #select_attribute.form-select {
        width: 100%;
        min-height: 44px;
        border-radius: 4px;
    }

    #filter_attribute.form-select {
        width: 100%;
        min-height: 44px;
        border-radius: 4px;
    }
</style>

@section('content')
<div class="content-wrapper">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h3 class="font-weight-bold">Attribute Values</h3>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filter_attribute" class="form-label">Filter by Attribute</label>
            <select id="filter_attribute" class="form-select">
                <option value="">All Attributes</option>
                @foreach($attributes as $attr)
                    <option value="{{ $attr->id }}" {{ request('attribute_id') == $attr->id ? 'selected' : '' }}>
                        {{ $attr->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <button class="btn btn-success" id="addValueBtn">Add Attribute Value</button>
            <br><br>
            <div class="table-responsive">
                <table id="attributeValueTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Attribute</th>
                            <th>Value</th>
                            <th>Slug</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Attribute Value Modal -->
<div class="modal fade" id="valueModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="attributeValueForm">
            @csrf
            <input type="hidden" name="id" id="value_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Attribute Value</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label for="select_attribute" class="form-label">Attribute</label>
                    <select id="select_attribute" name="attribute_id" class="form-select" required>
                        <option value="">Select Attribute</option>
                        @foreach($attributes as $attr)
                            <option value="{{ $attr->id }}" {{ request('attribute_id') == $attr->id ? 'selected' : '' }}>
                                {{ $attr->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger small attribute_id_error"></span>
                </div>
                    <div class="mb-3">
                        <label for="attribute_value" class="form-label">Value</label>
                        <input type="text" name="value" id="attribute_value" class="form-control" autocomplete="off">
                        <span class="text-danger error-text value_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="attribute_value_slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="attribute_value_slug" class="form-control" autocomplete="off">
                        <span class="text-danger error-text slug_error_val"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="saveValueBtn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    // CSRF
    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

    // DataTable
    let valueTable = $('#attributeValueTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.attribute-values.index') }}",
            data: function (d) {
                d.attribute_id = $('#filter_attribute').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'attribute_name', name: 'attribute_name' },
            { data: 'value', name: 'value' },
            { data: 'slug', name: 'slug' },
            { data: 'action', name: 'action', orderable:false, searchable:false }
        ]
    });

    // Filter
    $('#filter_attribute').change(function () {
        valueTable.ajax.reload();
    });

    // Auto-slug
    $('#attribute_value').on('keyup', function () {
        let text = $(this).val();
        let slug = text.toLowerCase().trim()
            .replace(/[^a-z0-9]+/g,'-')
            .replace(/^-+|-+$/g,'');
        $('#attribute_value_slug').val(slug);
    });

    // Open add modal
    $('#addValueBtn').click(function () {
        $('#attributeValueForm')[0].reset();
        $('#value_id').val('');
        $('.error-text').text('');
        $('.modal-title').text('Add Attribute Value');
        $('#saveValueBtn').text('Save').prop('disabled', false);
        $('#valueModal').modal('show');
    });

    // Submit create/update
    $('#attributeValueForm').submit(function (e) {
        e.preventDefault();
        $('#saveValueBtn').text('Saving...').prop('disabled', true);
        $('.error-text').text('');

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('admin.attribute-values.store') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (resp) {
                $('#valueModal').modal('hide');
                valueTable.ajax.reload(null, false);
                Swal.fire('Success', resp.message, 'success');
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errs = xhr.responseJSON.errors;
                    if (errs.attribute_id) $('.attribute_id_error').text(errs.attribute_id[0]);
                    if (errs.value) $('.value_error').text(errs.value[0]);
                    if (errs.slug) $('.slug_error_val').text(errs.slug[0]);
                    Swal.fire('Validation Error', 'Fix highlighted fields.', 'error');
                } else {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                }
            },
            complete: function () {
                $('#saveValueBtn').text('Save').prop('disabled', false);
            }
        });
    });

    // Edit value
    $('body').on('click', '.editValueBtn', function () {
        let slug = $(this).data('slug');
        $.get(`/admin/attribute-values/${slug}/edit`, function (data) {
            $('#value_id').val(data.id);
            $('#attribute_value').val(data.value);
            $('#attribute_value_slug').val(data.slug);
            $('#select_attribute').val(data.attribute_id);
            $('.error-text').text('');
            $('.modal-title').text('Edit Attribute Value');
            $('#saveValueBtn').text('Update').prop('disabled', false);
            $('#valueModal').modal('show');
        });
    });

    // Delete value
    $('body').on('click', '.deleteValueBtn', function () {
        let slug = $(this).data('slug');
        Swal.fire({
            title: 'Delete Attribute Value?',
            text: 'This cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete'
        }).then(res => {
            if (!res.isConfirmed) return;
            $.ajax({
                url: `/admin/attribute-values/${slug}`,
                type: 'DELETE',
                success: function (resp) {
                    valueTable.ajax.reload();
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
