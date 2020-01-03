<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\City;

class Deliverytime extends Model
{
    protected $fillable = ['span'];

    public function cities()
    {
    	return $this->belongsToMany(City::class)->withPivot('id');
    }
}
