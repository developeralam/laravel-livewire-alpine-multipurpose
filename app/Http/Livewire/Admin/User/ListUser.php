<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class ListUser extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $state = [];
    //Add User
    public function addUser()
    {
        $this->state = [];
        $id = 'add-user';
        $this->dispatchBrowserEvent('show-form', ['id' => $id]);
    }
    //Create User
    public function createUser()
    {
        $data = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ])->validate();
        $data['password'] = bcrypt($data['password']);
        User::create($data);
        $id = "add-user";
        $this->dispatchBrowserEvent('close-form', ['id' => $id]);
    }
    //Edit user
    public function editUser()
    {
    }
    //Update user
    public function updateUser()
    {
        # code...
    }
    //Delete User
    public function deleteUser()
    {
        # code...
    }
    public function render()
    {
        return view('livewire.admin.user.list-user', ['users' => User::paginate(12)]);
    }
}
