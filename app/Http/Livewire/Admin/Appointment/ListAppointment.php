<?php

namespace App\Http\Livewire\Admin\Appointment;

use App\Models\Client;
use App\Models\Appointment;
use Illuminate\Support\Facades\Validator;
use App\Http\Livewire\Admin\AdminComponent;


class ListAppointment extends AdminComponent
{
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
        dd($this->state);





        $data = Validator::make($this->state, [
            'client_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'note' => 'nullable',
        ])->validate();
        $data['status'] = 'open';
        Appointment::create($data);
        $this->dispatchBrowserEvent('close-form', ['id' => 'add-modal']);
        $this->dispatchBrowserEvent('success-msg', ['msg' => 'Appointment added successfully']);
    }
    public function render()
    {
        return view('livewire.admin.appointment.list-appointment', ['clients' => Client::all(),]);
    }
}
