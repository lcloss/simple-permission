                            <div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" wire:model="search" placeholder="{{ __('Search for permissions and permissions') }}" />
                                    </div>
                                </div>
                                @if( count( $permissions ) > 0 )
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
                                        @foreach( $permissions as $permission )
                                        <tr>
                                            <td>{{ $permission->id }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td>@foreach( $permission->roles as $role )<span class="badge badge-md bg-primary">{{ $role->name }}</span>@endforeach</td>
                                            <td class="text-end">
                                                @can('permissions_update')
                                                <a href="{{ route('simple-permission.permissions.edit', $permission->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> {{ __('Edit') }}</a>
                                                @endcan
                                                @can('permissions_read')
                                                <a href="{{ route('simple-permission.permissions.show', $permission->id) }}" class="btn btn-sm btn-secondary"><i class="bi bi-eye"></i> {{ __('Details') }}</a>
                                                @endcan
                                                @can('permissions_delete')
                                                <form id="deleteForm-{{ $permission->id }}" action="{{ route('simple-permission.permissions.destroy', $permission) }}" method="POST" class="d-inline-block delete-form">
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
                                        {{ $permissions->links() }}
                                    </p>
                                @else
                                    <p>{{ __('No permission found.') }}</p>
                                @endif
                            </div>
