<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Deliverytime;
use App\Excludedspan;
use DateInterval;
use DateTime;

class CityController extends Controller
{
    public function create(Request $request) {
        $city = City::create($request->all());
    }

    public function attach(Request $request, $city_id) {
    	$city = City::find($city_id);
        $deliverytime = Deliverytime::find($request->all());
		$city->deliveryTimes()->attach($deliverytime);
    }

    public function exclude(Request $request, $city_id) {
    	$city = City::find($city_id);
        $data = $request->all();
        foreach ($data as $key => $value) {
            $pivotExist = $city->deliveryTimes()->find($value[0]);
            if($pivotExist)
            {
                $excluded = new Excludedspan();
                $excluded->city_deliverytime_id = $pivotExist->pivot->id;
                $excluded->date = $value[1];
                $excluded->save();
            }
        }
    }

    public function excludeAll(Request $request, $city_id) {
    	$city = City::find($city_id);
        $pivots = $city->deliveryTimes()->get();
        $data = $request->all();
        foreach ($pivots as $key => $value) {
            $city_deliverytime_id = $value->pivot->id;
            foreach ($data as $key1 => $value1) {
                $excluded = new Excludedspan();
                $excluded->city_deliverytime_id = $city_deliverytime_id;
                $excluded->date = $value1;
                $excluded->save();
            }
        }
    }

    public function getDeliveryDatesTimes($city_id, $number_of_days_to_get){
        $dates = array();
        $interval = new DateInterval('P1D');
        $firstDay = new DateTime(date('Y-m-d'));
        $dates[] = $firstDay->format('Y-m-d');
        for ($i=1; $i < $number_of_days_to_get; $i++) { 
            $firstDay = $firstDay->add($interval);
            $dates[] = $firstDay->format('Y-m-d');
        }
        $city = City::find($city_id);
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
            $json["dates"][] = ["day_name" => date("l", strtotime($date)), "date" => $date, "delivery_times" => $day["delivery_times"]];
        }
        return json_encode($json);
    }
}
