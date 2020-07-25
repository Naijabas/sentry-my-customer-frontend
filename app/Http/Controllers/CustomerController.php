<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;
use GuzzleHttp\Exception\RequestException;

// FOR COUNTRY CODE AND PHONE NUMBER IMPLEMENTATION
use App\Rules\DoNotPutCountryCode;
use App\Rules\NoZero;
use stdClass;

class CustomerController extends Controller
{

    protected $host;

    public function __construct()
    {
        $this->host = env('API_URL', 'https://dev.api.customerpay.me');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Cookie::get('user_role') == 'super_admin') {
            $url = $this->host . '/customer/all';
            $store_url = $this->host . '/store/all';
        } else {
            $url = $this->host . '/customer';
            $store_url = $this->host . '/store';
        }

        try {
            $client = new Client();

            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $user_response = $client->request('GET', $url, $headers);
            $store_response = $client->request('GET', $store_url, $headers);

            $statusCode = $user_response->getStatusCode();
            $statusCode2 = $store_response->getStatusCode();

            if ($statusCode == 200 && $statusCode2 == 200) {

                $stores = json_decode($store_response->getBody())->data->stores;
                $allCustomers = [];

                if (Cookie::get('user_role') == 'super_admin') {
                    $userData = json_decode($user_response->getBody())->data->customers;
                    $_stores = [];
                    foreach ($stores as $adminStores) {
                        foreach ($adminStores as $store) {
                            foreach ($store->customers as $customer) {
                                $customer->store_name = $store->store_name;
                                $customer->store_id  = $store->_id;
                                $allCustomers[] = $customer;
                            }
                            $_stores[] = $store;
                        }
                    }
                    $stores = $_stores;
                } else {
                    $userData = json_decode($user_response->getBody())->data->customer;
                    foreach ($userData as $store) {
                        foreach ($store->customers as $customer) {
                            $customer->store_name = $store->storeName;
                            $customer->store_id  = $store->storeId;
                            $allCustomers[] = $customer;
                        }
                    }
                }
                return view('backend.customer.index')->with(['response' => $allCustomers, 'stores' => $stores]);
            }
            $request->session()->flash('message', $user_response . '<br>' . $store_response);
            $allCustomers = [];
            $stores = [];
            return view('backend.customer.index')->with(['response' => $allCustomers, 'stores' => $stores]);
        } catch (RequestException $e) {
            Log::info('Catch error: CustomerController - ' . $e->getMessage());

            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            // get response to catch 4 errors
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                Session::flash('message', $result->message);
                $response = [];
                $stores = [];
                return view('backend.customer.index',  compact('response', 'stores'));
            }
            return view('backend.customer.show')->with('errors.500');
        } catch (Exception $e) {
            // token expired
            dd($e->getMessage());
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            Log::error('Catch error: CustomerController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //
        $url = $this->host . '/customer/new/';

        if ($request->isMethod('post')) {
            $request->validate([
                'store_id' => 'required',
                'phone_number' =>  ['required', 'min:6', 'max:16',  new NoZero, new DoNotPutCountryCode],
                'name' => 'required | min:5 | max:30',
            ]);

            try {
                $client =  new Client();
                $payload = [
                    'headers' => ['x-access-token' => Cookie::get('api_token')],
                    'form_params' => [
                        'store_id' => $request->input('store_id'),
                        'phone_number' => $request->input('phone_number'),
                        'name' => $request->input('name'),
                    ],
                ];
                $response = $client->request("POST", $url, $payload);

                $statusCode = $response->getStatusCode();
                $body = $response->getBody();
                $data = json_decode($body);

                if ($statusCode == 201  && $data->success) {
                    $request->session()->flash('alert-class', 'alert-success');
                    Session::flash('message', $data->message);

                    return back();
                } else {
                    $request->session()->flash('alert-class', 'alert-waring');
                    Session::flash('message', $data->message);
                    return redirect()->view('backend.customer.create');
                }
            } catch (RequestException $e) {
                Log::info('Catch error: CustomerController - ' . $e->getMessage());

                // token expired
                if ($e->getCode() == 401) {
                    Session::flash('message', 'session expired');
                    return redirect()->route('logout');
                }

                // get response to catch 4 errors
                if ($e->hasResponse()) {
                    $response = $e->getResponse()->getBody();
                    $result = json_decode($response);
                    $message = isset($result->message) ? $result->message : (isset($result->Message) ? $result->Message : $result->error->error);
                    Session::flash('message', $message);
                }

                return back();
            } catch (Exception $e) {
                // token expired
                if ($e->getCode() == 401) {
                    Session::flash('message', 'session expired');
                    return redirect()->route('logout');
                }

                Log::error('Catch error: CustomerController - ' . $e->getMessage());
                return view('errors.500');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        // return view('backend.customer.show');
        if (!$id || empty($id)) {
            return view('errors.500');
        }

        $store_id = explode('-', $id)[0];
        $customer_id = explode('-', $id)[1];

        if (Cookie::get('user_role') == 'super_admin') {
            $url = $this->host . "/customer/admin/" . $store_id . "/" . $customer_id;
        } else {
            $url = $this->host . "/customer/" . $store_id . "/" . $customer_id;
        }

        try {
            $client = new Client;
            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $response = $client->request("GET", $url, $headers);
            $customer = json_decode($response->getBody())->data;
            if ($response->getStatusCode() == 200) {
                $result = $this->calculations($customer);
                $chartData = $this->chartData($customer);
                return view('backend.customer.show', compact('customer', 'result', 'chartData'));
            } else {
                return view('errors.500');
            }
        } catch (RequestException $e) {
            Log::info('Catch error: CustomerController - ' . $e->getMessage());

            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            // get response to catch 4 errors
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                $message = isset($result->message) ? $result->message : (isset($result->Message) ? $result->Message : $result->error->error);
                Session::flash('message', $message);
            }

            return back();
        } catch (Exception $e) {
            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            Log::error('Catch error: CustomerController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$id || empty($id)) {
            return back();
        }

        $store_id = explode('-', $id)[0];
        $customer_id = explode('-', $id)[1];

        try {
            $url = $this->host . "/customer/" . $store_id . "/" . $customer_id;
            $store_url = $this->host . '/store';
            $client = new Client;
            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];

            $response = $client->request("GET", $url, $headers);
            $store_response = $client->request('GET', $store_url, $headers);

            $data = json_decode($response->getBody());
            $stores = json_decode($store_response->getBody());
            if ($response->getStatusCode() == 200 && $store_response->getStatusCode() == 200) {
                $stores = $stores->data->stores;
                return view('backend.customer.edit')->with(['response' => $data->data, 'stores' => $stores]);
            } else {
                Session::flash('message', "Error occured; can't fetch customer's details at the moment");
                return back();
            }
        } catch (RequestException $e) {
            Log::info('Catch error: CustomerController - ' . $e->getMessage());

            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            // get response to catch 4 errors
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                $message = isset($result->message) ? $result->message : (isset($result->Message) ? $result->Message : $result->error->error);
                Session::flash('message', $message);
            }

            return back();
        } catch (Exception $e) {
            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            Log::error('Catch error: CustomerController - ' . $e->getMessage());
            return view('errors.500');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'phone_number' =>  ['required', 'min:6', 'max:16',  new NoZero, new DoNotPutCountryCode],
            'name' => 'required | min:5 | max:30',
        ]);

        $store_id = explode('-', $id)[0];
        $customer_id = explode('-', $id)[1];

        try {
            $url = $this->host . '/customer/update/' . $customer_id;

            $client = new Client();

            $payload = [
                'headers' => ['x-access-token' => Cookie::get('api_token')],
                'form_params' => [
                    'phone_number' => $request->input('phone_number'),
                    'name' => $request->input('name'),
                    'store_id' => $store_id,
                ],
            ];

            $response = $client->request("PUT", $url, $payload);

            $data = json_decode($response->getBody());

            if ($response->getStatusCode() == 200) {
                $request->session()->flash('alert-class', 'alert-success');
                $request->session()->flash('message', 'Customer updated successfully');

                return redirect()->back();
            } else {
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message', 'Customer update failed');
            }
        } catch (RequestException $e) {
            Log::info('Catch error: CustomerController - ' . $e->getMessage());

            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            // get response to catch 4 errors
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                $message = isset($result->message) ? $result->message : (isset($result->Message) ? $result->Message : $result->error->error);
                Session::flash('message', $message);
            }

            return redirect()->back();
        } catch (Exception $e) {
            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            Log::error('Catch error: CustomerController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        try {
            $url = $this->host . '/customer/delete/' . $id;

            $client = new Client();

            $payload = [
                'headers' => ['x-access-token' => Cookie::get('api_token')],

            ];

            $response = $client->request("DELETE", $url, $payload);

            $data = json_decode($response->getBody());

            if ($response->getStatusCode() == 200) {
                $request->session()->flash('alert-class', 'alert-success');
                $request->session()->flash('message', 'Customer deleted successfully');

                return redirect()->back();
            } else {
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message', 'Customer deleting failed');
            }
        } catch (RequestException $e) {
            Log::info('Catch error: CustomerController - ' . $e->getMessage());

            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            // get response to catch 4 errors
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                $message = isset($result->message) ? $result->message : (isset($result->Message) ? $result->Message : $result->error->error);
                Session::flash('message', $message);
            }

            return redirect()->back();
        } catch (Exception $e) {
            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            Log::error('Catch error: CustomerController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    public function calculations($data)
    {
        $transactions = $data->customer->transactions;
        $result = new stdClass;
        $result->total_revenue = 0;
        $result->total_debt = 0;
        $result->total_receivables = 0;
        $result->transactions = 0;

        foreach ($transactions as $trensaction) {
            if ($trensaction->type == 'debt') {
                $result->total_debt += $trensaction->amount + ($trensaction->amount * $trensaction->interest);
            } elseif ($trensaction->type == 'paid') {
                $result->total_revenue += $trensaction->amount;
            } else {
                $result->total_receivables += $trensaction->amount;
            }
            $result->transactions += 1;
        }

        return $result;
    }

    public function chartData($data)
    {
        $transactions = $data->customer->transactions;
        $result = [];

        if (count($transactions) < 2) {
            $_transactions['y'] = 0;
            $_transactions['x'] = date('D, d M Y H:i:s');
            $result[] = $_transactions;
        }

        foreach ($transactions as $trensaction) {
            $_transactions['y'] = $trensaction->amount;
            $_transactions['x'] = $trensaction->createdAt;
            $result[] = $_transactions;
        }
        return $result;
    }

}
