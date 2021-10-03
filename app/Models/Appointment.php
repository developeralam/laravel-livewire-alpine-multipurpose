<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;
    protected $guarded = [''];
    protected $casts = [
        'date' => 'datetime',
        'time' => 'datetime',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'secduled' => 'primary',
            'closed' => 'success',
        ];
        return $badges[$this->status];
    }
}
