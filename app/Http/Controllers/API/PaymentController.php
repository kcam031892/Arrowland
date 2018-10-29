<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Image;
use Helpers;
use App\Payment;
use App\NotificationAdmin;
use Stripe;
use App\Reservation;

class PaymentController extends Controller
{
    public function checkPaid($reservation_id){

      $count = Payment::where(function($payment){
        $payment->where('is_valid','<>','Not Valid')
                ->orWhereNull('is_valid');

      })
                          ->where('reservation_id',$reservation_id)
                          ->count();


      $payment = Payment::where(['reservation_id' => $reservation_id])->first();
      if($count > 0) {

        $message['success'] = 1;
        $message['id'] = $payment->id;
      }else {
        $message['success'] = 0;
        $message['id'] = 0;
      }

      return response()->json($message);


    }

    public function insertPayment(Request $request,$reservation_id) {

      $data = $request->all();

      $payment = new Payment;
      $payment->reservation_id = $reservation_id;
      $payment->sender_name = $_POST['sender_name'];
      $payment->transaction_code = $_POST['reference_number'];

      $payment->amount_pay = $_POST['amount'];
      $payment->payment_method = $_POST['payment_method'];
      Reservation::where('id',$reservation_id)->update(['member_status' => $data['member_status']]);

      $filename = Helpers::generateRandomString(10) . "-" . Helpers::generateRandomString(10). '.jpg';
      $path = 'images/backend/receipt/' . $filename;
      if(file_put_contents($path,base64_decode($data['file']))) {

        $payment->image_path = $filename;
        $payment->save();
        $notification = new NotificationAdmin;
        $notification->notificationable_id = $payment->id;
        $notification->notificationable_type = "App\Payment";
        $notification->save();
        $message['message'] = "Success";
      }else {
        $message['message'] = "Failed";
      }


        return response()->json($message);

    }

    public function paymentDetail($id) {
      $payment = Payment::where(['id' => $id])->first();

      return response()->json($payment);
    }

    public function insertPaymentCC(Request $request,$reservation_id) {

      $reservation = Reservation::with('customer')->where('id',$reservation_id)->first();

      $data = $request->all();

      $email =  $reservation->customer->email;
      // $name = $re
      if($data['member_status'] == "Member") {
        $total = (round($reservation->total) -  round($reservation->total * .10))  . "00";
        $totalDb = round($reservation->total) -  round($reservation->total * .10);
      }else {
        $total = round($reservation->total) . "00";
        $totalDb = round($reservation->total);

      }


      \Stripe\Stripe::setApiKey("sk_test_eCgM8wWWr7BEFasBfvQYZmqt");
      $token = $data['stripeToken'];

      $customer = \Stripe\Customer::create([
        'email' => $email,
        'source' => $token,
      ]);

      $charge = \Stripe\Charge::create([
        'amount' => $total,
        'currency' => 'php',
        'customer' => $customer->id,
      ]);

      $payment = new Payment;
      $payment->reservation_id = $reservation_id;
      $payment->sender_name = $reservation->customer->first_name . " " . $reservation->customer->last_name;
      $payment->transaction_code = $customer->id;

      $payment->amount_pay = $totalDb;
      $payment->payment_method = "Credit Card";
      $payment->image_path = "cc.png";
      $payment->is_valid = "Valid";
      $payment->save();

      Reservation::where('id',$reservation_id)->update(['member_status' => $data['member_status']]);

      $notification = new NotificationAdmin;
      $notification->notificationable_id = $payment->id;
      $notification->notificationable_type = "App\Payment";
      $notification->save();

      echo json_encode(array("message" => "sucess"));



    }

    public function insertPaymentPaypal(Request $request,$reservation_id) {

      $reservation = Reservation::with('customer')->where('id',$reservation_id)->first();

      $data = $request->all();


      $payment = new Payment;
      $payment->reservation_id = $reservation_id;
      $payment->sender_name = $reservation->customer->first_name . " " . $reservation->customer->last_name;
      $payment->transaction_code = $data['transaction_code'];

      if($data['member_status'] == "Member") {
        $total = (round($reservation->total) * .10);
      }else {
        $total = round($reservation->total);
      }

      $payment->amount_pay = $total;
      $payment->payment_method = "Paypal";
      $payment->image_path = "paypal.png";
      $payment->is_valid = "Valid";
      $payment->save();

      Reservation::where('id',$reservation_id)->update(['member_status' => $data['member_status']]);

      $notification = new NotificationAdmin;
      $notification->notificationable_id = $payment->id;
      $notification->notificationable_type = "App\Payment";
      $notification->save();

      echo json_encode(array("message" => "sucess"));



    }
}
