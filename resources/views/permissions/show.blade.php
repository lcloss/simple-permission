@extends( config('simple-permission.views.layouts.app') )
@section('title', __('Permission Details'))
@section('description', 'Details of a Permission in the application')
@section('content')
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">{{ __('Permission Details') }}</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ url(\App\Providers\RouteServiceProvider::HOME) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ __('Permission Details') }}</li>
                        </ol>
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="mb-0">
                                    {{ __('Permission Details') }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end mb-3">
                                @can('permissions_list')
                                <a class="btn btn-outline-primary" href="{{ route('simple-permission.permissions.index') }}">{{ __('List permissions') }}</a>
                                @endcan
                                @can('permissions_update')
                                <a class="btn btn-outline-primary" href="{{ route('simple-permission.permissions.edit', $permission) }}">{{ __('Edit Permission') }}</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>{{ __('Permission Details') }}</h3>
                                <p class="mb-0">{{ __('Details of an existing permission') }}</p>
                            </div>
                            <div class="card-body">
                                @include('simple-permission::partials.show-errors')
                                    <div class="row mb-3">
                                        <div class="col-md-7">
                                            <h5>{{ __('Basic data') }}</h5>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                                    <p>{{ $permission->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <h5>{{ __('Roles') }}</h5>
                                            <div class="row mb-3">
                                            @foreach( $roles as $id => $role )
                                            <div class="col-md-12">
                                                <input type="checkbox" disabled name="roles[]" id="role-{{ $id }}" class="form-check-input"
                                                    {{ old('permissions', $permission->roles->pluck('id')->toArray() ) ? ( collect( old('roles', $permission->roles->pluck('id')->toArray() ))->contains( $id ) ? 'checked="checked"' : '' ) : '' }}>
                                                <label for="role-{{ $id }}" class="form-check-label">{{ __($role) }}</label>
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

