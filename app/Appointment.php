<?php

namespace App;

use App\Car;
use App\Workshop;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';
    public function car()
    {
        return $this->hasOne(Car::class,'id','car_id');
    }

    public function workshop()
    {
        return $this->hasOne(Workshop::class,'id','workshop_id');
    }
}
