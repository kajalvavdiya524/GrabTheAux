<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Utilties;
use App\User;
use Illuminate\Http\Request;
use App\Meeting;
use App\Participant;
use Auth;

class MeetingUtils extends BaseUtility {
    public function getMeetingsList($dataTable){
        return $dataTable->render('meetings.index');
    }

    public function createMeeting($request){
        $data['meeting_id']     = $request->meeting_id;
        $data['passcode']       = $request->passcode;
        $data['leaveURL']       = config('app.leaveURL');
        $meeting      = Meeting::where('id',$request->internal_meeting_id)->first();
        $data['role']           = auth()->user()->id == $meeting->user_id ? 1 : 0;
        $data['userEmail']      = auth()->user()->email;
        $data['username']      = auth()->user()->first_name;
        $data['internal_meeting_id']      = $request->internal_meeting_id;
        $this->saveParticipant($meeting,$data['role']);

        return view('meetings.meeting', $data);
    }

    public function checkMeeting($request){

//        $meeting = auth()->user()->meetings()->first();
//        if(!$meeting){
            $meeting = new Meeting();
            $meeting->meeting_id = "4146784515";
            $meeting->passcode = "D7gQ7d";
            $meeting->user_id = auth()->user()->id;
            $meeting->save();
           // return redirect()->route('zoomRedirect');
            $data['meeting_id']     = $meeting->meeting_id;
            $data['passcode']       = $meeting->passcode;
            $data['internal_meeting_id']       = $meeting->id;
            return redirect()->route('createZoom',$data);
//        }
//        else
//        {
//            $data['meeting_id']     = $meeting->meeting_id;
//            $data['passcode']       = $meeting->passcode;
//            $data['internal_meeting_id']       = $meeting->id;
          //  return redirect()->route('createZoom',$data);
      //  }
    }

    public function generateMeetingViaZoom($request){

        $curl = curl_init();
        $body = array('topic' => $request->topic, 'password' => $request->password);
//        $body['settings']['join_before_host'] = true;
     //   $body['settings']['use_pmi'] = true;
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/users/me/meetings",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer ".$request->token,
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new \Exception('Curl Error' . $err);
        } else {
          $response =    json_decode($response);
            $data['meeting_id']     = $response->id;
            $data['passcode']       = $response->password;

            $meeting = new Meeting();
            $meeting->meeting_id = $response->id;
            $meeting->passcode = $response->password;
            $meeting->save();
            $data['internal_meeting_id']       = $meeting->id;

            return redirect()->route('createZoom',$data);

        }
    }

    public function deleteMeeting($id){
        $meeting = $this->meetingModal()->where('id', $id)->first();
        $meeting->delete();

        return redirect()->back()->with('success' , 'Meeting Deleted Successfully');

    }

    public function saveMeetingData(Request $request){
        //check weather user is participant or host and based on that add the entry
        // entry should be in participants
        //remove groupID frome everywhere


            if($request->role == 1)
            {
                $meeting = new Meeting;
                $meeting->user_id = Auth::id();
                $meeting->meeting_id = $request->meeting_id;
                $meeting->passcode = $request->passcode;
                $meeting->save();

                $participant = new Participant;
                $participant->user_id = Auth::user()->id;
                $participant->meeting_id = $meeting->id;
                $participant->role = $request->role;
                $participant->save();

                return $meeting->id;
            }
            else
            {
                $participant = new Participant;
                $participant->user_id = Auth::user()->id;
                $participant->meeting_id = Meeting::find($request->internal_meeting_id)->id;
                $participant->role = $request->role;
                $participant->save();

                return $participant->meeting_id;
            }

    }

    function saveParticipant($meeting,$role){
        $user_id = Auth::user()->id;
        $meeting_id = $meeting->id;
        $participant = Participant::firstOrCreate(['meeting_id' => $meeting_id,'user_id' => $user_id],['role' => $role]);


    }

}
