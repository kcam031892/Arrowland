<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Payment;
use App\NotificationAdmin;
use App\NotificationCustomer;
use App\Reservation;
use App\CustomersToken;

use App\Lib\FirebaseMessage;
use App\Lib\PushMessage;

class PaymentController extends Controller
{
    public function detail($id) {

      $payment = Payment::where(['id' => $id])->first();

      NotificationAdmin::where(['notificationable_id' => $id,'notificationable_type' => 'App\Payment'])->update(['status'=>'Read']);

      return view('admin.payment.payment_detail')->with(compact('payment'));
    }

    public function delete($id) {

      $reservation = Payment::where('id',$id)->with('reservation')->first();
      $customer_token = CustomersToken::where(['customer_id' => $reservation->reservation->customer_id])->first();

      $notification = new NotificationCustomer;
      $notification->customer_id = $reservation->reservation->customer_id;
      $notification->notificationable_id = $id;
      $notification->notificationable_type = "App\Payment";
      $notification->save();

      if(!empty($customer_token)) {
      $pm = new PushMessage();
      $fcm = new FirebaseMessage();
      $pm->setTitle("Your payment has been deleted because its invalid!");
      $pm->setMessage("Payment Detail: Reference Number / Control Number : ".$reservation->transaction_code);
      $pm->setId($id);
      $pm->setImage("");
      $pm->setIntent("Payment");

      $jsonMessage = $pm->getPushMessage();
      $response = $fcm->send($customer_token->token_id,$jsonMessage);
      }


      NotificationAdmin::where(['notificationable_id' => $id,'notificationable_type' => 'App\Payment'])->delete();
      Payment::where('id',$id)->update(['is_valid' => 'Not Valid']);
      return redirect('/admin/range-rental/pending/list')->with('flash_message_success','Payment Successfully Deleted!');
    }
}
