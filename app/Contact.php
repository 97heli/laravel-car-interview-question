<?php

namespace App;

use App\Car;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
