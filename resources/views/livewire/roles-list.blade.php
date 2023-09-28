                            <div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" wire:model="search" placeholder="{{ __('Search for roles and permissions') }}" />
                                    </div>
                                </div>
                                @if( count( $roles ) > 0 )
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('# Users') }}</th>
                                                <th class="col-6">{{ __('Permissions') }}</th>
                                                <th class="text-end">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $roles as $role )
                                        <tr>
                                            <td>{{ $role->id }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ count( $role->users ) }}</td>
                                            <td>@foreach( $role->permissions as $permission )<span class="badge badge-md bg-primary">{{ $permission->name }}</span>@endforeach</td>
                                            <td class="text-end">
                                                @can('roles_update')
                                                <a href="{{ route('simple-permission.roles.edit', $role->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> {{ __('Edit') }}</a>
                                                @endcan
                                                @can('roles_read')
                                                <a href="{{ route('simple-permission.roles.show', $role->id) }}" class="btn btn-sm btn-secondary"><i class="bi bi-eye"></i> {{ __('Details') }}</a>
                                                @endcan
                                                @can('roles_delete')
                                                <form id="deleteForm-{{ $role->id }}" action="{{ route('simple-permission.roles.destroy', $role) }}" method="POST" class="d-inline-block delete-form">
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
                                        {{ $roles->links() }}
                                    </p>
                                @else
                                    <p>{{ __('No role found.') }}</p>
                                @endif
                            </div>
