<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MusementController extends Controller
{
    public function index() {
        $musementAPIURL = "https://api.musement.com/api/v3/cities";
        $response = file_get_contents($musementAPIURL);
        $newsData = json_decode($response);

        $data = array(
            'title'=>'My App',
            'Description'=>'This is New Application',
            'author'=>'foo',
            'apiURL' => $newsData,
        );
        //return view('musements')->with('data',$data);

        return response()->json($newsData);
    }

    public function city()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://sandbox.musement.com/api/v3/cities?offset=0&limit=10&sort_by=weight&without_events=no', [
            'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'en-US',
            ],
        ]);

        $status = $response->getStatusCode();
        $cities = $response->getBody();
        $testCities = json_decode($cities);

        foreach($testCities as $city) {
            $weather = $this->weather($city->latitude,$city->longitude,2);
            echo $city->name.' | '.$weather->forecast->forecastday[0]->day->condition->text.' - '.$weather->forecast->forecastday[1]->day->condition->text.'<br/>';
        }
    }

    public function weather($lat,$lon,$days)
    {
        $weatherKey = "42e439848f2d46f88cb203400220203";
        $weatherAPIURL = "http://api.weatherapi.com/v1/forecast.json?key=".$weatherKey."&q=".$lat.",".$lon."&days=".$days."";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $weatherAPIURL, [
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Language' => 'en-US',
            ],
        ]);

        $status = $response->getStatusCode();
        $weathers = $response->getBody();
        $testWeathers = json_decode($weathers);

        return $testWeathers;
    }
}
