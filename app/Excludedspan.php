<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Excludedspan extends Model
{
    protected $table = 'excluded_spans';
    
    protected $fillable = ['city_id', 'span_id', 'date'];
}
