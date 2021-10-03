<div>
    <x-loading-indecator />
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
            <div class="mb-2 d-flex justify-content-between">
                <button class="btn btn-primary" wire:click.prevent="addAppointment">
                    <i class="fa fa-plus-circle"></i> Add new Appointment
                </button>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button wire:click.prevent="filterAppointmentByStatus" type="button" class="pr-2 btn btn-{{is_null($status) ? 'secondary' : 'default'}}">All<span class="badge badge-pill badge-primary">{{$appointmentCount}}</span></button>
                    <button wire:click.prevent="filterAppointmentByStatus('secduled')" type="button" class="pr-2 btn btn-{{($status == 'secduled') ? 'secondary' : 'default'}}">Schedule<span class="badge badge-pill badge-info">{{$scheduledAppointmentCount}}</span></button>
                    <button wire:click.prevent="filterAppointmentByStatus('closed')" type="button" class="pr-2 btn btn-{{($status == 'closed') ? 'secondary' : 'default'}}">Closed<span class="badge badge-pill badge-success">{{$closedAppointmentCount}}</span></button>
                </div>
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
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$appointment->client->name}}</td>
                                <td>{{$appointment->date->toFormatedDate()}}</td>
                                <td>{{$appointment->time->toFormatedTime()}}</td>
                                <td><span class="badge badge-{{$appointment->status_badge}}">{{$appointment->status}}</span></td>
                                <td>
                                    <a wire:click.prevent="edit($appointment->id)"
                                        ><i class="fa fa-edit"></i
                                    ></a>
                                    |
                                    <a wire:click.prevent="confirmAppointmentRemoval({{$appointment->id}})"
                                        ><i class="fa fa-trash text-danger"></i
                                    ></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{$appointments->links()}}
                </div>
            </div>

            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    {{-- Add Appointment Modal --}}
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
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="client_id">Client</label>
                            <select wire:model.defer="state.client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror">
                                @foreach($clients as $client)
                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                @endforeach
                            </select>
                            @error('client_id')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Date</label>
                            <div wire:ignore class="input-group date" id="datepicker" data-target-input="nearest" data-appointmentdate = "@this">
                                <x-datepicker wire.model.defer="sate.date" id="datepicker"/>
                                <div class="input-group-append" data-target="#datepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" wire:ignore>
                            <label for="">Time</label>
                            <div class="input-group date" id="timepicker" data-target-input="nearest" data-appointmenttime = "@this">
                                <x-timepicker wire:model="state.time" id="timepicker" :error="'time'"/>
                                <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                                
                            </div>
                            @error('time')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group" wire:ignore>
                            <label for="note">Note</label>
                            <textarea id="note" data-note="@this" cols="30" rows="10" class="form-control"></textarea>
                            @error('note')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select wire:model.defer="state.status" class="form-control @error('status') is-invalid @enderror" id="status">
                                <option value="">SELECT ONE</option>
                                <option value="secduled">SECDULED</option>
                                <option value="closed">CLOSED</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
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
                        <button type="submit" wire:click.prevent="createAppointment" id="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
</div>
@push('js')
<script>
    ClassicEditor
     .create( document.querySelector( '#note' ) )
     .then( editor => {
        document.querySelector( '#submit').addEventListener( 'click', () => { 
            let note = $("#note").data('note');
            eval(note).set('state.note', editor.getData());
        });
    })
     .catch( error => {
             console.error( error );
    })
    $("#datepicker").on("change.datetimepicker", function(e){
        let date = $(this).data('appointmentdate');
        eval(date).set('state.date', $('#appointmentDateInput').val());
    });
    
    $('#timepicker').on("change.datetimepicker", function(e){
        let time = $(this).data('appointmenttime');
        eval(time).set('state.time', $('#appointmentTimeInput').val());
    });
 </script>
@endpush
