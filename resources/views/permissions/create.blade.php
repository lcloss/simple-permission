@extends( config('simple-permission.views.layouts.app') )
@section('title', __('New Permission'))
@section('description', 'Add a new Permission to the application')
@section('content')
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">{{ __('New Permission') }}</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ url(\App\Providers\RouteServiceProvider::HOME) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ __('New Permission') }}</li>
                        </ol>
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="mb-0">
                                    {{ __('Add a new permission') }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end mb-3">
                                @can('permissions_list')
                                <a class="btn btn-outline-primary" href="{{ route('simple-permission.permissions.index') }}">{{ __('List permissions') }}</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>{{ __('New permission') }}</h3>
                                <p class="mb-0">{{ __('Add a new permission') }}</p>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('simple-permission.permissions.store') }}" method="POST">
                                    @csrf
                                    @include('simple-permission::partials.show-errors')
                                    <div class="row mb-3">
                                        <div class="col-md-7">
                                            <h5>{{ __('Basic data') }}</h5>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                                                    <div><span class="text-sm">{{ __('Type complete name or type prefix and select actions above.') }}</span></div>
                                                    @if( $errors->has('name') )
                                                    <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="slug" class="form-label">{{ __('Mass create') }}</label>
                                                    @foreach( ['create', 'read', 'update', 'delete'] as $action )
                                                        <div class="form-group">
                                                            <input type="checkbox" name="actions[]" id="action-{{ $action }}" class="form-check-input" {{ old('actions') ? ( old('actions')->contains( $id ) ? 'checked="checked"' : '' ) : '' }}>
                                                            <label for="action-{{ $action }}" class="form-check-label">{{ __($action) }}</label>
                                                        </div>
                                                    @endforeach
                                                    @if( $errors->has('actions') )
                                                    <div class="alert alert-danger">{{ $errors->first('actions') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <h5>{{ __('Roles') }}</h5>
                                            <div class="row mb-3">
                                            @foreach( $roles as $id => $role )
                                            <div class="col-md-12">
                                                <input type="checkbox" name="roles[]" id="role-{{ $id }}" class="form-check-input" {{ old('roles') ? ( old('roles')->contains( $id ) ? 'checked="checked"' : '' ) : '' }}>
                                                <label for="role-{{ $id }}" class="form-check-label">{{ __($role) }}</label>
                                            </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-1">
                                            <button class="btn btn-primary">{{ __('Add') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

@endsection

