<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Deliverytime;

class City extends Model
{
    protected $fillable = ['name', 'slug'];
    
    public function deliveryTimes()
    {
    	 return $this->belongsToMany(Deliverytime::class)->withPivot('id');
    }
}
