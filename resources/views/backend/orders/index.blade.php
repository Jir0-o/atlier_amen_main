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
                                    <th>Order Date/Time</th>
                                    <th>User</th>
                                    <th>Products</th>
                                    <th>Total Qty</th>
                                    <th>Grand Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            {{-- DataTables will load tbody --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- VIEW MODAL (advanced) --}}
    <div class="modal fade" id="orderModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="m-0">Order #<span id="modal-order-id"></span></h5>
                        <small class="text-light">Placed at: <span id="modal-created-at"></span></small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <div class="border rounded p-3 h-100">
                                <h6 class="mb-2">Customer</h6>
                                <div><strong id="modal-user"></strong></div>
                                <div>Email: <span id="modal-user-email"></span></div>
                                <div>Phone: <span id="modal-user-phone"></span></div>
                                <div class="mt-2">Status: <span id="modal-status" class="badge bg-secondary">-</span></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="border rounded p-3 h-100">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-2">Shipping Address</h6>
                                        <div id="modal-ship"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-2">Billing Address</h6>
                                        <div id="modal-bill"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-items" type="button">
                                Items
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-summary" type="button">
                                Summary
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content pt-3">
                        {{-- ITEMS TAB: detailed table --}}
                        <div class="tab-pane fade show active" id="tab-items">
                            <div class="table-responsive">
                                <table class="table table-sm align-middle text-light" id="modal-items-table">
                                    <thead>
                                        <tr>
                                            <th style="width:64px;">Image</th>
                                            <th>Product</th>
                                            <th class="text-end">Qty</th>
                                            <th class="text-end">Unit</th>
                                            <th class="text-end">Line Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modal-items-body"></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-end">Subtotal</th>
                                            <th class="text-end" id="modal-items-subtotal">$0.00</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-end">Shipping</th>
                                            <th class="text-end" id="modal-items-shipping">$0.00</th>
                                        </tr>
                                        <tr class="fw-bold">
                                            <th colspan="4" class="text-end">Grand Total</th>
                                            <th class="text-end" id="modal-items-grand">$0.00</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{-- SUMMARY TAB --}}
                        <div class="tab-pane fade" id="tab-summary">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm text-light">
                                        <tbody>
                                            <tr><th>Total Qty</th><td><span id="modal-total-qty"></span></td></tr>
                                            <tr><th>Subtotal</th><td>$<span id="modal-subtotal"></span></td></tr>
                                            <tr><th>Shipping</th><td>$<span id="modal-shipping"></span></td></tr>
                                            <tr class="fw-bold"><th>Grand Total</th><td>$<span id="modal-grand-total"></span></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6>Timeline</h6>
                                    <ul id="modal-timeline" class="list-unstyled small">
                                        <li>Created: <span id="modal-created-at-2"></span></li>
                                        <li>Last Update: <span id="modal-updated-at"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> {{-- /tab-content --}}
                </div> {{-- /modal-body --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    // DataTable
    let table = $('#orderTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.orders.data") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'order_datetime', name: 'created_at' }, // NEW
            { data: 'user', name: 'user.name' },
            { data: 'products', name: 'products', orderable: false, searchable: true },
            { data: 'total_qty', name: 'total_qty' },
            { data: 'grand_total', name: 'grand_total' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // View modal (advanced)
    $(document).on('click', '.view-order', function () {
        const id = $(this).data('id');

        $.get(`/admin/orders/${id}`, function (res) {
            // Header/meta
            $('#modal-order-id').text(res.id);
            $('#modal-created-at').text(res.created_at ?? '-');
            $('#modal-created-at-2').text(res.created_at ?? '-');
            $('#modal-updated-at').text(res.updated_at ?? '-');

            // Customer
            $('#modal-user').text(res.customer?.name ?? 'N/A');
            $('#modal-user-email').text(res.customer?.email ?? '-');
            $('#modal-user-phone').text(res.customer?.phone ?? '-');

            // Status badge
            const statusMap = {
                pending:'warning', accepted:'primary', completed:'success',
                rejected:'danger', cancelled:'secondary'
            };
            const cls = statusMap[res.status] || 'secondary';
            $('#modal-status').removeClass().addClass('badge bg-' + cls).text((res.status||'').toUpperCase());

            // Addresses
            function escapeHtml(s){ return $('<div>').text(s ?? '').html(); }
            function addrHtml(a){
                if(!a) return '<em>—</em>';
                const parts = [];
                if (a.name) parts.push('<div><strong>'+escapeHtml(a.name)+'</strong></div>');
                if (a.address) parts.push('<div>'+escapeHtml(a.address)+'</div>');
                const line2 = [a.city, a.state].filter(Boolean).join(', ');
                const line3 = [a.zip, a.country].filter(Boolean).join(', ');
                if (line2) parts.push('<div>'+escapeHtml(line2)+'</div>');
                if (line3) parts.push('<div>'+escapeHtml(line3)+'</div>');
                return parts.join('');
            }
            $('#modal-ship').html(addrHtml(res.shipping));
            $('#modal-bill').html(addrHtml(res.billing));

            // ITEMS TABLE
            const $tbody = $('#modal-items-body');
            $tbody.empty();

            const items = Array.isArray(res.items) ? res.items : [];
            if (!items.length) {
                $tbody.append(`<tr><td colspan="5" class="text-center text-muted">No items found for this order.</td></tr>`);
            } else {
                items.forEach(item => {
                    const variantLine = item.variant
                        ? `<div class="text-light small">Variant: ${escapeHtml(item.variant)}</div>` : '';
                    $tbody.append(`
                        <tr>
                            <td>
                                <img src="${item.image}" alt="${escapeHtml(item.product)}" width="56" height="56" class="rounded">
                            </td>
                            <td>
                                <div class="fw-semibold text-light">${escapeHtml(item.product)}</div>
                                <div class="text-light">${variantLine}</div>
                            </td>
                            <td class="text-end">${Number(item.quantity) || 0}</td>
                            <td class="text-end">$${money(item.unit_price)}</td>
                            <td class="text-end">$${money(item.line_total)}</td>
                        </tr>
                    `);
                });
            }

            // Footer totals in Items tab
            $('#modal-items-subtotal').text(`$${money(res.subtotal ?? '0')}`);
            $('#modal-items-shipping').text(`$${money(res.shipping_charge ?? '0')}`);
            $('#modal-items-grand').text(`$${money(res.grand_total ?? '0')}`);

            // Summary tab
            $('#modal-total-qty').text(res.total_qty ?? 0);
            $('#modal-subtotal').text(res.subtotal ?? '0.00');
            $('#modal-shipping').text(res.shipping_charge ?? '0.00');
            $('#modal-grand-total').text(res.grand_total ?? '0.00');

            // Show
            $('#orderModal').modal('show');
        });
    });

    // Accept
    $(document).on('click', '.accept-order', function () {
        const id = $(this).data('id');
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
                    $('#orderModal').modal('hide');
                    $('#orderTable').DataTable().ajax.reload(null, false);
                    Swal.fire('Accepted!', 'The order has been accepted.', 'success');
                });
            }
        });
    });

    // Reject
    $(document).on('click', '.reject-order', function () {
        const id = $(this).data('id');
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
                    $('#orderModal').modal('hide');
                    $('#orderTable').DataTable().ajax.reload(null, false);
                    Swal.fire('Rejected!', 'The order has been rejected.', 'success');
                });
            }
        });
    });
});

// currency helper
function money(v){
  const n = Number(String(v ?? '').toString().replace(/[^0-9.]/g,'')) || 0;
  return n.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}
</script>
@endpush
