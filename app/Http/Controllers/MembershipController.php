<?php

namespace App\Http\Controllers;

use App\Membership;
use App\CustomersToken;
use App\Lib\FirebaseMessage;
use App\Lib\PushMessage;

use DB;

use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function list() {
      // $membership = Membership::where(['status' => 'Accepted'])->get();
      $membership = DB::table('memberships')
                        ->join('customers','memberships.customer_id','=','customers.id')
                        ->select('memberships.*','customers.first_name','customers.last_name')
                        ->where('memberships.status','Accepted')
                        ->get();


      return view('admin.membership.membership_list')->with(compact('membership'));
    }

    public function requestList() {

      $membership = DB::table('memberships')
                        ->join('customers','memberships.customer_id','=','customers.id')
                        ->select('memberships.*','customers.first_name','customers.last_name')
                        ->where('memberships.status','Pending')
                        ->get();





      return view('admin.membership.membership_request')->with(compact('membership'));
    }

    public function accept($id) {
      $membership = Membership::find($id);
      $membership->status = 'Accepted';
      $membership->date_started = date('Y-m-d');
      $membership->date_ended = date('Y-m-d',strtotime('+1 years'));
      $membership->save();

      $customer_token = CustomersToken::where(['customer_id' => $membership->customer_id])->first();

      if(!empty($customer_token)) {
        $pm = new PushMessage();
        $fcm = new FirebaseMessage();

        $pm->setTitle("Your Membership apply has been accepted!");
        $pm->setMessage("Thank you for enjoying your benefits");
        $pm->setId($membership->id);
        $pm->setImage("");
        $pm->setIntent("Membership");

        $jsonMessage = $pm->getPushMessage();
        $response = $fcm->send($customer_token->token_id,$jsonMessage);


      }





      return redirect('/admin/membership/list')->with('flash_message_success','Successfully Updated!');

    }

    public function cancel($id) {
      $membership = Membership::where('id',$id)->update(['status'=>'Cancelled']);
      return redirect()->back()->with('flash_message_success','Successfully Cancelled!');
    }
}
