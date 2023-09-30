@extends( config('simple-permission.views.layouts.app') )
@section('title', __('Edit Role'))
@section('description', 'Update a Role from the application')
@section('content')
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">{{ __('Edit Role') }}</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ url(\App\Providers\RouteServiceProvider::HOME) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ __('Edit Role') }}</li>
                        </ol>
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="mb-0">
                                    {{ __('Edit a role') }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end mb-3">
                                @can('roles_list')
                                <a class="btn btn-outline-primary" href="{{ route('simple-permission.roles.index') }}">{{ __('List roles') }}</a>
                                @endcan
                                @can('roles_read')
                                <a class="btn btn-outline-primary" href="{{ route('simple-permission.roles.show', $role) }}">{{ __('Role details') }}</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>{{ __('Edit a role') }}</h3>
                                <p class="mb-0">{{ __('Update an existing role') }}</p>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('simple-permission.roles.update', $role) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @include('simple-permission::partials.show-errors')
                                    <div class="row mb-3">
                                        <div class="col-md-5">
                                            <h5>{{ __('Basic data') }}</h5>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $role->name) }}">
                                                    @if( $errors->has('name') )
                                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="slug" class="form-label">{{ __('Slug') }}</label>
                                                    <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug', $role->slug) }}">
                                                    @if( $errors->has('slug') )
                                                    <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="level" class="form-label">{{ __('Level') }}</label>
                                                    <input type="number" step="1" class="form-control" name="level" id="level" value="{{ old('level', $role->level) }}">
                                                    <div><span class="text-sm">{{ __('Level 1 is reserved for super admin. Lower number is more power.') }}</span></div>
                                                    @if( $errors->has('level') )
                                                    <div class="invalid-feedback">{{ $errors->first('level') }}</div>
                                                    @endif
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
                                                            <input type="checkbox" name="permissions[]" id="permission-{{ $id }}" class="form-check-input" value="{{ $id }}"
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
                                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

@endsection

