<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class AccountController extends Controller
{
    public function verify($token){
      $customer = Customer::where('verification_code',$token)->first();
      $customer->status = 1;
      if($customer->save()) {
        return view('email.email_success')->with(compact('customer'));
      }
    }
}
