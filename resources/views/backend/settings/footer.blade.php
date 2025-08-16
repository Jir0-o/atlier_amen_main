@extends('layouts.app')

@section('title','Footer Settings')

@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="m-0">Footer Settings</h3>
          </div>
          <div class="table-responsive">
            <table id="footerTable" class="table table-striped w-100">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Footer Text</th>
                  <th>Facebook</th>
                  <th>Instagram</th>
                  <th>Website</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th class="text-end">Action</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="footerEditModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="footerEditForm" method="POST" action="{{ route('admin.footer.settings.update') }}">
        @csrf
        @method('PATCH')
        <div class="modal-header">
          <h5 class="modal-title">Edit Footer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Footer Text</label>
            <textarea class="form-control" name="footer_text" rows="2"></textarea>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Facebook URL</label>
              <input class="form-control" name="facebook_url" type="text">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Instagram URL</label>
              <input class="form-control" name="instagram_url" type="text">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Website URL</label>
              <input class="form-control" name="website_url" type="text">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input class="form-control" name="email" type="email">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" id="footerSaveBtn" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(function () {
  $.fn.dataTable.ext.errMode = 'none';

  const table = $('#footerTable').DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    paging: false,
    info: false,
    ajax: { url: "{{ route('admin.footer.settings.data') }}", type: 'GET' },
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
      { data: 'footer_text', name: 'footer_text', render: d => d ? $('<div>').text(d).html() : '—' },
      { data: 'facebook_url', name: 'facebook_url', render: d => d ? `<a href="${d}" target="_blank">${d}</a>` : '—' },
      { data: 'instagram_url', name: 'instagram_url', render: d => d ? `<a href="${d}" target="_blank">${d}</a>` : '—' },
      { data: 'website_url', name: 'website_url', render: d => d ? `<a href="${d}" target="_blank">${d}</a>` : '—' },
      { data: 'email', name: 'email', render: d => d || '—' },
      { data: 'address', name: 'address', render: d => d ? $('<div>').text(d).html() : '—' },
      { data: 'action', name: 'action', orderable:false, searchable:false, className:'text-end' },
    ]
  });

  const modal = new bootstrap.Modal(document.getElementById('footerEditModal'));

  // open editor (always loads the single row)
  $('#footerTable').on('click', '.btn-edit', function () {
    $.get("{{ route('admin.footer.settings.show') }}")
      .done(function (resp) {
        $('[name="footer_text"]').val(resp.footer_text ?? '');
        $('[name="facebook_url"]').val(resp.facebook_url ?? '');
        $('[name="instagram_url"]').val(resp.instagram_url ?? '');
        $('[name="website_url"]').val(resp.website_url ?? '');
        $('[name="address"]').val(resp.address ?? '');
        $('[name="email"]').val(resp.email ?? '');
        modal.show();
      })
      .fail(() => Swal.fire('Error','Failed to fetch footer settings.','error'));
  });

  // save
  $('#footerEditForm').on('submit', function (e) {
    e.preventDefault();
    const $btn = $('#footerSaveBtn').prop('disabled', true).text('Saving...');
    $.ajax({
      url: $(this).attr('action'),
      method: 'POST', // with _method=PATCH present
      data: $(this).serialize(),
      dataType: 'json'
    })
    .done(resp => {
      if (resp && resp.success) {
        Swal.fire('Saved', resp.message || 'Updated.', 'success');
        modal.hide();
        table.ajax.reload(null, false);
      } else {
        Swal.fire('Warning','Unexpected response.','warning');
      }
    })
    .fail(() => Swal.fire('Error','Server error.','error'))
    .always(() => $btn.prop('disabled', false).text('Save'));
  });
});
</script>
@endpush
