@extends( config('simple-permission.views.layouts.app') )
@section('title', __('Role Details'))
@section('description', 'Details of a Role in the application')
@section('content')
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">{{ __('Role Details') }}</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ url(\App\Providers\RouteServiceProvider::HOME) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ __('Role Details') }}</li>
                        </ol>
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="mb-0">
                                    {{ __('Role Details') }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end mb-3">
                                @can('roles_list')
                                <a class="btn btn-outline-primary" href="{{ route('simple-permission.roles.index') }}">{{ __('List roles') }}</a>
                                @endcan
                                @can('roles_update')
                                <a class="btn btn-outline-primary" href="{{ route('simple-permission.roles.edit', $role) }}">{{ __('Edit Role') }}</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>{{ __('Role Details') }}</h3>
                                <p class="mb-0">{{ __('Details of an existing role') }}</p>
                            </div>
                            <div class="card-body">
                                @include('simple-permission::partials.show-errors')
                                    <div class="row mb-3">
                                        <div class="col-md-5">
                                            <h5>{{ __('Basic data') }}</h5>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                                    <p>{{ $role->name }}</p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="slug" class="form-label">{{ __('Slug') }}</label>
                                                    <p>{{ $role->slug }}</p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="level" class="form-label">{{ __('Level') }}</label>
                                                    <p>{{ $role->level }}</p>
                                                    <div><span class="text-sm">{{ __('Level 1 is reserved for super admin. Lower number is more power.') }}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <h5>{{ __('Permissions') }}</h5>
                                            <div class="row mb-3">
                                            @foreach( $permissionsOptions as $group => $permissions )
                                                <div class="col-md-4 mb-3">
                                                <h6>{{ $group }}</h6>
                                                    <div class="row">
                                                    @foreach( $permissions as $id => $permission )
                                                        <div class="col-md-12">
                                                            <input type="checkbox" name="permissions[]" id="permission-{{ $id }}" class="form-check-input" disabled
                                                                   {{ old('permissions', $role->permissions->pluck('id')->toArray() ) ? ( collect( old('permissions', $role->permissions->pluck('id')->toArray() ))->contains( $id ) ? 'checked="checked"' : '' ) : '' }}>
                                                            <label for="permission-{{ $permission . '-' . $id }}" class="form-check-label">{{ __($permission) }}</label>
                                                        </div>
                                                    @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-1">
                                            <button type="button" onclick="history.back()" class="btn btn-primary">{{ __('Go back') }}</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

@endsection

