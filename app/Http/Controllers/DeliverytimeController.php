<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deliverytime;

class DeliverytimeController extends Controller
{
    public function create(Request $request)
    {
        $deliverytime = Deliverytime::create($request->all());
    }
}
