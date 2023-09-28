<?php

namespace Lcloss\SimplePermission\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Lcloss\SimplePermission\Models\Role;

class RolesList extends Component
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
        $roles = Role::withCount('permissions')
            ->when( $this->search != '', function(Builder $query) {
                return $query->where('name', 'like', "%{$this->search}%" )
                    ->orWhereHas('permissions', function(Builder $query) {
                        return $query->where('name', 'like', "%{$this->search}%" );
                    });
            })
            ->paginate(10);

        return view('simple-permission::livewire.roles-list', compact('roles'));
    }
}
