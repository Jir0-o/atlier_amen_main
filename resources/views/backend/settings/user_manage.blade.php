@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center">
                        <h3 class="font-weight-bold m-0">Users</h3>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success mt-3">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive mt-3">
                        <table id="usersTable" class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Products Purchased</th>
                                    <th>Total Spent</th>
                                    <th>Last Purchase</th>
                                    <th>Status</th>
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
@endsection

@push('scripts')
<script>
$(function () {
  var table = $('#usersTable').DataTable({
    
    processing: true,
    serverSide: true,
    ajax: { url: "{{ route('admin.users.data') }}", type: 'GET' },
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
      { data: 'first_name',  name: 'users.first_name' },
      { data: 'last_name',   name: 'users.last_name'  },
      { data: 'email',       name: 'users.email'      },
      { data: 'phone',       name: 'users.phone'      },
      { data: 'product_count', name: 'product_count', searchable:false },
      { data: 'money_spent',   name: 'money_spent',   searchable:false },
      { data: 'last_purchase_at', name: 'last_purchase_at', searchable:false },
      { data: 'status',      name: 'status', orderable:false, searchable:false },
      { data: 'action',      name: 'action', orderable:false, searchable:false, className:'text-end' },
    ],
    pageLength: 20
  });

    $('#usersTable').on('submit', '.user-toggle-form', function (e) {
        e.preventDefault();
        var $form = $(this);

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to change this user's status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed!'
        }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function () {
                $('#usersTable').DataTable().ajax.reload(null, false);
                Swal.fire('Updated!', 'User status has been changed.', 'success');
                },
                error: function (xhr) {
                Swal.fire('Error', (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to update user.', 'error');
                }
            });
            }
        });
    });

});

</script>
@endpush

