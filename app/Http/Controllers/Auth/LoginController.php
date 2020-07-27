<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\DoNotAddIndianCountryCode;
use App\Rules\DoNotPutCountryCode;
use App\Rules\NoZero;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

// use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $host;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->host = env('API_URL', 'https://dev.api.customerpay.me');
    }

    public function index()
    {
        if (Cookie::get('api_token')) {
            return redirect()->route('dashboard');
        }
        return view('backend.auth.login');
    }

    public function assistant()
    {
        if (Cookie::get('api_token')) {
            return redirect()->route('dashboard');
        }
        return view('backend.auth.assistant');
    }

    public function authenticateAssistant(Request $request)
    {
        $this->validateUser($request);

        try {
            $client = new Client();
            $response = $client->post($this->host . '/login/assistant', [
                'form_params' => [
                    'phone_number' => $request->input('phone_number'),
                    'password' => $request->input('password'),
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $response = json_decode($response->getBody());

                if ($response->success) {

                    $assistant = $response->data;

                    //check if active
                    if ($assistant->user->is_active == false) {
                        $message = "Kindly contact your admin for activation";
                        $request->session()->flash('message', $message);
                        return redirect()->route('login.assistant');
                    }

                    // store data to cookie
                    Cookie::queue('id', $assistant->user->_id); // todo: remove this later. I left it just in case an error occurs. it has been here for a long time
                    Cookie::queue('user_id', $assistant->user->_id);
                    Cookie::queue('name', $assistant->user->name);
                    Cookie::queue('email', $assistant->user->email);
                    Cookie::queue('store_id', $assistant->user->store_id);
                    Cookie::queue('is_active', $assistant->user->is_active);
                    Cookie::queue('api_token', $assistant->user->api_token);
                    Cookie::queue('user_role', $assistant->user->user_role);
                    Cookie::queue('phone_number', $assistant->user->phone_number);

                    Cookie::queue('expires', strtotime('+ 1 day'));

                    Cookie::queue('is_first_time_user', false);

                    return view('backend.dashboard.assistant.index', compact('assistant'));
                    // return view('backend.dashboard.assistant.index')->with('assistant', $assistant);

                } else {
                    $request->session()->flash('message', 'Invalid Credentials');
                    return redirect()->route('login.assistant');
                }
            }

            $request->session()->flash('message', 'Invalid Credentials');
            return redirect()->route('login.assistant');
        } catch (RequestException $e) {
            //log error;
            Log::error('Catch error: LoginController - ' . $e->getMessage());
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() >= 400) {
                    // get response to catch 4xx errors
                    $response = json_decode($e->getResponse()->getBody());
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', 'Invalid Credentials');
                    return redirect()->route('login.assistant');
                }
            }
            // check for 500 server error
            return view('errors.500');
        } catch (\Exception $e) {
            //log error;

            Log::error('Catch error: LoginController - ' . $e->getMessage());
            return view('errors.500');
        }
        return redirect()->route('login.assistant');
    }

    public function authenticate(Request $request)
    {
        $this->validateUser($request);

        try {
            $client = new Client();
            $response = $client->post($this->host . '/login/user', [
                'form_params' => [
                    'phone_number' => $request->input('phone_number'),
                    'password' => $request->input('password')
                ]
            ]);

            if ($response->getStatusCode() == 200) {

                $response = json_decode($response->getBody());

                if (isset($response->success) && $response->success) {

                    $data = $response->data->user->local;

                    // store data to cookie
                    Cookie::queue('api_token', $response->data->user->api_token);
                    Cookie::queue('user_role', $response->data->user->local->user_role);
                    Cookie::queue('first_name', isset($response->data->user->local->first_name) ? $response->data->user->local->first_name : $response->data->user->local->name);
                    Cookie::queue('email', $response->data->user->local->email);
                    Cookie::queue('last_name', isset($response->data->user->local->last_name) ? $response->data->user->local->last_name : $response->data->user->local->name);
                    Cookie::queue('is_active', $data->is_active);
                    Cookie::queue('phone_number', $data->phone_number);
                    Cookie::queue('user_id', $response->data->user->_id);
                    // Cookie::queue('image', $response->data->user->image);
                    Cookie::queue('expires', strtotime('+ 1 day'));

                    Cookie::queue('is_first_time_user', false);

                    //show success message
                    $request->session()->flash('alert-class', 'alert-success');
                    $request->session()->flash('message', $response->message);

                    //check if active
                    if ($data->is_active == false) {
                        return redirect()->route('activate.index');
                    }
                    return redirect()->route('dashboard');
                } else {
                    $request->session()->flash('message', 'Invalid Credentials');
                    return redirect()->route('login');
                }
            }

            $request->session()->flash('message', 'Invalid Credentials');
            return redirect()->route('login');
        } catch (RequestException $e) {
            //log error;
            Log::error('Catch error: LoginController - ' . $e->getMessage());

            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() >= 400) {
                    // get response to catch 4xx errors
                    $response = json_decode($e->getResponse()->getBody());
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', 'Invalid Credentials');
                    return redirect()->route('login');
                }
            }
            // check for 500 server error
            return view('errors.500');
        } catch (\Exception $e) {
            //log error;
            Log::error('Catch error: LoginController - ' . $e->getMessage());
            return view('errors.500');
        }
        return redirect()->route('login');
    }

    public function validateUser(Request $request)
    {

        $rules = [
            'phone_number' => ['required', 'min:6', 'max:16', new DoNotAddIndianCountryCode, new DoNotPutCountryCode],
            'password' => ['required', 'min:6']
        ];

        $messages = [
            'phone_number.*' => 'Invalid Credentials',
            'password.*' => 'Invalid Credentials',
        ];

        $this->validate($request, $rules, $messages);
    }
}
