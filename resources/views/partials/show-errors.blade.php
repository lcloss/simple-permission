    @if( session()->has('status') )
        @if( session()->get('status') == 'verification-link-sent' )
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ __('Success') }}!</strong> {{ __('A new verification link has been sent to the email address you provided during registration') }}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            </div>
        @else
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>{{ __('Info') }}!</strong> {{ session()->get('status') }}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            </div>
        @endif
    @else
        @foreach(['success' => 'success', 'info' => 'info', 'warning' => 'warning', 'error' => 'danger', 'danger' => 'danger'] as $level => $alert)
            @if ( session()->has($level) )
                <div class="alert alert-{{ $alert }} alert-dismissible fade show" role="alert">
                    <p class="mb-0">{{ session()->get($level) }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                </div>
            @endif
        @endforeach
        @if ($errors->any() )
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ __('Error') }}!</strong> {{ __('Please check the form below for errors') }}.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            </div>
        @endif
   @endif
