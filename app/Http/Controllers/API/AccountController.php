<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Customer;
use Auth;
use Validator;
use Helpers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;

class AccountController extends BaseController
{


  public function register(Request $request) {
    $data = $request->all();


    $validator = Validator::make($data,[
      'username' => 'required|unique:customers',
      'email' => 'required|email|unique:customers'

    ]);

    if($validator->fails()) {
      $message['message'] = '';
      foreach($validator->errors()->all() as $errors) {
        $message['message'] = $errors;
      }
      $message['success'] = 0;
    }else {

      $customer = new Customer;
      $customer->username = $data['username'];
      $customer->password = bcrypt($data['password']);
      // $customer->password = md5($data['password']);
      $customer->email = $data['email'];
      $customer->first_name = $data['first_name'];
      $customer->middle_name = $data['middle_name'];
      $customer->last_name = $data['last_name'];
      $customer->address = $data['address'];
      $customer->contact_number = $data['contact_number'];
      $customer->gender = $data['gender'];
      $customer->birthday = date('Y-m-d',strtotime($data['birthday']));
      $customer->verification_code = Helpers::generateRandomString(30);
      $customer->save();

      $message['message'] = 'Successfully Registered!';
      $message['success'] = 1;
      Mail::to($customer->email)->send(new EmailVerification($customer));

      }

      return response()->json($message);




  }

  public function login(Request $request) {
    $data = $request->all();

    $username = $data['username'];
    $password = bcrypt($data['password']);;
    // $password = md5($data['password']);

    $customer = Customer::where(['username' => $username])->first();

    if(!empty($customer)) {


      if(Hash::check($data['password'],$customer->password)) {
        if($customer->status == 0) {
          $message['success'] = 0;
          $message['message'] = 'Account is not yet validated!';

        }else {
          $message['success'] = 1;
          $message['userData'] = $customer;

        }

      }else {
        $message['success'] = 2;
        $message['message'] = 'Invalid Password';
      }

    }else {
      $message['success'] = 3;
      $message['message'] = 'No username found!';
    }

    return response()->json($message);



  }



}
