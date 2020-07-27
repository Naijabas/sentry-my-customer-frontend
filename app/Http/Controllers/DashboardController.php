<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
    protected $host;

    public function __construct()
    {
        $this->host = env('API_URL', 'https://dev.api.customerpay.me');
    }

    public function index()
    {
        // API updated
        if (Cookie::get('user_role') === 'super_admin') {

            $allInfo_url = env('API_URL', 'https://dev.api.customerpay.me') . '/dashboard/all';
            try {
                $client = new Client;
                $payload = [
                    'headers' => [
                        'x-access-token' => Cookie::get('api_token')
                    ]
                ];
                // Transaction endpoint is having issues
                $allInfoResponse = $client->request('GET', $allInfo_url, $payload);

                // Transaction endpoint is having issues
                $status_code_all_info = $allInfoResponse->getStatusCode();

                if ($status_code_all_info == 200) {
                    $allInfo_response_body = json_decode($allInfoResponse->getBody());
                    return view('backend.dashboard.index')->with('response', [$allInfo_response_body]);
                }
            } catch (RequestException $e) {

                return view('backend.dashboard.index')->with('response', null);
            } catch (\Exception $e) {
                return view('errors.500');
            }


        } elseif (Cookie::get('user_role') === 'store_admin') {
            $url = env('API_URL', 'https://dev.api.customerpay.me') . '/dashboard/';


            try {
                $client = new Client;
                $payload = [
                    'headers' => [
                        'x-access-token' => Cookie::get('api_token')
                    ]
                ];

                $response = $client->request('GET', $url, $payload);


                if ($response->getStatusCode() == 200) {
                    $data = json_decode($response->getBody());
                    $data = $data->data;
                    $thisMonth = $data->amountForCurrentMonth;
                    $lastMonth = $data->amountForPreviousMonth;
                    $diff = $thisMonth - $lastMonth;
                    // (Current period's revenue - prior period's revenue) ÷ by prior period's revenue x 100
                    $profit = ($thisMonth > $lastMonth) ? true : false;
                    $percentage = ($lastMonth == 0) ? '-' : sprintf("%.2f", ($diff / $lastMonth) * 100);

                    return view('backend.dashboard.index')->withData($data)->withProfit(['profit' => $profit, 'percentage' => $percentage]);
                }
            } catch (RequestException $e) {
                Log::info('Catch error: DashboardController - ' . $e->getMessage());
                // check for 5xx server error
                if ($e->getResponse()->getStatusCode() >= 500) {
                    return view('errors.500');
                } else {
                    return redirect()->route('logout');
                }

            } catch (\Exception $e) {
                Log::error('Catch error: StoreController - ' . $e->getMessage());
                return view('errors.500');
            }
        } else { // Todo: remove this when dashboard API is available
            //die();
            try {
                // Get all stores first
                $url = env('API_URL', 'https://dev.api.customerpay.me') . '/dashboard/assistant/';// . Cookie::get('user_id');
                $client = new Client();
                $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
                $response = $client->request("GET", $url, $headers);

                // First get the assistant details

                if ($response->getStatusCode() == 200) {
                    $data = json_decode($response->getBody());
                    $data = $data->data;
                    $data->name = isset($data->user->first_name) ? $data->user->first_name : $data->user->name;

                    $data->phone_number = $data->user->phone_number;
                    $data->email = $data->user->email;

                    return view('backend.dashboard.index')->withData($data);


                } else {
                    return view('errors.500');
                    // return back()->withErrors("An Error Occured. Please try again later");
                }


            } catch (\Exception $e) {
                if ($e->getCode() == 401) {
                    return redirect()->route('logout');
                }
                return view('errors.500');
                //return $response->getStatusCode();
            }
        }
    }

    public function notification()
    {
        $phone_number = Cookie::get('phone_number');
        $user = User::where('phone_number', $phone_number)->first();
        return view('backend.dashboard.notification')->with([
            'notifications' => $user->notifications,
            'user' => $user
        ]);
    }

    public function creditor()
    {
        return view('backend.dashboard.creditor');
    }

    public function analytics()
    {
        return view('backend.dashboard.analytics');
    }
}
