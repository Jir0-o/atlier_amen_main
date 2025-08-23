@extends('layouts.app')

@section('title','Settings')

@section('content')
<div class="container-fluid">
  <h1 class="h3 mb-4">Settings</h1>

  <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-roles" role="tab">Roles</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-permissions" role="tab">Permissions</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-users" role="tab">Users & Roles</a></li>
  </ul>

  <div class="tab-content pt-3">
    {{-- Roles --}}
    <div class="tab-pane fade show active" id="tab-roles" role="tabpanel">
      <div class="d-flex gap-2 mb-3">
        <input type="text" class="form-control w-auto" id="roleSearch" placeholder="Search roles">
        <button class="btn btn-primary" id="btnNewRole">+ New Role</button>
      </div>
      <div class="table-responsive">
        <table class="table table-sm" id="rolesTable">
          <thead><tr><th>Name</th><th>Permissions</th><th class="text-end">Actions</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

    {{-- Permissions --}}
    <div class="tab-pane fade" id="tab-permissions" role="tabpanel">
        <div class="d-flex gap-2 mb-3">
            <button class="btn btn-primary" id="btnAddPerm">+ New Permission</button>
        </div>
      <ul class="list-group" id="permList"></ul>
    </div>

    {{-- Users & Roles --}}
    <div class="tab-pane fade" id="tab-users" role="tabpanel">
      <div class="d-flex gap-2 mb-3">
        <input type="text" class="form-control w-auto" id="userSearch" placeholder="Search users">
        <button class="btn btn-outline-secondary" id="btnReloadUsers">Reload</button>
      </div>
      <div class="table-responsive">
        <table class="table table-sm" id="usersTable">
          <thead><tr><th>Name</th><th>Email</th><th>Roles</th><th class="text-end">Actions</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Role modal --}}
<div class="modal fade" id="roleModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <form id="roleForm">
        <div class="modal-header">
          <h5 class="modal-title">Role</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="roleId">
          <div class="mb-3">
            <label class="form-label">Role name</label>
            <input type="text" class="form-control" id="roleName" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Permissions</label>
            <div id="permCheckboxes" class="row g-2"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Permission modal --}}
<div class="modal fade" id="permissionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="permissionForm">
        <div class="modal-header">
          <h5 class="modal-title" id="permissionModalTitle">Add Permission</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="permissionId">
          <div class="mb-3">
            <label class="form-label">Permission name</label>
            <input type="text" class="form-control" id="permissionName" required>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


{{-- Assign roles modal --}}
<div class="modal fade" id="assignModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="assignForm">
        <div class="modal-header">
          <h5 class="modal-title">Assign Roles</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="assignUserId">
          <div id="assignRoleChecks" class="row g-2"></div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<!-- Bootstrap JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// tiny debounce helper (no lodash)
function debounce(fn, wait){ let t; return function(...args){
  clearTimeout(t); t = setTimeout(() => fn.apply(this, args), wait);
}; }
</script>

