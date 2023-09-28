@extends( config('simple-permission.views.layouts.app') )
@section('title', __('Users list'))
@section('description', 'List of users of the application')
@section('content')
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">{{ __('Users') }}</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ url(\App\Providers\RouteServiceProvider::HOME) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ __('Users') }}</li>
                        </ol>
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="mb-0">
                                    {{ __('List of users') }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end mb-3">
                                @can('users_create')
                                <a class="btn btn-outline-primary" href="{{ route('simple-permission.users.create') }}">{{ __('New user') }}</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>{{ __('Users') }}</h3>
                                <p class="mb-0">{{ __('List of users') }}</p>
                            </div>
                            <div class="card-body">
                                @livewire('simple-permission::users-list')
                            </div>
                        </div>
                    </div>
@endsection
@section('modals')
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">{{ __('Confirm Deletion') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to delete this object?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('No') }}</button>
                <button type="button" class="btn btn-danger">{{ __('Yes') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
            $('.delete-button').on('click', function () {
                var form = $(this).closest('form');
                $('#confirmDeleteModal').modal('show');
                $('#confirmDeleteModal').on('click', '.btn-danger', function () {
                    form.trigger('submit');
                });
            });
        });
    </script>
@endsection
