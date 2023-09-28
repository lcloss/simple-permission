<?php

namespace Lcloss\SimplePermission\Http\Controllers;

use Illuminate\Routing\Controller;
use Lcloss\SimplePermission\Http\Requests\StoreRoleRequest;
use Lcloss\SimplePermission\Http\Requests\UpdateRoleRequest;
use Lcloss\SimplePermission\Models\Permission;
use Lcloss\SimplePermission\Models\Role;
use Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( !Gate::allows('roles_list') ) abort(403);

        return view( config('simple-permission.views.roles.index'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if( !Gate::allows('roles_create') ) abort(403);

        $permissionsOptions = [];
        $permissions = Permission::orderBy('name')->get();
        $last_name = '';
        foreach( $permissions as $permission ) {
            $permissionsPart = explode('_', $permission->name);
            $group = ucfirst( $permissionsPart[0] );

            if ( $group != $last_name ) {
                $permissionsOptions[$group] = [];
                $last_name = $group;
            }

            $permissionsOptions[$group][$permission->id] = $permissionsPart[1];
        }
        return view( config('simple-permission.views.roles.create'), compact('permissionsOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
//        if( !Gate::allows('roles_create') ) abort(403);

        $validated = $request->validated();

        try {
            $role = Role::create([
                'name'      => $validated['name'],
                'slug'      => $validated['slug'],
                'level'     => $validated['level'],
            ]);
            if ( !is_null( $request->permissions ) ) {
                $role->permissions->attach($request->permissions);
            }

        } catch ( \Exception $e ) {
            return redirect()->back()->with('error', 'Erro ao criar role: ' . $e->getMessage() );
        }

        session()->flash('success', __('Role successfully created.'));

        return redirect()->route('simple-permission.roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
//        if( !Gate::allows('roles_read') ) abort(403);

        $permissionsOptions = [];
        $permissions = $role->permissions()->orderBy('name')->get();
        $last_name = '';
        foreach( $permissions as $permission ) {
            $permissionsPart = explode('_', $permission->name);
            $group = ucfirst( $permissionsPart[0] );

            if ( $group != $last_name ) {
                $permissionsOptions[$group] = [];
                $last_name = $group;
            }

            $permissionsOptions[$group][$permission->id] = $permissionsPart[1];
        }

        return view( config('simple-permission.views.roles.show'), compact('role', 'permissionsOptions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
//        if( !Gate::allows('roles_update') ) abort(403);

        $permissionsOptions = [];
        $permissions = Permission::orderBy('name')->get();
        $last_name = '';
        foreach( $permissions as $permission ) {
            $permissionsPart = explode('_', $permission->name);
            $group = ucfirst( $permissionsPart[0] );

            if ( $group != $last_name ) {
                $permissionsOptions[$group] = [];
                $last_name = $group;
            }

            $permissionsOptions[$group][$permission->id] = $permissionsPart[1];
        }

        return view( config('simple-permission.views.roles.edit'), compact('role', 'permissionsOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
//        if( !Gate::allows('roles_update') ) abort(403);

        $updated = false;

        $validated = $request->validated();

        try {
            if ( $role->name != $request->name ) {
                $updated = true;
                $role->name = $request->name;
            }
            if ( $role->slug != $request->slug ) {
                $updated = true;
                $role->slug = $request->slug;
            }
            if ( $role->level != $request->level ) {
                $updated = true;
                $role->level = $request->level;
            }
            if ( $role->permissions->pluck('id')->toArray() != $request->permissions ) {
                $updated = true;
                $role->permissions()->sync($request->permissions);
            }

        } catch ( \Exception $e ) {
            return redirect()->back()->with('error', 'Erro ao atualizar role: ' . $e->getMessage() );
        }

        if ( $updated == true ) {
            $role->save();
            $level = 'success';
            $message = 'role atualizado com sucesso.';
        } else {
            $level = 'info';
            $message = 'Nenhuma informação atualizada.';
        }

        return redirect()->route('simple-permission.roles.index')->with($level, $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
//        if( !Gate::allows('roles_delete') ) abort(403);

        try {
            $role->delete();
        } catch ( \Exception $e ) {
            return redirect()->back()->with('error', 'Erro ao eliminar role: ' . $e->getMessage() );
        }

        return redirect()->route('simple-permission.roles.index')->with('success', __('Role successfully deleted.'));
    }
}
