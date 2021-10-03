<?php
 
namespace App\Http\Livewire\Admin\User;
use App\Models\User;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Livewire\Admin\AdminComponent;

class ListUser extends AdminComponent
{
    protected $listeners = ['deleteconfirmed' => 'deleteUser'];
    public $state = [];
    use WithFileUploads;
    public $showEditModal = false;
    public $user;
    public $searchTerm;
    public $photo;
    //Add User
    public function addUser()
    {
        $this->reset();
        $this->showEditModal = false;
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
        if($this->photo){
            $data['avatar'] = $this->photo->store('/', 'avatars');
        }
        User::create($data);
        $id = "add-user";
        $this->dispatchBrowserEvent('close-form', ['id' => $id]);
        $this->dispatchBrowserEvent('success-msg', ['msg' => 'User Added Successfully']);
    }
    //Edit user
    public function editUser(User $user)
    {
        $this->reset();
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
        if($this->photo){
            if($this->user->avatar){
                Storage::disk('avatars')->delete($this->user->avatar);
            }
            $data['avatar'] = $this->photo->store('/', 'avatars');
        }
        $this->user->update($data);
        $this->dispatchBrowserEvent('close-form', ['id' =>'add-user']);
        $this->dispatchBrowserEvent('success-msg', ['msg' => 'User Updated Successfully']);
    }
    public function showDeleteModal(User $user)
    {
        $this->user = $user;
        $this->dispatchBrowserEvent('confirm-delete-confirmation');
    }
    //Delete User
    public function deleteUser()
    {
        $this->user->delete();
        $this->dispatchBrowserEvent('deleted', ['msg' => 'User Deleted Successfully']);
    } 
    public function render()
    {
        $user = User::
                where('name', 'like', '%'.$this->searchTerm.'%')
                ->orWhere('email', 'like', '%'.$this->searchTerm.'%')
                ->latest()
                ->paginate(12);
        return view('livewire.admin.user.list-user', ['users' => $user, ]);
    }
}
