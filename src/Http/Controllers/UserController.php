<?php

namespace Lcloss\SimplePermission\Http\Controllers;

use Illuminate\Routing\Controller;
use Lcloss\SimplePermission\Http\Requests\StoreUserRequest;
use Lcloss\SimplePermission\Http\Requests\UpdateUserRequest;
use Lcloss\SimplePermission\Models\Role;
use App\Models\User;
use Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( !Gate::allows('users_list') ) abort(403);

        $users = User::withCount('roles')->paginate(10);

        return view( config('simple-permission.views.users.index'), compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if( !Gate::allows('users_create') ) abort(403);

        $roles = Role::select('id', 'name')->orderBy('level', 'ASC')->pluck('name', 'id')->toArray();

        return view( config('simple-permission.views.users.create'), compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        if( !Gate::allows('users_create') ) abort(403);

        $validated = $request->validated();

        try {
            $user = User::create([
                'name'          => $validated['name'],
                'email'         => $validated['email'],
                'password'      => $validated['password'],
            ]);
            if ( !is_null( $request->roles ) ) {
                $user->roles->attach($request->roles);
            }

        } catch ( \Exception $e ) {
            return redirect()->back()->with('error', __('Error creating user: :msg', ['msg' => $e->getMessage()] ) );
        }

        session()->flash('success', __('User successfully created.'));

        return redirect()->route('simple-permission.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if( !Gate::allows('users_read') ) abort(403);

        $roles = Role::select('id', 'name')->orderBy('level', 'ASC')->pluck('name', 'id')->toArray();

        return view( config('simple-permission.views.users.show'), compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if( !Gate::allows('users_update') ) abort(403);

        $roles = Role::select('id', 'name')->orderBy('level', 'ASC')->pluck('name', 'id')->toArray();

        return view( config('simple-permission.views.users.edit'), compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if( !Gate::allows('users_update') ) abort(403);

        $updated = false;

        $validated = $request->validated();

        try {
            if ( $user->name != $request->name ) {
                $updated = true;
                $user->name = $request->name;
            }
            if ( $user->email != $request->email ) {
                $updated = true;
                $user->email = $request->email;
            }
            if ( $user->password != $request->password && !empty( $request->password ) ) {
                $updated = true;
                $user->password = $request->password;
            }
            if ( $user->roles->pluck('id')->toArray() != $request->roles ) {
                $updated = true;
                $user->roles()->sync($request->roles);
            }

        } catch ( \Exception $e ) {
            return redirect()->back()->with('error', __('Error updating user :msg', ['msg' => $e->getMessage()]) );
        }

        if ( $updated == true ) {
            $user->save();
            $level = 'success';
            $message = __('User updated successfuly.');
        } else {
            $level = 'info';
            $message = __('No data was updated.');
        }

        return redirect()->route('simple-permission.users.index')->with($level, $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if( !Gate::allows('users_delete') ) abort(403);

        try {
            $user->delete();
        } catch ( \Exception $e ) {
            return redirect()->back()->with('error', __('Error deleting user: :msg', ['msg' => $e->getMessage()]) );
        }

        return redirect()->route('simple-permission.users.index')->with('success', __('User successfully deleted.'));
    }
}
