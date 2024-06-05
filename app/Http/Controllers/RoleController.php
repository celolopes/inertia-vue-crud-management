<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use Gate;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        Gate::authorize('acesso_regras');
        $roles = RoleResource::collection(Role::all());
        return inertia('Roles/Index', [
            'roles' => $roles,
        ]);
    }

    public function destroy(Role $role) {
        Gate::authorize('apagar_regras');
        $role->delete();
        return redirect()->route('roles.index');
    }

    public function edit(Role $role) {
        Gate::authorize('editar_regras');
        $role->load('permissions');

        return inertia('Roles/Edit', [
            'role' => RoleResource::make($role),
            'permissions' => PermissionResource::collection(Permission::all()),
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role) {
        Gate::authorize('editar_regras');
        $role->update($request->validated());
        
        $role->permissions()->sync($request->selectedPermissions);
        return redirect()->route('roles.index')->with('success', 'Regra atualizada com Sucesso!');
    }

    public function create() {
        Gate::authorize('criar_regras');
        $permissions = PermissionResource::collection(Permission::all());
        return inertia('Roles/Create', [
            'permissions' => $permissions,
        ]);
    }

    public function store(StoreRoleRequest $request)
    {
        Gate::authorize('criar_regras');
        $role = Role::create($request->validated());
        $role->permissions()->sync($request->selectedPermissions);
        return redirect()->route('roles.index')->with('success', 'Regra criada com Sucesso!');
    }
}
