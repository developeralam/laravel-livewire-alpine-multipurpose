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
    public $showEditModal = false;
    public $user;
    //Add User
    public function addUser()
    {
        $this->showEditModal = false;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form', ['id' => 'add-user']);
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
        $this->dispatchBrowserEvent('success-msg', ['msg' => 'User Added Successfully']);
    }
    //Edit user
    public function editUser(User $user)
    {
        $this->user = $user;
        $this->showEditModal = true;
        $this->state = $user->toArray();
        $this->dispatchBrowserEvent('show-form', ['id' => 'add-user']);
    }
    //Update user
    public function updateUser()
    {
        $data = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
            'password' => 'sometimes|confirmed',
        ])->validate();
        if(!empty($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }
        $this->user->update($data);
        $this->dispatchBrowserEvent('close-form', ['id' =>'add-user']);
        $this->dispatchBrowserEvent('success-msg', ['msg' => 'User Updated Successfully']);
    }
    public function showDeleteModal(User $user)
    {
        $this->dispatchBrowserEvent('show-form', ['id' => 'dlt-modal']);
        $this->user = $user;
    }
    //Delete User
    public function deleteUser()
    {
        $this->user->delete();
        $this->dispatchBrowserEvent('close-form', ['id' => 'dlt-modal']);
        $this->dispatchBrowserEvent('success-msg', ['msg' => 'User Deleted Successfully']);
    }
    public function render()
    {
        return view('livewire.admin.user.list-user', ['users' => User::paginate(12)]);
    }
}