<script>
(function(){
  const routes = {
    rolesList: "{{ route('settings.roles.list') }}",
    rolesStore: "{{ route('settings.roles.store') }}",
    rolesUpdate: (id) => "{{ route('settings.roles.update', ':id') }}".replace(':id', id),
    rolesDelete: (id) => "{{ route('settings.roles.destroy', ':id') }}".replace(':id', id),

    permsList: "{{ route('settings.permissions.list') }}",
    permsStore: "{{ route('settings.permissions.store') }}",
    permsUpdate: (id) => "{{ route('settings.permissions.update', ':id') }}".replace(':id', id),
    permsDelete: (id) => "{{ route('settings.permissions.destroy', ':id') }}".replace(':id', id),

    usersList: "{{ route('settings.users.list') }}",
    userSync: (id) => "{{ route('settings.users.syncRoles', ':id') }}".replace(':id', id),
  };

  // CSRF for AJAX
  $.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
  });

  // ========= Permissions (list + modal-based CRUD) =========
  const permissionModalEl = document.getElementById('permissionModal');
  // If you haven't added the Permission modal HTML yet, add the one I sent earlier.
  const permissionModal = permissionModalEl ? new bootstrap.Modal(permissionModalEl) : null;
  const $permId    = $('#permissionId');     // hidden input in modal
  const $permName  = $('#permissionName');   // text input in modal
  const $permTitle = $('#permissionModalTitle'); // modal title

  function openPermCreate() {
    if (!permissionModal) return;
    $permId.val('');
    $permName.val('');
    $permTitle.text('Add Permission');
    permissionModal.show();
  }

  function openPermEdit(id, currentName) {
    if (!permissionModal) return;
    $permId.val(id);
    $permName.val(currentName);
    $permTitle.text('Edit Permission');
    permissionModal.show();
  }

  function loadPermissions(cb){
    $.getJSON(routes.permsList, function(perms){
      // role modal checkboxes
      const $wrap = $('#permCheckboxes').empty();
      perms.forEach(p => {
        $wrap.append(
          `<div class="col-6">
             <div class="form-check">
               <input class="form-check-input perm-check" type="checkbox" value="${p.name}" id="perm_${p.id}">
               <label class="form-check-label" for="perm_${p.id}">${p.name}</label>
             </div>
           </div>`
        );
      });

      // Permissions tab list
      const $list = $('#permList').empty();
      perms.forEach(p => {
        $list.append(
          `<li class="list-group-item d-flex justify-content-between align-items-center">
             <span>${p.name}</span>
             <div>
               <button class="btn btn-sm btn-outline-primary me-2 btn-edit-perm"
                       data-id="${p.id}" data-name="${p.name}">Edit</button>
               <button class="btn btn-sm btn-outline-danger btn-del-perm"
                       data-id="${p.id}">Delete</button>
             </div>
           </li>`
        );
      });

      cb && cb(perms);
    });
  }
  loadPermissions();

  // Open "Add Permission" modal (use this button in your Permissions tab)
  $('#btnAddPerm').on('click', function(){
    // If you still have an inline input (#permName) from the old UI, ignore it and open modal
    openPermCreate();
  });

  // Submit create/update (permission modal)
  $('#permissionForm').on('submit', function(e){
    e.preventDefault();
    const id   = $permId.val();
    const name = ($permName.val() || '').trim();
    if (!name) { $permName.focus(); return; }

    if (id) {
      $.ajax({ url: routes.permsUpdate(id), method: 'PUT', data: { name } })
        .done(() => { permissionModal.hide(); loadPermissions(); })
        .fail(err => alert(err.responseJSON?.message || 'Failed to update permission'));
    } else {
      $.post(routes.permsStore, { name })
        .done(() => { permissionModal.hide(); loadPermissions(); })
        .fail(err => alert(err.responseJSON?.message || 'Failed to create permission'));
    }
  });

  // Edit/Delete actions in the permissions list
  $('#permList').on('click', '.btn-edit-perm', function(){
    const id   = $(this).data('id');
    const name = $(this).data('name');
    openPermEdit(id, name);
  });

  $('#permList').on('click', '.btn-del-perm', function(){
    const id = $(this).data('id');
    if(!confirm('Delete this permission?')) return;
    $.ajax({ url: routes.permsDelete(id), method: 'DELETE' })
      .done(() => loadPermissions())
      .fail(err => alert(err.responseJSON?.message || 'Failed to delete permission'));
  });

  // =================== Roles ===================
  function loadRoles(){
    const search = $('#roleSearch').val();
    $.getJSON(routes.rolesList, {search}, function(rows){
      const $tb = $('#rolesTable tbody').empty();
      rows.forEach(r => {
        const perms = r.permissions.length ? r.permissions.join(', ') : '<span class="text-muted">—</span>';
        $tb.append(
          `<tr>
            <td>${r.name}</td>
            <td>${perms}</td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-primary me-2 btn-edit-role" data-id="${r.id}">Edit</button>
              <button class="btn btn-sm btn-outline-danger btn-del-role" data-id="${r.id}">Delete</button>
            </td>
          </tr>`
        );
      });
    });
  }
  loadRoles();

  $('#roleSearch').on('input', debounce(loadRoles, 300));

  // New / Edit Role modal
  const roleModal = new bootstrap.Modal(document.getElementById('roleModal'));
  $('#btnNewRole').on('click', function(){
    $('#roleId').val('');
    $('#roleName').val('');
    $('#permCheckboxes .perm-check').prop('checked', false);
    roleModal.show();
  });

  $('#rolesTable').on('click', '.btn-edit-role', function(){
    const id = $(this).data('id');
    $.getJSON(routes.rolesList, function(all){
      const row = all.find(x => x.id == id);
      if(!row) return;
      $('#roleId').val(row.id);
      $('#roleName').val(row.name);
      $('#permCheckboxes .perm-check').each(function(){
        $(this).prop('checked', row.permissions.includes($(this).val()));
      });
      roleModal.show();
    });
  });

  $('#rolesTable').on('click', '.btn-del-role', function(){
    const id = $(this).data('id');
    if(!confirm('Delete this role?')) return;
    $.ajax({url: routes.rolesDelete(id), method:'DELETE'})
      .done(() => loadRoles())
      .fail(err => alert(err.responseJSON?.message || 'Failed'));
  });

  $('#roleForm').on('submit', function(e){
    e.preventDefault();
    const id = $('#roleId').val();
    const name = $('#roleName').val().trim();
    const permissions = $('#permCheckboxes .perm-check:checked').map((_,el)=>$(el).val()).get();

    if(!name) { alert('Role name is required'); return; }

    if(id){
      $.ajax({url: routes.rolesUpdate(id), method:'PUT', data:{name, permissions}})
        .done(() => { roleModal.hide(); loadRoles(); })
        .fail(err => alert(err.responseJSON?.message || 'Failed'));
    } else {
      $.post(routes.rolesStore, {name, permissions})
        .done(() => { roleModal.hide(); loadRoles(); })
        .fail(err => alert(err.responseJSON?.message || 'Failed'));
    }
  });

  // =================== Users & Roles ===================
  function loadUsers(){
    const search = $('#userSearch').val();
    $.getJSON(routes.usersList, {search}, function(resp){
      const $tb = $('#usersTable tbody').empty();
      (resp.data || []).forEach(u => {
        const roles = u.roles.length ? u.roles.join(', ') : '<span class="text-muted">—</span>';
        $tb.append(
          `<tr>
             <td>${u.name}</td>
             <td>${u.email}</td>
             <td>${roles}</td>
             <td class="text-end">
               <button class="btn btn-sm btn-outline-primary btn-assign" data-id="${u.id}">Assign Roles</button>
             </td>
           </tr>`
        );
      });
    });
  }
  loadUsers();
  $('#btnReloadUsers').on('click', loadUsers);
  $('#userSearch').on('input', debounce(loadUsers, 300));

  const assignModal = new bootstrap.Modal(document.getElementById('assignModal'));
  $('#usersTable').on('click', '.btn-assign', function(){
    const userId = $(this).data('id');
    $('#assignUserId').val(userId);

    $.when(
      $.getJSON(routes.rolesList),
      $.getJSON(routes.usersList, {search:''})
    ).done(function(rolesResp, usersResp){
      const roles = rolesResp[0];
      const allUsers = usersResp[0].data || [];
      const user = allUsers.find(u => u.id == userId);
      const current = new Set(user ? user.roles : []);
      const $wrap = $('#assignRoleChecks').empty();
      roles.forEach(r => {
        const checked = current.has(r.name) ? 'checked' : '';
        $wrap.append(
          `<div class="col-6">
             <div class="form-check">
               <input class="form-check-input assign-check" type="checkbox" value="${r.name}" id="ar_${r.id}" ${checked}>
               <label class="form-check-label" for="ar_${r.id}">${r.name}</label>
             </div>
           </div>`
        );
      });
      assignModal.show();
    });
  });

  $('#assignForm').on('submit', function(e){
    e.preventDefault();
    const userId = $('#assignUserId').val();
    const roles = $('#assignRoleChecks .assign-check:checked').map((_,el)=>$(el).val()).get();
    $.post(routes.userSync(userId), {roles})
      .done(() => { assignModal.hide(); loadUsers(); })
      .fail(err => alert(err.responseJSON?.message || 'Failed'));
  });

})();
</script>
@endpush

