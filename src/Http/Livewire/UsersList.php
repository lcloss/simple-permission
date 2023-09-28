<?php

namespace Lcloss\SimplePermission\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UsersList extends Component
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
        $users = User::withCount('roles')
            ->when( $this->search != '', function(Builder $query) {
                return $query->where('name', 'like', "%{$this->search}%" )
                    ->orWhere('email', 'like', "%{$this->search}%" )
                    ->orWhereHas('roles', function(Builder $query) {
                        return $query->where('name', 'like', "%{$this->search}%" );
                    });
            })
            ->paginate(10);

        return view('simple-permission::livewire.users-list', compact('users'));
    }
}
