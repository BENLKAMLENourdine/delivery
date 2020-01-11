<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\City;
use App\Deliverytime;
use App\Excludedspan;
use DateInterval;
use DateTime;
use App\Http\Requests\CityRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class CityController extends Controller
{
    public function store(CityRequest $request) {
        try {
            $city = City::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'City created successfly',
                'city' => $city
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_OK);
        }
    }

    public function attach(Request $request, $city_id) {
        try {
            $city = City::findOrFail($city_id);
            $deliverytime = Deliverytime::findOrFail($request->all());
            $city->deliveryTimes()->attach($deliverytime);
            return response()->json([
                'status' => 'success',
                'message' => 'Delivery time attached successfly'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_CONFLICT);
        }
    }

    public function exclude(Request $request, $city_id) {
        try {
            $city = City::findOrFail($city_id);
            $data = $request->all();
            foreach ($data as $key => $value) {
                $pivotExist = $city->deliveryTimes()->findOrFail($value[0]);
                if($pivotExist)
                {
                    $excluded = new Excludedspan();
                    $excluded->city_deliverytime_id = $pivotExist->pivot->id;
                    $excluded->date = $value[1];
                    $excluded->save();
                }
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Delivery times excluded from dates successfly'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ],JsonResponse::HTTP_CONFLICT);
        }
    }

    public function excludeAll(Request $request, $city_id) {
        try {
            $city = City::findOrFail($city_id);
            $pivots = $city->deliveryTimes()->get();
            $data = $request->all();
            $collection = collect($pivots);
            $matrix = $collection->crossJoin($data);
            $matrix->all();
            foreach ($matrix as $value) {
                $city_deliverytime_id = $value[0]->pivot->id;
                $excluded = new Excludedspan();
                $excluded->city_deliverytime_id = $city_deliverytime_id;
                $excluded->date = $value[1];
                $excluded->save();
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Delivery times axcluded from dates successfly'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_CONFLICT);
        }
    }

    public function getDeliveryDatesTimes($city_id, $number_of_days_to_get){
        try {
            $dates = array();
            $interval = new DateInterval('P1D');
            $firstDay = new DateTime(date('Y-m-d'));
            $dates[] = $firstDay->format('Y-m-d');
            for ($i=1; $i < $number_of_days_to_get; $i++) { 
                $firstDay = $firstDay->add($interval);
                $dates[] = $firstDay->format('Y-m-d');
            }

            $city = City::findOrFail($city_id);
            $deliveryTimes = $city->deliveryTimes()->get();
            $json = ["dates" => []];
            $day = ["delivery_times" => []];
            $delivery_times = ["id" => "", "delivery_at" => "", "created_at" => "", "updated_at" => ""];
            foreach ($dates as $date) {
                $day["delivery_times"] = [];
                    foreach ($deliveryTimes as $deliveryTime) {
                        $city_deliverytime_id = $deliveryTime->pivot->id;
                        $excludedSpan = Excludedspan::where([['city_deliverytime_id', $city_deliverytime_id],['date', $date]])->first();
                        if($excludedSpan === null) $day["delivery_times"][] = ["id" => $deliveryTime->id, "delivery_at" => $deliveryTime->span, "created_at" => $deliveryTime->created_at, "updated_at" => $deliveryTime->updated_at];
                    }
                if (count($day["delivery_times"]) !== 0) {
                $json["dates"][] = ["day_name" => date("l", strtotime($date)), "date" => $date, "delivery_times" => $day["delivery_times"]];
                }
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Delivery dates times indexed successfly',
                'response' => $json
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_CONFLICT);
        }
    }
}
