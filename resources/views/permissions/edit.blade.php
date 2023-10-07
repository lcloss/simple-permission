@extends( config('simple-permission.views.layouts.app') )
@section('title', __('Edit Permission'))
@section('description', 'Update a Permission from the application')
@section('content')
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">{{ __('Edit Permission') }}</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ url(\App\Providers\RouteServiceProvider::HOME) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ __('Edit Permission') }}</li>
                        </ol>
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="mb-0">
                                    {{ __('Edit a permission') }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end mb-3">
                                @can('permissions_list')
                                <a class="btn btn-outline-primary" href="{{ route('simple-permission.permissions.index') }}">{{ __('List permissions') }}</a>
                                @endcan
                                @can('permissions_read')
                                <a class="btn btn-outline-primary" href="{{ route('simple-permission.permissions.show', $permission) }}">{{ __('Permission details') }}</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>{{ __('Edit a permission') }}</h3>
                                <p class="mb-0">{{ __('Update an existing permission') }}</p>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('simple-permission.permissions.update', $permission) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @include('simple-permission::partials.show-errors')
                                    <div class="row mb-3">
                                        <div class="col-md-7">
                                            <h5>{{ __('Basic data') }}</h5>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $permission->name) }}">
                                                    @if( $errors->has('name') )
                                                    <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <h5>{{ __('Roles') }}</h5>
                                            <div class="row mb-3">
                                            @foreach( $roles as $id => $role )
                                            <div class="col-md-12">
                                                <input type="checkbox" name="roles[]" id="role-{{ $id }}" class="form-check-input" value="{{ $id }}"
                                                    {{ old('permissions', $permission->roles->pluck('id')->toArray() ) ? ( collect( old('roles', $permission->roles->pluck('id')->toArray() ))->contains( $id ) ? 'checked="checked"' : '' ) : '' }}>
                                                <label for="role-{{ $id }}" class="form-check-label">{{ __($role) }}</label>
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

