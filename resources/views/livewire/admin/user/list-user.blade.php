<div> 
    @section('title', ' - Users')
    <x-loading-indecator/>
    
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">User Page</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6"> 
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">User</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="mb-2 d-flex justify-content-between">
                <button class="btn btn-primary" wire:click.prevent="addUser">
                    <i class="fa fa-plus-circle"></i> Add new User
                </button>
                <x-search-input wire:model="searchTerm" />
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody wire:loading.class="text-muted">
                            @forelse ($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>
                                    <img class="mr-1 img img-circle" width="50px" src="{{$user->avatar_url}}" alt="">
                                    {{ $user->name }}
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a
                                        href="#"
                                        wire:click.prevent="editUser({{$user->id}})"
                                        ><i class="fa fa-edit"></i
                                    ></a>
                                    |
                                    <a
                                        href="#"
                                        wire:click.prevent="showDeleteModal({{$user->id}})"
                                        ><i class="fa fa-trash text-danger"></i
                                    ></a>
                                </td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="5">
                                    <img class="w-25" src="{{asset('img/noresult.png')}}" alt="">
                                    <p>No results found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $users->links() }}
                </div>
            </div>

            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    {{-- Add User Modal --}}
    <div class="modal fade" tabindex="-1" id="add-user" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{
                            $showEditModal == true
                                ? "Edit User"
                                : "Add New User"
                        }}
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form
                    wire:submit.prevent="{{
                        $showEditModal == true ? 'updateUser' : 'createUser'
                    }}"
                >
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input
                                type="text"
                                wire:model.defer="state.name"
                                class="
                                    form-control
                                    @error('name')
                                    is-invalid
                                    @enderror
                                "
                                id="name"
                            />
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input
                                type="text"
                                wire:model.defer="state.email"
                                class="
                                    form-control
                                    @error('email')
                                    is-invalid
                                    @enderror
                                "
                                id="email"
                            />
                            @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input
                                type="password"
                                wire:model.defer="state.password"
                                id="password"
                                class="
                                    form-control
                                    @error('password')
                                    is-invalid
                                    @enderror
                                "
                            />
                            @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="confirm-password"
                                >Confirm Password</label
                            >
                            <input
                                type="password"
                                wire:model.defer="state.password_confirmation"
                                id="confirm-password"
                                class="
                                    form-control
                                    @error('password_confirmation')
                                    is-invalid
                                    @enderror
                                "
                            />
                            @error('password_confirmation')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="profile">Profile Picture</label>
                            @if($photo)
                            <img width="50px;" class="mb-2 img img-circle d-block" src="{{$photo->temporaryUrl()}}" alt="">
                            @else
                            <img width="50px;" class="mb-2 img img-circle d-block" src="{{$state['avatar_url'] ?? ''}}" alt="">
                            @endif
                            <div class="custom-file">
                                <div x-data="{isUploading : false, progress : 10}"
                                 x-on:livewire-upload-start="isUploading = true"
                                 x-on:livewire-upload-finish="isUploading = false"
                                 x-on:livewire-upload-error="isUploading = false"
                                 x-on:livewire-upload-progress="progress = $event.detail.progress"   
                                >
                                    <input wire:model.defer="photo" type="file" class="custom-file-input" id="customFile">
                                    <div x-show="isUploading" class="mt-2 progress progress-sm active">
                                        <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width: ${progress}% `">
                                        <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                                <label class="custom-file-label" for="customFile">
                                    @if($photo)
                                        {{$photo->getClientOriginalName()}}
                                    @else 
                                        Choose Image
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            <i class="mr-1 fa fa-times"></i>
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="mr-1 fa fa-save"></i>
                            {{ $showEditModal == true ? "Update" : "Save" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-confirmation-alert/>
</div>
