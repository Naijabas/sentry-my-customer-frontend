<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\DoNotAddIndianCountryCode;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Cookie;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use App\Rules\NoZero;
use App\Rules\DoNotPutCountryCode;
use Symfony\Component\Console\Input\Input;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->host = env('API_URL', 'https://dev.api.customerpay.me');
    }


    public function index()
    {
        if (Cookie::get('api_token')) {
            return redirect()->route('dashboard');
        }
        return view('backend.register.signup');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    // Controller action to register a new user.
    public function register(Request $request)
    {

        $data = $request->validate([
            'phone_number' => ['required', 'min:6', 'max:16', new DoNotAddIndianCountryCode, new DoNotPutCountryCode],
            'password' => ['required', 'min:6']
        ]);

        try {

            if ($data) {

                $client = new Client();
                $response = $client->post($this->host . '/register/user', [
                    'form_params' => [
                        'phone_number' => $request->input('phone_number'),
                        'password' => $request->input('password')
                    ]
                ]);

                if ($response->getStatusCode() == 201) {

                    $res = json_decode($response->getBody());

                    if ($res->success) {

                        $request->session()->flash('message', 'You have registered Successfully');
                        $request->session()->flash('alert-class', 'alert-success');

                        $data = $res->data->user->local;
                        $api_token = $res->data->user->api_token;
                        $user_role = $res->data->user->local->user_role;

                        // store data to cookie
                        Cookie::queue('user_role', $user_role);
                        Cookie::queue('api_token', $api_token);
                        Cookie::queue('is_active', $data->is_active);
                        Cookie::queue('phone_number', $data->phone_number);
                        Cookie::queue('user_id', $res->data->user->_id);
                        Cookie::queue('expires', strtotime('+ 1 day'));

                        // Set is first timer so intros can show
                        Cookie::queue('is_first_time_user' , true);

                        return redirect()->route('activate.index');
                    }
                }

                $res = json_decode($response->getBody());
                if ($response->getStatusCode() == 200) {
                    $request->session()->flash('message', $res->Message);
                    $request->session()->flash('alert-class', 'alert-danger');
                    return redirect()->route('signup');
                }

                if ($res->success == false) {
                    $request->session()->flash('message', $res->error->description);
                    $request->session()->flash('alert-class', 'alert-danger');
                    return redirect()->route('signup');
                }
            }

            $request->session()->flash('message', 'Please fill the form correctly');
            $request->session()->flash('alert-class', 'alert-danger');
            return redirect()->route('signup');
        } catch (RequestException $e) {
            //log error;
            Log::error('Catch error: RegisterController - ' . $e->getMessage());

            // get response
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() >= 400) {
                    $response = json_decode($e->getResponse()->getBody());
                    $request->session()->flash('alert-class', 'alert-danger');
                    if (is_string($response->error->description) && $response->error->description === 'phone_number Invalid value') {
                        $request->session()->flash('message', 'The phone number is invalid or already in use');
                    } elseif (is_string($response->error->description)) {
                        $request->session()->flash('message', $response->error->description);
                    } else {
                        $request->session()->flash('message', "Phone number already in use, please use another phone number");
                    }
                    return redirect()->route('signup');
                }
            }
            // check for 500 server error
            return view('errors.500');
        } catch (\Exception $e) {
            //log error;
            Log::error('Catch error: RegisterController - ' . $e->getMessage());
            return view('errors.500');
        }
    }
}
