<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Users;
use Illuminate\Support\Facades\Input;
use Validator;
class apiController extends Controller
{
    /**
     * @api {post} /api/getUsers Get list of all users
     * @apiName getUsers
     * @apiGroup rest-api
     *
     * 
     * @apiSuccess {String} users List of all users
     */
    public function getUsers(Request $request)
    {
        $rules = array(
            'token'            => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $data['msg'] = $validator->messages();
            $data['status'] = 400;
            return response()->json($data);
        }
        $token = $request->input('token');
        if(!$this->checkToken($token)){
            $data['msg'] = 'Invalid token';
            $data['status'] = 400;
            return response()->json($data);
        }
        $users = Users::getUsers();
        if(count($users) > 0){
            $data['users'] = $users;
        }
        else{
            $data['msg'] = 'No users found';
        }
        $data['status'] = 200;
        return response()->json($data);
    }
    /**
     * @api {post} /api/loginUser Add a new user
     * @apiName loginUser
     * @apiGroup rest-api
     * @apiParam {String} email Email of the user
     * @apiParam {String} password Password
     * 
     * @apiSuccess {String} token Token of user to access other apis
     */
    public function loginUser(Request $request){
        $rules = array(
            'email'            => 'required',
            'password'   => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $data['msg'] = $validator->messages();
            $data['status'] = 400;
            return response()->json($data);
        }
        $email = $request->email;
        $password = $request->password;
        $user = Users::where('email', $email)->where('password',md5($password))->get(['token']);
        if($user && count($user) > 0){
            $data['token'] = $user;
            $data['status'] = 200;
        }
        else{
            $data['msg'] = 'Invalid credentials';
            $data['status'] = 400;
        }
        return response()->json($data);
    }
     /**
     * @api {post} /api/checkToken Check if a token is valid
     * @apiName checkToken
     * @apiGroup rest-api
     * @apiParam {String} token Token of the user
     * 
     * 
     */
    public function checkToken($token){
        $user = Users::where('token', $token)->get();
        if($user && count($user) > 0){
            return true;
        }
        return false;
    }
    /**
     * @api {post} /api/getUsers Add a new user
     * @apiName addUser
     * @apiGroup rest-api
     * @apiParam {String} first_name First name of the user
     * @apiParam {String} last_name Last name of the user
     * @apiParam {email} email address of the user 
     * 
     */
    public function addUser(Request $request){
        $rules = array(
            'first_name'            => 'required',
            'last_name'            => 'required',
            'email'           => 'email|max:254',
            'password'   => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $data['msg'] = $validator->messages();
            $data['status'] = 400;
            return response()->json($data);
        }
        $user = Users::where('email', '=', Input::get('email'))->first();
        if ($user === null) {
            $users = new Users();
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $email = $request->email;
            $password = $request->password;
            $token = md5(uniqid(rand(),true));
            $users->first_name = $first_name;
            $users->last_name = $last_name;
            $users->email = $email;
            $users->password = md5($password);
            $users->token = $token;
            $saved = $users->save();
            if($saved){
                $data['msg'] = 'Added User successfully';
                $data['status'] = 200;
            }
            else{
                $data['msg'] = 'Error in adding users';
                $data['status'] = 400;
            }
        }
        else{
            $data['msg'] = 'User already exists';
            $data['status'] = 400;
        }
        return response()->json($data);
        
    }
    /**
     * @api {post} /api/updateUser Update an exisiting user
     * @apiName updateUser
     * @apiGroup rest-api
     * @apiParam {String} first_name First name of the user
     * @apiParam {String} last_name Last name of the user
     * @apiParam {email} email address of the user 
     * @apiParam {token} token of the user
     * 
     */
    public function updateUser(Request $request){
        $rules = array(
            'first_name'            => 'required',
            'last_name'            => 'required',
            'email'           => 'email|max:254',
            'token'            => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $data['msg'] = $validator->messages();
            $data['status'] = 400;
            return response()->json($data);
        }
        $token = $request->input('token');
        if(!$this->checkToken($token)){
            $data['msg'] = 'Invalid token';
            $data['status'] = 400;
            return response()->json($data);
        }
        $user = Users::where('email', '=', Input::get('email'))->first();
        if($user == null){
            $data['msg'] = 'User does not exist';
            $data['status'] = 400;
            return response()->json($data);
        }
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $date = date('Y-m-d H:i:s');
        $update = Users::where('email', $email)->update(array('first_name' => $first_name,'last_name' => $last_name,'updated_at' => $date));
        if($update){
            $data['msg'] = 'Updated User successfully';
            $data['status'] = 200;
        }
        else{
            $data['msg'] = 'Error in updating users';
            $data['status'] = 400;
        }
        return response()->json($data);
    }
    
    /**
     * @api {post} /api/deleteUser Delete a user
     * @apiName deleteUser
     * @apiGroup rest-api
     * @apiParam {email} email address of the user
     * @apiParam {token} token of the user
     * 
     */
    public function deleteUser(Request $request){
        $rules = array(
            'email'           => 'email|max:254',
            'token'            => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $data['msg'] = $validator->messages();
            $data['status'] = 400;
            return response()->json($data);
        }
        $token = $request->input('token');
        if(!$this->checkToken($token)){
            $data['msg'] = 'Invalid token';
            $data['status'] = 400;
            return response()->json($data);
        }
        $user = Users::where('email', '=', Input::get('email'))->first();
        if($user == null){
            $data['msg'] = 'User does not exist';
            $data['status'] = 400;
            return response()->json($data);
        }
        $email = $request->email;
        $update = Users::where('email', $email)->update(array('delete_flag' => 1));
        if($update){
            $data['msg'] = 'Deleted User successfully';
            $data['status'] = 200;
        }
        else{
            $data['msg'] = 'Error in deleting users';
            $data['status'] = 400;
        }
        return response()->json($data);
    }
}
