<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Weather;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUsers(){
        $users= User::all();
        foreach($users as $user){
            $user->weather = Weather::where('user_id',$user->id)->first();
        }
        return $users;
    }

    public function getUser($id){
        $users= User::find($id);
        return $users;
    }

    public function addUser(Request $request){
        $checkIfUserExist = User::where('email',$request->email)->first();
        if(!$checkIfUserExist){
        $User = new User;
        $User->name = $request->name;
        $User->email = $request->email;
        $User->latitude = rand(10, 8);
        $User->longitude = rand(11, 8);
        $User->password = Hash::make('password');
        $User->save();
        return $User;
        }
        return "User with that email Already exists";
    }
    public function update(Request $request, $id)
    {
        $user=User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->update();
        return $user;
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return  response()->json([
            'message'=>'User data deleted successfully'
        ]);
    }
    public function destroyAll()
    {
        // $user = User::find($id);
        // $user->delete();
        return  response()->json([
            'message'=>'User not allowed to delete data'
        ]);
    }

    public function search(Request $request)
    {
        $user=User::where('email', $request->email)->first();
        return $user;
    }

    public function getUserWeather($id,$lat, $lon)
    {
        $user= User::find($id);
        $user->weather = Weather::where('user_id',$user->id)->first();
        $lat= $user->latitude;
        $long= $user->longitude;
        $response ='';
        if(!$user->weatherinfo){
            $url= "https://api.openweathermap.org/data/2.5/forecast?lat=-1.2833&lon=36.8167&appid=a9b9dd17abb53c363feca33869e5dad2";
            $client = new \GuzzleHttp\Client();
            $results = $client->get($url);
            $response1 = $results->getBody()->getContents();
            $u=User::find($id);
            $u->weatherinfo = $response1;
            $u->update();
            $response =  $this->saveToWeatherDatabase($id,$response1);
        }else{
            $response =  $response;
        }
        return  $response;
    }
    
    public function getAddress(){

        // //Nairobi Kenya
        // $lat= -1.2833; //latitude
        // $long= 36.8167; //longitude

        // //India
        // $lat = 40.6781784;
        //  $long = -73.9441579;

                //  //India
                 $lat =-50.76419800;
                 $long = -30.98342600;

         $address =[];
        $geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=AIzaSyBYyeq115Qr8Jo41TSDUauPScbms2Rb9XU";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $geocode);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($response);
        $dataarray = get_object_vars($output);
        if ($dataarray['status'] != 'ZERO_RESULTS' && $dataarray['status'] != 'INVALID_REQUEST') {
            if (isset($dataarray['results'][0]->address_components)) {
                $address = $dataarray['plus_code']->compound_code;
                // $results = $dataarray['plus_code']->compound_code;
                // $str_arr = explode (",", $results); 
                // $country = $str_arr[count($str_arr)-1];
                // $city = $str_arr[count($str_arr)-2];
                // array_push($address,$country,$city);
    
            } else {
                $address = 'Not Found';
    
            }
        } else {
            $address = 'Not Found';
        }
    
        return $address;
    }
    public function saveToWeatherDatabase($id ,$request){
        $request =json_decode($request);
        $country = $request->city->country;
        $city = $request->city->name;
        $temp =$request->list[0]->main->temp;
        $temp_min =$request->list[0]->main->temp_min;
        $temp_max =$request->list[0]->main->temp_max;
        $presssure =$request->list[0]->main->pressure;
        $humidity =$request->list[0]->main->humidity;
        $sea_level =$request->list[0]->main->sea_level;

        $weather = new weather();
        $weather->user_id=$id;
        $weather->country=$country;
        $weather->city=$city;
        $weather->temp=$temp;
        $weather->temp_min=$temp_max;
        $weather->temp_max=$temp_max;
        $weather->pressure=$presssure;
        $weather->humidity=$humidity;
        $weather->sea_level=$sea_level;
        $weather->save();
        // $humidity =$request['list'][0]['main']['humidity'];
        // $sea_level =$request['list'][0]['main']['sea_level'];
        // return $request['city']['country'];
        // return $city;
        return $weather;
    }
    public function weather(Request $request){
        $request = $request->all();
        $weather =[];
        $country = $request['city']['country'];
        $city = $request['city']['name'];
        $temp =$request['list'][0]['main']['temp'];
        $temp_min =$request['list'][0]['main']['temp_min'];
        $temp_max =$request['list'][0]['main']['temp_max'];
        $presssure =$request['list'][0]['main']['pressure'];
        $humidity =$request['list'][0]['main']['humidity'];
        $sea_level =$request['list'][0]['main']['sea_level'];
        // return $request['city']['country'];
        // return $city;
        return $request['list'][0]['main'];
    }
}
