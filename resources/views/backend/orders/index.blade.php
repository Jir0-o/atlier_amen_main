@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="content-wrapper">
        <h3 class="font-weight-bold">Orders</h3>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="orderTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Products</th>
                                        <th>Total Qty</th>
                                        <th>Grand Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="orderModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5>Order #<span id="modal-order-id"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>User:</strong> <span id="modal-user"></span></p>
                    <p><strong>Total Qty:</strong> <span id="modal-total-qty"></span></p>
                    <p><strong>Subtotal:</strong> $<span id="modal-subtotal"></span></p>
                    <p><strong>Shipping:</strong> $<span id="modal-shipping"></span></p>
                    <p><strong>Grand Total:</strong> $<span id="modal-grand-total"></span></p>
                    <hr>
                    <h6>Ordered Items</h6>
                    <ul id="modal-items" class="list-group"></ul>
                </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
$(document).ready(function () {
    let table = $('#orderTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.orders.data") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user', name: 'user.name' },
            { data: 'products', name: 'products', orderable: false, searchable: true },
            { data: 'total_qty', name: 'total_qty' },
            { data: 'grand_total', name: 'grand_total' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // View Modal
    $(document).on('click', '.view-order', function () {
        const id = $(this).data('id');
        $.get(`/admin/orders/${id}`, function (res) {
            $('#modal-order-id').text(res.id);
            $('#modal-user').text(res.user);
            $('#modal-total-qty').text(res.total_qty);
            $('#modal-subtotal').text(res.subtotal);
            $('#modal-shipping').text(res.shipping);
            $('#modal-grand-total').text(res.grand_total);
            $('#modal-items').empty();
            res.items.forEach(item => {
                $('#modal-items').append(`
                    <li class="list-group-item d-flex justify-content-between">
                        <span>${item.product} (x${item.quantity})</span>
                        <span>$${item.line_total}</span>
                    </li>`);
            });
            $('#orderModal').modal('show');
        });
    });

    // Accept
    $(document).on('click', '.accept-order', function () {
        const id = $(this).data('id');
        const button = $(this);
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to accept this order?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Accept'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(`/admin/orders/${id}/accept`, {
                    _token: '{{ csrf_token() }}'
                }, function () {
                    table.ajax.reload(null, false);
                    Swal.fire('Accepted!', 'The order has been accepted.', 'success');
                });
            }
        });
    });

    // Reject
    $(document).on('click', '.reject-order', function () {
        const id = $(this).data('id');
        const button = $(this);
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to reject this order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Reject'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(`/admin/orders/${id}/reject`, {
                    _token: '{{ csrf_token() }}'
                }, function () {
                    table.ajax.reload(null, false);
                    Swal.fire('Rejected!', 'The order has been rejected.', 'success');
                });
            }
        });
    });
});
</script>
@endpush
@endsection