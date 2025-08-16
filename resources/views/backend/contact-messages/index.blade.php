@extends('layouts.app')

@section('title', 'Contact Messages')

<style>
    /* Modal animation */
    .modal.fade .modal-dialog {
        transform: scale(0.9);
        opacity: 0;
        transition: all 0.3s ease-in-out;
    }

    .modal.show .modal-dialog {
        transform: scale(1);
        opacity: 1;
    }

    /* Glass effect for modal content */
    .modal-content {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.9);
    }

</style>

@section('content')
<div class="content-wrapper">
    <h3 class="font-weight-bold">Contact Messages</h3>
    <!-- Table -->
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="messagesTable" class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Message</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            {{-- DataTables will build tbody --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Message Modal (Bootstrap 5) -->
    <div class="modal fade" id="contactMessageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-3">

            <!-- Header -->
            <div class="modal-header bg-primary text-white rounded-top-3">
                <h5 id="contactMessageModalTitle" class="modal-title fw-semibold m-0">
                <i class="bi bi-envelope-paper me-2"></i> Message Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <dl class="row align-items-start mb-0 small-gutters">
                <dt class="col-sm-3 text-secondary mb-2">Name:</dt>
                <dd class="col-sm-9 fw-semibold mb-2" id="view_name"></dd>

                <dt class="col-sm-3 text-secondary mb-2">Email:</dt>
                <dd class="col-sm-9 text-semibold mb-2" id="view_email"></dd>

                <dt class="col-sm-3 text-secondary mb-2">Contact:</dt>
                <dd class="col-sm-9 mb-2" id="view_number"></dd>

                <dt class="col-sm-3 text-secondary mb-2">Message:</dt>
                <dd class="col-sm-9 mb-3" id="view_message"
                    style="white-space:pre-line;background:#0f0f0f;border:1px solid #e5e7eb;padding:10px;border-radius:.5rem;"></dd>

                <dt class="col-sm-3 text-secondary mb-2">IP Address:</dt>
                <dd class="col-sm-9 text-muted mb-2" id="view_ip"></dd>

                <dt class="col-sm-3 text-secondary mb-2">User Agent:</dt>
                <dd class="col-sm-9 text-muted small mb-2" id="view_ua" style="word-break:break-all;"></dd>

                <dt class="col-sm-3 text-secondary mb-0">Submitted:</dt>
                <dd class="col-sm-9 mb-0" id="view_created"></dd>
                </dl>
            </div>

            <!-- Footer -->
            <div class="modal-footer rounded-bottom-3 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="bi bi-x-circle me-1"></i> Close
                </button>
                <button type="button" class="btn btn-danger" id="modalDeleteBtn" data-id="">
                <i class="bi bi-trash me-1"></i> Delete
                </button>
            </div>

            </div>
        </div>
    </div>

</div>
@endsection


@push('scripts')
<script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    // DataTable
    let table = $('#messagesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('contact-messages.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'number', name: 'number' },
            { data: 'message', name: 'message' }, // truncated in controller
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Open modal (View Details)
    $('body').on('click', '.viewBtn', function(){
        const id = $(this).data('id');

        // reset content while loading
        clearModalFields();
        $('#contactMessageModalTitle').text('Loading...');
        $('#modalDeleteBtn').prop('disabled', true).data('id','');

        $.get("{{ url('admin/contact-messages') }}/" + id, function(data){
            // Fill fields
            $('#contactMessageModalTitle').text('Message from ' + data.name);
            $('#view_name').text(data.name || '');
            $('#view_email').text(data.email || '');
            $('#view_number').text(data.number || '');
            $('#view_message').text(data.message || '');
            $('#view_ip').text(data.ip_address || '');
            $('#view_ua').text(data.user_agent || '');
            $('#view_created').text(data.created_at || '');

            $('#modalDeleteBtn').prop('disabled', false).data('id', data.id);
        })
        .fail(function(){
            $('#contactMessageModalTitle').text('Error Loading Message');
            $('#view_message').text('Failed to load. Please try again.');
        });

        $('#contactMessageModal').modal('show');
    });

    function clearModalFields(){
        $('#view_name,#view_email,#view_number,#view_message,#view_ip,#view_ua,#view_created').text('');
    }

    // Delete from inside modal
    $('#modalDeleteBtn').on('click', function(){
        const id = $(this).data('id');
        if (!id) return;

        Swal.fire({
            title: 'Delete?',
            text: 'This message will be permanently deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete'
        }).then(result => {
            if(result.isConfirmed){
                deleteMessage(id);
            }
        });
    });

    // Delete from table row
    $('body').on('click', '.deleteBtn', function(){
        const id = $(this).data('id');
        Swal.fire({
            title: 'Delete?',
            text: 'This message will be permanently deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete'
        }).then(result => {
            if(result.isConfirmed){
                deleteMessage(id);
            }
        });
    });

    function deleteMessage(id){
        $.ajax({
            url: "{{ url('Admin/contact-messages') }}/" + id,
            type: 'DELETE',
            success: function(resp){
                Swal.fire('Deleted', resp.message, 'success');
                $('#contactMessageModal').modal('hide');
                table.ajax.reload(null, false);
            },
            error: function(){
                Swal.fire('Error', 'Failed to delete', 'error');
            }
        });
    }
});
</script>
@endpush
