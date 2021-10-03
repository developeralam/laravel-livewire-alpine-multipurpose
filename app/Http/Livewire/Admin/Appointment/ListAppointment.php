<?php

namespace App\Http\Livewire\Admin\Appointment;

use App\Models\Client;
use App\Models\Appointment;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use App\Http\Livewire\Admin\AdminComponent;


class ListAppointment extends AdminComponent
{
    protected $listeners = ['deleteconfirmed' => 'delete'];
    public $appointment;
    public $status;
    use WithPagination;
    protected $paginationtheme = 'bootstrap';
    protected $queryString = ['status'];
    public $state = [];
    public $showEditModal = false;
    //Add Modal show
    public function addAppointment()
    {
        $this->dispatchBrowserEvent('show-form', ['id' => 'add-modal']);
    }
    //Add
    public function createAppointment()
    {
        $data = Validator::make($this->state, [
            'client_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'note' => 'required',
            'status' => 'required',
        ] )->validate();
        Appointment::create($data);
        $this->dispatchBrowserEvent('close-form', ['id' => 'add-modal']);
        $this->dispatchBrowserEvent('success-msg', ['msg' => 'Appointment Created Successfully']);
    }
    public function confirmAppointmentRemoval(Appointment $appointment)
    { 
        $this->appointment = $appointment;
        $this->dispatchBrowserEvent('confirm-delete-confirmation');
    }
    public function delete()
    {
        $this->appointment->delete();
        $this->dispatchBrowserEvent('deleted', ['msg' => 'Appointment Deleted Successfully']);
    }
    public function filterAppointmentByStatus($status = null)
    {
        $this->resetPage();
        $this->status = $status;
    }
    public function render()
    {
        $appointmentCount = Appointment::count();
        $scheduledAppointmentCount = Appointment::where('status', 'secduled')->count();
        $closedAppointmentCount = Appointment::where('status', 'closed')->count();

        return view('livewire.admin.appointment.list-appointment', [
            'clients'                   => Client::all(),
            'appointments'              => Appointment::with('client')
                                            ->when($this->status, function($query, $status){
                                                return $query->where('status', $status);
                                            })
                                            ->latest()
                                            ->paginate(5),
            'appointmentCount'          => $appointmentCount,
            'scheduledAppointmentCount' => $scheduledAppointmentCount,
            'closedAppointmentCount'    => $closedAppointmentCount,
        ]);
    }
}
