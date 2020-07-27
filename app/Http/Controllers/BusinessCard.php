<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use PDF;

use SnappyImage;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

// use Illuminate\Support\Facades\Http;

class BusinessCard extends Controller
{
    //
    public function download_card(Request $request, $id){
        // return print_r($request->input());
        $format = $request->input('format');
        $version = $request->input('version');
        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store/' . $id;
        try {
            $client = new Client;
            $payload = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ],
                'form_params' => [
                    'current_user' => Cookie::get('user_id'),
                ]
            ];
            $response = $client->request("GET", $url, $payload);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();

            
            $StoreData = json_decode($body)->data->store;
           
            if ($statusCode == 200) {
                if($format =="pdf"){
                     $pdf = PDF::loadView('backend.cards.card_'.$version,[
                    "store_details" =>$StoreData
                     ] );
                    return $pdf->download('business_card.pdf');
                }
                if($format =="image"){
                    $image = SnappyImage::loadView('backend.cards.card_'.$version,[
                        "store_details" =>$StoreData
                    ] );
                    return $image->download('business_card.jpg');
                }
            }
        }catch (RequestException $e) {
            Log::info('Catch error: LoginController - ' . $e->getMessage());

            // check for 5xx server error
            if ($e->getResponse()->getStatusCode() >= 500) {
                return view('errors.500');
            } else if ($e->getResponse()->getStatusCode() >= 401) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "Your Session Has Expired, Please Login Again");
                return redirect()->route('store.index');
            }
            // get response to catch 4xx errors
            $response = json_decode($e->getResponse()->getBody());
            Session::flash('alert-class', 'alert-danger');

            Session::flash('message', $response->message);
            return redirect()->route('store.index', ['response' => []]);
        } catch (\Exception $e) {
            //log error;
            Log::error('Catch error: StoreController - ' . $e->getMessage());
            return view('errors.500');
        }
     
    }

    public function card_v2(){

        return view('backend.cards.card_v2');
    }


    public function preview_card(Request $request, $id){

        $version = $request->input('version');
        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store/' . $id;
        try {
            $client = new Client;
            $payload = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ],
                'form_params' => [
                    'current_user' => Cookie::get('user_id'),
                ]
            ];
            $response = $client->request("GET", $url, $payload);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();

            
            $StoreData = json_decode($body)->data->store;
           
            if ($statusCode == 200) {

                $pdf = SnappyImage::loadView('backend.cards.card_'.$version,[
                    "store_details" =>$StoreData
                ] );
                // $path = public_path("cards/".uniqid()."img.jpg");
                // $pdf->save($path);
                return $pdf->inline('business_card.jpg');
               
            }
        }catch (RequestException $e) {
            Log::info('Catch error: LoginController - ' . $e->getMessage());

            // check for 5xx server error
            if ($e->getResponse()->getStatusCode() >= 500) {
                return view('errors.500');
            } else if ($e->getResponse()->getStatusCode() >= 401) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "Your Session Has Expired, Please Login Again");
                return redirect()->route('store.index');
            }
            // get response to catch 4xx errors
            $response = json_decode($e->getResponse()->getBody());
            Session::flash('alert-class', 'alert-danger');

            Session::flash('message', $response->message);
            return redirect()->route('store.index', ['response' => []]);
        } catch (\Exception $e) {
            //log error;
            Log::error('Catch error: StoreController - ' . $e->getMessage());
            return view('errors.500');
        }
        // return print_r($request->input());
    }
}
