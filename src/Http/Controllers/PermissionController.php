<?php

namespace Lcloss\SimplePermission\Http\Controllers;

use Illuminate\Routing\Controller;
use Lcloss\SimplePermission\Http\Requests\StorePermissionRequest;
use Lcloss\SimplePermission\Http\Requests\UpdatePermissionRequest;
use Lcloss\SimplePermission\Models\Permission;
use Lcloss\SimplePermission\Models\Role;
use Gate;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( !Gate::allows('permissions_list') ) abort(403);

        return view( config('simple-permission.views.permissions.index'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if( !Gate::allows('permissions_create') ) abort(403);

        $roles = Role::pluck('name', 'id')->toArray();

        return view( config('simple-permission.views.permissions.create'), compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        if( !Gate::allows('permissions_create') ) abort(403);

        $validated = $request->validated();

        try {
            if ( $request->actions ) {
                foreach( $request->actions as $action ) {
                    $permissionName = $request->name . '_' . $action;
                    $permission = Permission::create(['name' => $permissionName]);
                    if ( count( $request->roles ) > 0 ) {
                        $permission->roles()->attach( $request->roles );
                    }
                }
            } else {
                $permissionName = $request->name;
                $permission = Permission::create(['name' => $permissionName]);
                if ( $request->roles ) {
                    $permission->roles()->attach( $request->roles );
                }
            }

        } catch ( \Exception $e ) {
            return redirect()->back()->with('error', 'Erro ao criar permission: ' . $e->getMessage() );
        }

        session()->flash('success', __('Permission successfuly created.'));

        return redirect()->route('simple-permission.permissions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        if( !Gate::allows('permissions_read') ) abort(403);

        $roles = Role::pluck('name', 'id')->toArray();

        return view( config('simple-permission.views.permissions.show'), compact('permission', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        if( !Gate::allows('permissions_update') ) abort(403);

        $roles = Role::pluck('name', 'id')->toArray();

        return view( config('simple-permission.views.permissions.edit'), compact('permission', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        if( !Gate::allows('permissions_update') ) abort(403);

        $updated = false;

        $validated = $request->validated();

        try {
            if ( $permission->name != $request->name ) {
                $updated = true;
                $permission->name = $request->name;
            }
            $permissionRoles = $permission->roles->pluck('id')->toArray();
            if ( $permissionRoles != $request->roles ) {
                $updated = true;
                $permission->roles()->sync( $request->roles );
            }
        } catch ( \Exception $e ) {
            return redirect()->back()->with('error', 'Erro ao atualizar permission: ' . $e->getMessage() );
        }

        if ( $updated == true ) {
            $permission->save();
            $level = 'success';
            $message = __('Permission updated successfully.');
        } else {
            $level = 'info';
            $message = __('Nothing to update.');
        }

        return redirect()->route('simple-permission.permissions.index')->with($level, $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        if( !Gate::allows('permissions_delete') ) abort(403);

        try {
            $permission->delete();
        } catch ( \Exception $e ) {
            return redirect()->back()->with('error', 'Erro ao eliminar permission: ' . $e->getMessage() );
        }

        return redirect()->route('simple-permission.permissions.index')->with('success', __('Permission deleted successfully.'));
    }
}
