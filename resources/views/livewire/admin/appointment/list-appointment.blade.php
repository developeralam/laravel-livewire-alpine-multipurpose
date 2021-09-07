<div>
    @section('title', ' - Appointment')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">Appointment</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Appointment</li>
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
            <div class="mb-2 d-flex justify-content-end">
                <button class="btn btn-primary" wire:click.prevent="addAppointment">
                    <i class="fa fa-plus-circle"></i> Add new Appointment
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"></th>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="#" wire:click.prevent=""
                                        ><i class="fa fa-edit"></i
                                    ></a>
                                    |
                                    <a href="#" wire:click.prevent=""
                                        ><i class="fa fa-trash"></i
                                    ></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer"></div>
            </div>

            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    {{-- Add User Modal --}}
    <div class="modal fade" tabindex="-1" id="add-modal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{
                            $showEditModal == true
                                ? "Edit User"
                                : "Add New Appointment"
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
                    wire:submit.prevent="createAppointment"
                >
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="client_id">Client</label>
                            <select wire:model.defer="state.client_id" id="client_id" class="form-control">
                                @foreach($clients as $client)
                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Date</label>
                            <div wire:ignore class="input-group date" id="datetimepicker4" data-target-input="nearest" data-appointmentdate = "@this">
                                <input type="text" class="form-control datetimepicker-input" id="appointmentDateInput" data-target="#datetimepicker4" />
                                <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Time</label>
                            <div class="input-group date" id="datetimepicker3" data-target-input="nearest" data-appointmenttime = "@this">
                                <input type="text" id="appointmentTimeInput" class="form-control datetimepicker-input" data-target="#datetimepicker3" />
                                <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editor">Note</label>
                            <input type="text" wire:model.defer="state.note" id="editor">
                            <trix-editor input="editor" id="test"></trix-editor>
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
                        <button type="submit" id="submit" class="btn btn-primary">
                            <i class="mr-1 fa fa-save"></i>
                            {{ $showEditModal == true ? "Update" : "Save" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" tabindex="-1" id="dlt-modal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete User</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Are You Sure To Delete This User?</h4>
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
                    <button
                        type="button"
                        wire:click.prevent="deleteUser"
                        class="btn btn-primary"
                    >
                        <i class="mr-1 fa fa-save"></i>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
