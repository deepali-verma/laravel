<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Aloha\Twilio\Twilio;
use Validator;
class MsgCallController extends Controller
{
    /**
     * @api {post} /api/sendSms Send SMS
     * @apiName sendSms
     * @apiGroup Twilio
     *
     * @apiParam {Number} phone_no Phone number where message is to be sent
     * @apiParam {String} msg Text message to be sent
     * @apiSuccess {msg} msg Success message
     */
    public function sendMsg(Request $request)
    {
        $rules = array(
            'phone_no'         => 'numeric|required',
            'msg'   => 'required'
        );
        //Validate user input
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $data['msg'] = $validator->messages();
            $data['status'] = 400;
            return response()->json($data);
        }
        $phone_no = $request->input('phone_no');
        //Limited numbers allowed in trial app.Edit the following code when twilio account is upgraded
        $phone_no = '+91'.$phone_no;
        $msg = $request->input('msg');
        //Get Account SID,Token and From number from env file
        $accountId = getenv('TWILIO_SID');
        $token = getenv('TWILIO_TOKEN');
        $fromNumber = getenv('TWILIO_FROM');
        try{
            $twilio = new \Aloha\Twilio\Twilio($accountId, $token, $fromNumber); //Create new twilio instance
            $twilio->message($phone_no, $msg); //Send message
        } catch(\Services_Twilio_RestException $e ){ //Check for errors
            $data['status'] = 400;
            $data['msg'] = $e->getMessage();
            return response()->json($data);
        }
        $data['status'] = 200;
        $data['msg'] = 'success';
        return response()->json($data);
    }
    /**
     * @api {post} /api/makeCall Make phone call
     * @apiName makeCall
     * @apiGroup Twilio
     *
     * @apiParam {Number} phone_no Phone number where message is to be sent
     * @apiSuccess {msg} msg Success message
     */
    public function makeCall(Request $request)
    {
        $rules = array(
            'phone_no'         => 'numeric|required'
        );
        //Validate user input
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $data['msg'] = $validator->messages();
            $data['status'] = 400;
            return response()->json($data);
        }
        $phone_no = $request->input('phone_no');
        //Limited numbers allowed in trial app.Edit the following code when twilio account is upgraded
        $phone_no = '+91'.$phone_no;
        //Get Account SID,Token and From number from env file
        $accountId = getenv('TWILIO_SID');
        $token = getenv('TWILIO_TOKEN');
        $fromNumber = getenv('TWILIO_FROM');
        try{
        $twilio = new \Aloha\Twilio\Twilio($accountId, $token, $fromNumber); //Create new twilio instance
        $url = "https://demo.twilio.com/docs/voice.xml"; //Set the URL Twilio will request when the call is answered.
        $twilio->call($phone_no, $url); //Make call
        } catch(\Services_Twilio_RestException $e ){//Check for errors
            $data['status'] = 400;
            $data['msg'] = $e->getMessage();
            return response()->json($data);
        }
        $data['status'] = 200;
        $data['msg'] = 'success';
        return response()->json($data);
    }
}
