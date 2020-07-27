<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cookie;

class ComplaintController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaints";
        $url_s = env('API_URL', 'https://dev.api.customerpay.me') . "/complaints/all";
        $user_role = Cookie::get('user_role');

        $client = new Client();

        $headers = [
            'headers' => [
                'x-access-token' => Cookie::get('api_token')
            ]
        ];
        if ($user_role == 'super_admin'){
            $response = $client->request('GET', $url_s, $headers);
        }else{
            $response = $client->request('GET', $url, $headers);
        }

        $statusCode = $response->getStatusCode();

        if ($statusCode == 200) {

            $body = $response->getBody()->getContents();
            $complaints = json_decode($body);
            return view('backend.complaints.index')->with('responses', $complaints);
        } elseif ($statusCode == 401) {

            return redirect()
                ->route('login')
                ->with('message', "Please Login Again");
        }
        // return view('backend.complaints.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.complaints.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'subject' => 'required',
            'message' => 'required|max:500|min:10'
        ]);

        $user_id = Cookie::get('user_id');
        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaint/new";

        try {
            $client = new Client();
            $firstname = Cookie::get('first_name');
            $lastname = Cookie::get('last_name');
            $email = Cookie::get('email');
            $payload = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ],
                "form_params" => [
                    "message" => $request->input('message'),
                    "subject" => $request->input('subject'),
                    "name" => $firstname." ".$lastname,
                    "email" => $email
                ]
            ];

            $req = $client->request('POST', $url, $payload);
            $statusCode = $req->getStatusCode();
            $response = json_decode($req->getBody()->getContents());

            if ($statusCode == 200) {

                $request->session()->flash('success', $response->message);

                return redirect()->route('complaint.index');
            } else {

                $message = isset($response->Message) ? $response->Message : $response->message;
                $request->session()->flash('message', $message);
                return back();
            }
        } catch (RequestException $e) {

            //log error;
            Log::error('Catch error: ComplaintController - ' . $e->getMessage());

            if ($e->hasResponse()) {
                // get response to catch 4xx errors
                $response = json_decode($e->getResponse()->getBody());
                $request->session()->flash('error', "Make sure all fields are filled .\n Make sure the description is more than 10 characters");
                return back();
            }
            // check for 500 server error
            return view('errors.500');
        } catch (\Exception $e) {
            //log error;
            Log::error('Catch error: ComplaintController - ' . $e->getMessage());
            $request->session()->flash('error', 'Could not connect to the server. Please try again later');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaint/" . $id;
        $user_id = Cookie::get('user_id');

        try {

            $client = new Client();

            $headers = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ]
            ];

            $response = $client->request('GET', $url, $headers);
            $statusCode = $response->getStatusCode();
            if ($statusCode == 200) {

                $body = $response->getBody()->getContents();
                $complaints = json_decode($body);

                return view('backend.complaints.show')->with('response', $complaints);
            }
            if ($statusCode == 500) {

                return view('errors.500');
            }
        } catch (\Exception $e) {

            return view('errors.500');
        }
        // return view('backend.complaints.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaint/" . $id;
        $user_id = Cookie::get('user_id');

        try {

            if ( Cookie::get('user_role') == "super_admin") {

                $client = new Client();

                $headers = [
                    'headers' => [
                        'x-access-token' => Cookie::get('api_token')
                    ]
                ];

                $response = $client->request('GET', $url, $headers);
                $statusCode = $response->getStatusCode();
                if ($statusCode == 200) {

                    $body = $response->getBody()->getContents();
                    $complaints = json_decode($body);
                    return view('backend.complaints.status')->with('response', $complaints);
                }
                if ($statusCode == 500) {

                    return view('errors.500');
                }
            } else {

                \Session::flash('error', 'You do not have access to do this');
                return back();
            }

        } catch (\Exception $e) {

            return view('errors.500');
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
        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaint/update/" . $id;

        try {
            $client = new Client();

            $request->validate([
                'status' => 'required',
            ]);

            $payload = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ],
                "form_params" => [
                    "status" => $request->input('status')
                ]
            ];

            $req = $client->request('PUT', $url, $payload);
            $statusCode = $req->getStatusCode();

            if ($statusCode == 200) {

                $body = $req->getBody()->getContents();
                $response = json_decode($body);
                return redirect()->route('complaint.index')->with('success', 'Complaint Status Changed');
            }
            if ($statusCode == 500) {

                return view('errors.500');
            }
            if ($statusCode == 401) {

                //Uncomment this when frontend has created the form page
                return view('backend.complaintlog.update')->with('error', "Unauthoized token");
                // return response()->json([
                //     "message" => "401, Unauthorized token",
                //     "info" => "Please, If the frontend for the update form has been done, uncomment line 114 of ComplaintsLogController to render the page",
                // ]);
            }
            if ($statusCode == 404) {

                //Uncomment this when frontend has created the form page
                return view('backend.complaintlog.update')->with('error', "Complaint not found");
                // return response()->json([
                //     "message" => "401, Unauthorized token",
                //     "info" => "Please, If the frontend for the update form has been done, uncomment line 122 of ComplaintsLogController to render the page",
                // ]);
            }
        } catch (\Exception $e) {

            return view('errors.500');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaint/delete/" . $id;

        $user_id = Cookie::get('user_id');

        $headers = [
            'headers' => [
                'x-access-token' => Cookie::get('api_token')
            ]
        ];

        try {

            $client = new Client();
            $request = $client->delete($url, $headers);
            $statusCode = $request->getStatusCode();

            if ($statusCode == 200) {

                return redirect()->route('complaint.index')->with('success', 'Complaint Deleted Successfully');
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error while deleting complaint');
        }
    }
}
