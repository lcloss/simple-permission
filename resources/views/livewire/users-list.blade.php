                            <div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" wire:model="search" placeholder="{{ __('Search for user names, emails and roles') }}" />
                                    </div>
                                </div>
                                @if( count( $users ) > 0 )
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Name') }}</th>
                                                <th class="col-6">{{ __('Roles') }}</th>
                                                <th class="text-end">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $users as $user )
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}<br>{{ $user->email }}</td>
                                            <td>@foreach( $user->roles as $role )<span class="badge badge-md bg-primary">{{ $role->name }}</span>@endforeach</td>
                                            <td class="text-end">
                                                @can('users_update')
                                                <a href="{{ route('simple-permission.users.edit', $user->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> {{ __('Edit') }}</a>
                                                @endcan
                                                @can('users_read')
                                                <a href="{{ route('simple-permission.users.show', $user->id) }}" class="btn btn-sm btn-secondary"><i class="bi bi-eye"></i> {{ __('Details') }}</a>
                                                @endcan
                                                @can('users_delete')
                                                <form id="deleteForm-{{ $user->id }}" action="{{ route('simple-permission.users.destroy', $user) }}" method="POST" class="d-inline-block delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger delete-button" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                                                        <i class="bi bi-trash"></i> {{ __('Delete') }}
                                                    </button>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <p>
                                        {{ $users->links() }}
                                    </p>
                                @else
                                    <p>{{ __('No user found.') }}</p>
                                @endif
                            </div>

