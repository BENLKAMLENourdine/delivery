<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Deliverytime;
use App\Http\Requests\DeliverytimeRequest;

class DeliverytimeController extends Controller
{
    public function store(DeliverytimeRequest $request)
    {
        try {
            $deliverytime = Deliverytime::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Delivery time created successfly',
                'span' => $deliverytime
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }
}
