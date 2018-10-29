<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Helpers;

use App\Membership;

class MembershipController extends Controller
{
    public function status($id) {

      $memberships = Membership::where(['customer_id' => $id])->where('status','<>','Cancelled')->get();
      $count = 0;
      $message = array();
      foreach($memberships as $membership) {
        $count++;
        $message = $membership;

      }

      if($count == 0) {
        $message['status'] = "None";
      }

      return response()->json($message);

    }

    public function detail($id) {

      $dateToday = date('Y-m-d');
      $memberships = Membership::where('customer_id',$id)->where('date_ended','>',$dateToday)->get();
      $message = array();
      $count = 0;

      foreach($memberships as $membership) {
        $count++;
        $message = $membership;

        $started = strtotime(date('Y-m-d'));
        $ended = strtotime($membership->date_ended);

        $days_between = ceil(abs($ended - $started) / 86400);
        $message['remaining_day'] = $days_between . ' days';
        $message['date_started'] = date('F d Y', strtotime($membership->date_started));
        $message['date_ended'] = date('F d Y', strtotime($membership->date_ended));

      }

      $message['count'] = $count;

      return response()->json($message);


    }

    public function set($id) {
      $membership_id = Helpers::generateRandomString(3) . '-' . Helpers::generateRandomString(4);
      $membership = Membership::create(['customer_id' => $id, 'membership_id' => $membership_id]);
      if(!empty($membership)) {
        $message['message'] = "Successfully Apply!";
      }else {
        $message['message'] = 'Error!';
      }

      return response()->json($message);

    }

    public function checkId(Request $request,$customer_id) {
      $data = $request->all();
      $membership = Membership::where(['customer_id' => $customer_id,'membership_id' => $data['membership_id']])->count();
      if($membership > 0) {
        $response['message'] = "Success";
      }else {
        $response['message'] = "Failed";
      }

      return response()->json($response);



    }
}
