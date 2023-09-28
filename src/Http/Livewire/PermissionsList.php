<?php

namespace Lcloss\SimplePermission\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Lcloss\SimplePermission\Models\Permission;

class PermissionsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public function mount()
    {
        $this->search = '';
    }

    public function render()
    {
        $permissions = Permission::withCount('roles')
            ->when( $this->search != '', function(Builder $query) {
                return $query->where('name', 'like', "%{$this->search}%" )
                    ->orWhereHas('roles', function(Builder $query) {
                        return $query->where('name', 'like', "%{$this->search}%" );
                    });
            })
            ->paginate(10);

        return view('simple-permission::livewire.permissions-list', compact('permissions'));
    }
}
