<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserTable extends Component
{
    use WithPagination;

    public int $perPage = 5;
    public string $search = '';
    protected $updatesQueryString = ['search', 'perPage'];
    public ?User $userBeingDeleted = null;

    protected $listeners = [
        'userCreated' => 'handleUserCreated',
        'userUpdated' => 'handleUserUpdated',
    ];
    public array $perPageOptions = [5, 10, 25, 50];

    public function updatingPerPage($value)
    {
        if (!in_array($value, $this->perPageOptions)) {
            $this->perPage = 5;
        }
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function handleUserUpdated($userId)
    {
        // Cari posisi user dengan id $userId berdasarkan urutan id ascending
        $position = User::where('id', '<=', $userId)->count();

        // Hitung halaman user tersebut
        $page = (int) ceil($position / $this->perPage);

        // Arahkan ke halaman tersebut
        $this->gotoPage($page);
    }


    public function handleUserCreated()
    {
        $total = User::count();
        $lastPage = (int) ceil($total / $this->perPage);
        $this->gotoPage($lastPage); // langsung ke halaman terakhir
    }


    public $userIdBeingDeleted;

    public function confirmUserDeletion($id)
    {
        $this->userIdBeingDeleted = $id;
        $this->userBeingDeleted = User::find($id);
        $this->dispatch('openDeleteModal');
    }


    public function deleteUser()
    {
        User::findOrFail($this->userIdBeingDeleted)->delete();

        $this->userIdBeingDeleted = null;
        $this->userBeingDeleted = null;

        $this->dispatch('userDeleted');
        $this->dispatch('toast:success', 'Berhasil Hapus data');
    }


    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $users = $query->paginate($this->perPage);

        return view('livewire.admin.users.user-table', [
            'users' => $users,
        ])->layout('livewire.layouts.admin.admin');
    }
}
