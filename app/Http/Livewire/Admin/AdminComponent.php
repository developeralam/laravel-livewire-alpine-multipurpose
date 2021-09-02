<?php
namespace App\Http\Livewire\Admin;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
class AdminComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
}
?>