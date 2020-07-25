<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Rules\DoNotAddIndianCountryCode;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Rules\NoZero;
use App\Rules\DoNotPutCountryCode;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
        return view('backend.password.recover');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'phone_number' => ['required', 'min:6', 'max:16', new NoZero, new DoNotPutCountryCode]
        ]);

        try {
            $client =  new Client();
            $response = $client->post($this->host . '/recover', [
                'form_params' => ['phone_number' => $request->input('phone_number')]
            ]);
            if ($response->getStatusCode() == 200) {
                $response = json_decode($response->getBody());
                $data = $response->data;
                if ($response->success) {
                    // set alert
                    $request->session()->flash('alert-class', 'alert-success');
                    $request->session()->flash('message', 'kindly check your Phone for verification code');
                    return view('backend.password.reset', [
                        'data' => $data,
                        'phoneNumber' => $request->input('phone_number'), 
                    ]);
                } else {
                    $message = $response->message;
                    $request->session()->flash('message', $message);
                    return redirect()->route('password');
                }
            }
            $request->session()->flash('message', $response->message);
            return redirect()->route('password');
        } catch (RequestException $e) {
            Log::info('ClientException ForgotPasswordController - .' . $e->getMessage());
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody());
                $request->session()->flash('message', $response->message);
                return redirect()->route('password');
            }
        } catch (\Exception $e) {

            Log::error("catch error: ForgotPasswordController - " . $e->getMessage());
            $request->session()->flash('message', 'Something bad happened');
            return view('errors.500');
        }
    }
}
