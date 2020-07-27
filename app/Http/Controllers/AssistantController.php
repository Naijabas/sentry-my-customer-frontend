<?php

namespace App\Http\Controllers;

use App\Rules\DoNotPutCountryCode;
use App\Rules\NoZero;
use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class AssistantController extends Controller
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
    // TODO: Cleanup codes
        try {
            $url = env('API_URL', 'https://dev.api.customerpay.me') . '/assistant';
            $client = new Client();

            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $user_response = $client->request('GET', $url, $headers);
            //dd(json_decode($user_response->getBody()));

            $statusCode = $user_response->getStatusCode();


            if ($statusCode == 200) {
                $assistants = json_decode($user_response->getBody());
                $assistants = $assistants->data->assistants;

                // get all stores
                $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store';
                $client = new Client();
                $user_response = $client->request('GET', $url, $headers);
                //dd(json_decode($user_response->getBody()));

                $statusCode = $user_response->getStatusCode();


                if ($statusCode == 200) {
                    $stores = json_decode($user_response->getBody());
                    // dd($stores);
                    $stores = $stores->data->stores;
                    return view('backend.assistant.index')->withAssistants($assistants)->withStores($stores);
                }

                if ($statusCode == 500) {
                    return view('errors.500');
                }
            }

            if ($statusCode == 500) {
                return view('errors.500');
            }
        } catch (\RequestException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            $data = json_decode($e->getResponse()->getBody()->getContents());
            if ($statusCode == 401) { //401 is error code for invalid token
                return redirect()->route('logout');
            }

            return view('errors.500');
        } catch (\Exception $e) {
            if ($e->getCode() == 401) {
                return redirect()->route('logout')->withErrors("Please Login Again");
            }

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
        try {
            $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store';
            $client = new Client();

            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $user_response = $client->request('GET', $url, $headers);
            //dd(json_decode($user_response->getBody()));

            $statusCode = $user_response->getStatusCode();


            if ($statusCode == 200) {
                $stores = json_decode($user_response->getBody());
                // dd($stores);
                $stores = $stores->data->stores;
                return view('backend.assistant.create')->withStores($stores);
            }

            if ($statusCode == 500) {
                return view('errors.500');
            }
        } catch (\RequestException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            $data = json_decode($e->getResponse()->getBody()->getContents());
            if ($statusCode == 401) { //401 is error code for invalid token
                return redirect()->route('logout');
            }

            return view('errors.500');
        } catch (\Exception $e) {
            if ($e->getCode() == 401) {
                return redirect()->route('logout')->withErrors("Please Login Again");
            }

            return view('errors.500');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/assistant/new';

        //return dd($request->all());

        $request->validate([
            'name' => "required|min:3",
            'phone_number' => ["required", new NoZero, new DoNotPutCountryCode],
            'store_id' => "required",
            'email' => "required|email",
            'password' => "required"
        ]);

        try {

            $client = new Client();
            $payload = [
                'headers' => ['x-access-token' => Cookie::get('api_token')],
                'form_params' => [
                    'name' => $request->input('name'),
                    'phone_number' => $request->input('phone_number'),
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'store_id' => $request->input('store_id')
                ],
            ];
            $response = $client->request("POST", $url, $payload);
            $statusCode = $response->getStatusCode();

            $body = $response->getBody();
            $data = json_decode($body);

            if ($statusCode == 201 || $statusCode == 200) {
                $request->session()->flash('alert-class', 'alert-success');
                Session::flash('message', $data->message);
                return redirect()->route('assistants.index');
            } else {
                $request->session()->flash('alert', 'alert-waring');
                Session::flash('message', $data->message);
                return redirect()->route('assistants.index');
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();

            if ($statusCode == 500) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "An Error occured please try again later");
                Log::error((string)$response->getBody());
                return back();
            }

            $data = json_decode($response->getBody());
            $request->session()->flash('alert-class', 'alert-danger');
            Session::flash('message', $data->message);
            return redirect()->route('assistants.index');
            //return back();
        } catch (Exception $e) {
            // dd($e);
            if ($e->getCode() == 401) {
                return redirect()->route('logout')->withErrors("Please Login Again");
            }

            Session::flash('message', "An error occured. Please try again later");
            return redirect()->route('assistants.index');
            //return back();
        }

        //return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */


    public function show($id)
    {
        // todo: get the user from the api and pass to the veiw
        try {
            // Get all stores first


            $url = env('API_URL', 'https://dev.api.customerpay.me') . '/assistant/' . $id;
            $client = new Client();
            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $response = $client->request("GET", $url, $headers);

            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody());
                $data = $data->data;

                $data->_id = $data->user->_id;
                $data->name = isset($data->user->first_name) ? $data->user->first_name : $data->user->name;
                $data->phone_number = $data->user->phone_number;
                $data->email = $data->user->email;

                // dd($data);
                return view('backend.assistant.show')->withData($data);


            } else {
                // return view('errors.500');
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', "An Error occured please try again later");
                return back();
            }


        } catch (\Exception $e) {
            // dd($e->getCode());
            if ($e->getCode() == 401) {
                return redirect()->route('logout');
            }
            return view('errors.500');
            //return $response->getStatusCode();
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$id || empty($id)) {
            return view('errors.500');
        }

        try {
            // Get all stores first

            $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store';
            $client = new Client();

            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $user_response = $client->request('GET', $url, $headers);
            //dd(json_decode($user_response->getBody()));

            $statusCode = $user_response->getStatusCode();


            if ($statusCode == 200) {
                $stores = json_decode($user_response->getBody());
                // dd($stores);
                $stores = $stores->data->stores;

                $url = env('API_URL', 'https://dev.api.customerpay.me') . '/assistant/' . $id;
                $client = new Client();
                $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
                $response = $client->request("GET", $url, $headers);
                $data = json_decode($response->getBody());
                // dd($data);

                if ($response->getStatusCode() == 200) {
                    // dd( $data->data->store_assistant);
                    return view('backend.assistant.edit')->with('response', $data->data->user)->withStores($stores);

                } else {
                    return view('errors.500');
                }
            } else {
                return back()->withErrors("An Error Occured. Please try again later");
            }

        } catch (\Exception $e) {
              // dd($e);
            // dd($e->getCode());
            if ($e->getCode() == 401) {
                return redirect()->route('logout')->withErrors("Please Login Again");
            }
            return view('errors.500');
            //return $response->getStatusCode();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/assistant/update/' . $id;
// dd($request->all());
        $request->validate([
            'name' => "required|min:3",
            'phone_number' => "required",
            'email' => "required|email",
            'store_id' => "required"
        ]);

        try {

            $client = new Client();
            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $data = [
                $headers,
                'form_params' => [
                    'token' => Cookie::get('api_token'),
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone_number' => $request->input('phone_number'),
                    'store_id' => $request->input('store_id')
                ],
            ];

            $response = $client->request("PUT", $url, $data);
            $status = $response->getStatusCode();

            if ($status == 200 || $status == 201) {
                $body = $response->getBody()->getContents();
                // $res = json_encode($body);
                $request->session()->flash('alert-class', 'alert-success');
                Session::flash('message', "Update Successful");
                return redirect()->route('assistants.index');
            } else {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "Update Failed");
                return back();
            }

        } catch (\Exception $e) {

            if ($e->getCode() == 401) {
                return redirect()->route('logout')->withErrors("Please Login Again");
            }
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message', 'An Error Occured. Please Try Again Later');

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $assistant_id)
    {
        //update
        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/assistant/delete/' . $assistant_id;
        $client = new Client();
        $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
        try {

            $delete = $client->delete($url, $headers);
            if ($delete->getStatusCode() == 200 || $delete->getStatusCode() == 201) {
                $request->session()->flash('alert-class', 'alert-success');
                Session::flash('message', "Store assistant successfully deleted");
                return redirect()->route('assistants.index');
            } else if ($delete->getStatusCode() == 401) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "You are not authorized to perform this action, please check your details properly");
                return redirect()->route('assistants.index');
            } else if ($delete->getStatusCode() == 500) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "A server error encountered, please try again later");
                return redirect()->route('assistants.index');
            }
        } catch (ClientException $e) {
            $request->session()->flash('alert-class', 'alert-danger');
            Session::flash('message', "A technical error occured, we are working to fix this.");
            return redirect()->route('assistants.index');
        }
    }
}