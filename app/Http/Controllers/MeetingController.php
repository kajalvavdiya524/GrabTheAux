<?php

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use App\Group;
use App\Meeting;
use App\Participant;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\DataTables\MeetingsDataTable;
use Auth;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;

class MeetingController extends Controller
{
    public $token = '';
    public  $api_key='EMS-a-waRLOAxoC8HW8Nrg';
    public $api_secret='2CbMJzXfEBKlBp7pHe2FoTpEsaR1xKGZuxGI';

    public function __construct(){
        $this->middleware('zoomCredientials', ['only' => ['meetings']]);
        $this->token = '';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(MeetingsDataTable $dataTable){
        try {
            return $this->getMeetingUtils()->getMeetingsList($dataTable);
        } catch (ModelNotFoundException $exception) {
            get_log($exception);
            return back()->withErrors($exception->getMessage())->withInput();
        }
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('meetings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function createMeeting(Request $request){
      $request->validate([
          'meeting_id' => 'required',
          'passcode' => 'required',
      ]);
      try {
         return $this->getMeetingUtils()->createMeeting($request);

      } catch (ModelNotFoundException $exception) {
          get_log($exception);
          return back()->withErrors($exception->getMessage())->withInput();
      }
    }

    public function auth_zoom_verification(Request $request) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://zoom.us/oauth/authorize?response_type=code&client_id=".env('ZOOM_CLIENT_ID')."&redirect_uri=https://good-starfish-34.loca.lt",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));
        $response = curl_exec($curl);
        $redirectedUrl = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
        $err = curl_error($curl);
        curl_close($curl);
        return response()->json(['redirect_url' => $redirectedUrl]);
    }

    public function auth_code(Request $request) {
        $setCode = session()->put('code', $request->code);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://zoom.us/oauth/token?grant_type=authorization_code&code=".$request->code."&redirect_uri=https://good-starfish-34.loca.lt",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer ". base64_encode($this->api_key.':'.$this->api_secret),
                "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        dd($response);
        $err = curl_error($curl);
        curl_close($curl);
        return true;
    }

 public function checkMeeting(Request $request){
      try {
         return $this->getMeetingUtils()->checkMeeting($request);

      } catch (ModelNotFoundException $exception) {
          get_log($exception);
          return back()->withErrors($exception->getMessage())->withInput();
      }
    }

    public function store(Request $request){
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        try {
            return $this->getMeetingUtils()->deleteMeeting($id);
        } catch (ModelNotFoundException $exception) {
            get_log($exception);
            return back()->withErrors($exception->getMessage())->withInput();
        }
    }

    public function joinMeeting()
    {
        return view('meetings.join_meeting');
    }

    public function saveMeetingData(Request $request){
        try {
            return response()->json($this->getMeetingUtils()->saveMeetingData($request));
        } catch (ModelNotFoundException $exception) {
            get_log($exception);
            return response()->json($exception->getMessage());
        }
    }

    public function meetingCallback(Request $request){
        $user = [];
        try {
            $user = Socialite::driver('zoom')->user();
            $user->topic = 'Grab the Aux';
            $user->password = 'KnJby1';
            $user->type = 3; //recurring meeting
            $this->token = $user->token;
            return $this->getMeetingUtils()->generateMeetingViaZoom($user);
        }

            catch (\Exception $exception) {
             return back()->withErrors($exception->getMessage())->withInput();
        }
    }



    public function generate_signature(Request $request){

        // $api_key, $api_secret, $meeting_number, $role
        $api_key    = $request->apiKey;
        $api_secret  = $request->api_secret;
        $meeting_number=$request->meeting_no;
        $role      = $request->role;
        $time = time() * 1000 - 30000;//time in milliseconds (or close enough)

        $data = base64_encode($api_key . $meeting_number . $time . $role);

        $hash = hash_hmac('sha256', $data, $api_secret, true);

        $_sig = $api_key . "." . $meeting_number . "." . $time . "." . $role . "." . base64_encode($hash);

        return response()->json(['signature' => rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=')]);
    }


    public function checkUser(){
        $user_id = Auth::user()->id;
        $meetings = Meeting::where('user_id',$user_id)->latest('created_at')->first();
        return response()->json([
            'success'=>true,
            'meeting' => $meetings
            ]);
    }

    public function saveData(Request $request){
        $data = $request->data;
        $user_id = Auth::user()->id;
        $meeting = Meeting::where('user_id',$user_id)->latest('created_at')->first();
        $group_id = $meeting->group_id;
        $saveGroup = Group::create(['group_id'=>$group_id,'data'=>$data]);
        if($saveGroup)
        {
            return 1;
        }else{
            return 0;
        }
    }

    public function meetingParticipants(Request $request)
    {
      //$request->onlyhost =true
      // then return host
        if($request->onlyhost)
        {
            $participants = Participant::with('user')->where(['meeting_id' => $request->id, 'role' => 1])->get()->toArray();

        }
        // dd($request->all());
        else
        {
            $participants = Participant::with('user')->whereHas('user', function($q)
            {
                $q->where('id', '!=', Auth::user()->id);
            })->where('meeting_id', $request->id)->get()->toArray();
        }

        return response()->json(['participants' => $participants], 200);

    }

    public function hostChange(Request $request)
    {

        $MeetingID = $request->get('zoom_meeting_id');
        $current_user_id= Auth::user()->id;
        // Participant::where(['meeting_id'=>$request->get('internal_meeting_id'),'user_id'=>$current_user_id])->update(['role'=>0]);
        // Participant::where(['meeting_id'=>$request->get('internal_meeting_id'),'user_id'=>$request->get('id')])->update(['role'=>1]);
        $userData= User::find($request->get('id'));
        $arrData = ['type' => 1, 'schedule_for' =>$userData->email ];
        $jsonData = json_encode($arrData,true);

        $curl = curl_init();
        // $body = array( "response_type" => "code", 'client_id' => '2ZC5XRNLSDycVhKENXmHg',
        // "redirect_uri" => 'http://localhost:8000/meetings');
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://zoom.us/oauth/authorize",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => json_encode($body),
        //     CURLOPT_HTTPHEADER => array(
        //         "Authorization" => "Basic ". base64_encode($this->api_key.':'.$this->api_secret),
        //         "content-type: application/json"
        //     ),
        // ));
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        // dd($response);
        // curl_close($curl);
        // $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.zoom.us/v2/meetings/" . $MeetingID,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_POSTFIELDS => $jsonData,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PATCH",
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer ". base64_encode($this->api_key.':'.$this->api_secret),
            "content-type: application/json"
        ),
        CURLOPT_CAINFO => '../../../cacert.pem',
        CURLOPT_CAPATH => '../../../cacert.pem',
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        echo $response;
        }
    }
}
