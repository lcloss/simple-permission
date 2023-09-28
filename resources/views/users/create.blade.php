@extends( config('simple-permission.views.layouts.app') )
@section('title', __('New User'))
@section('description', 'Add a new User to the application')
@section('content')
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">{{ __('New User') }}</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ url(\App\Providers\RouteServiceProvider::HOME) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ __('New User') }}</li>
                        </ol>
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="mb-0">
                                    {{ __('Add a new user') }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end mb-3">
                                @can('users_list')
                                <a class="btn btn-outline-primary" href="{{ route('simple-permission.users.index') }}">{{ __('List users') }}</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>{{ __('New user') }}</h3>
                                <p class="mb-0">{{ __('Add a new user') }}</p>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('simple-permission.users.store') }}" method="POST">
                                    @csrf
                                    @include('simple-permission::partials.show-errors')
                                    <div class="row mb-3">
                                        <div class="col-md-7">
                                            <h5>{{ __('Basic data') }}</h5>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                                                    @if( $errors->has('name') )
                                                    <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                                                    @if( $errors->has('email') )
                                                    <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                                    <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}">
                                                    @if( $errors->has('password') )
                                                    <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}">
                                                    @if( $errors->has('password_confirmation') )
                                                    <div class="alert alert-danger">{{ $errors->first('password_confirmation') }}</div>
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
                                                <label for="role-{{ $role . '-' . $id }}" class="form-check-label">{{ __($role) }}</label>
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

