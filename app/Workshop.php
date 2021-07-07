<?php

namespace App;

use App\Appointment;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $table = 'workshops';
    public function appointments()
    {
        return $this->hasMany(Appointment::class,'id','workshop_id');
    }
}
