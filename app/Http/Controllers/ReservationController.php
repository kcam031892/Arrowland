<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reservation;
use App\CustomersToken;
use App\Payment;
use DB;
use App\Lib\FirebaseMessage;
use App\Lib\PushMessage;
use App\NotificationAdmin;
use App\NotificationCustomer;

class ReservationController extends Controller
{
    //

    public function list($status) {

      $reservations = Reservation::with('paymentIsNotValid')
                      ->join('customers','reservations.customer_id','=','customers.id')
                      ->select('reservations.*','customers.first_name','customers.last_name')
                      ->where('reservation_date','<=','CURDATE()')
                      ->where('reservations.status',$status)
                      ->orderBy('reservation_date','DESC')
                      ->get();



      return view('admin.reservation.reservation_list')->with(compact('reservations','status'));

    }

    public function detail($id) {
      //
      // $reservations = DB::table('reservations')
      //                 ->join('customers','reservations.customer_id','=','customers.id')
      //                 ->where('reservations.id',$id)
      //                 ->select('reservations.status as res_status','reservations.*','customers.*')
      //                 ->first();

      $reservations = Reservation::join('customers','reservations.customer_id','=','customers.id')
                                  ->where('reservations.id',$id)
                                  ->select('reservations.status as res_status','reservations.*','customers.*')
                                  ->firstOrFail();

      NotificationAdmin::where(['notificationable_id' => $id,'notificationable_type' => 'App\Reservation'])->update(['status'=>'Read']);


      // echo "<pre>"; print_r($reservations);die;

      return view('admin.reservation.reservation_detail')->with(compact('reservations'));
    }

    public function acceptPendingRequest($id,$payment_id) {
      // $reservations = Reservation::where(['id' => $id])->update(['status' => 'Pending']);
      $reservations = Reservation::find($id);
      $reservations->status = "Accepted";
      $reservations->save();

      $customer_token = CustomersToken::where(['customer_id' => $reservations->customer_id])->first();

      if(!empty($customer_token)) {
        $pm = new PushMessage();
        $fcm = new FirebaseMessage();

        $pm->setTitle("Your reservation has been accepted!");
        $pm->setMessage("Reservation schedule : Date:".$reservations->reservation_date.", Time: ".$reservations->reservation_time." ");
        $pm->setId($reservations->id);
        $pm->setImage("");
        $pm->setIntent("Reservation");

        $jsonMessage = $pm->getPushMessage();
        $response = $fcm->send($customer_token->token_id,$jsonMessage);

      }
      // Payment::find($id)->delete();
      $notification = new NotificationCustomer;
      $notification->customer_id = $reservations->customer_id;
      $notification->notificationable_id = $id;
      $notification->notificationable_type = "App\Reservation";
      $notification->save();

      Payment::where('id',$payment_id)->update(['is_valid'=>'Valid']);

      return redirect('/admin/range-rental/pending/list')->with('flash_message_success','Reservation successfully updated!');

    }

    public function cancelReservation($id) {
      // $reservations = Reservation::where(['id' => $id])->update(['status' => 'Pending']);
      $reservations = Reservation::find($id);
      $reservations->status = "Cancelled";
      $reservations->save();

      $customer_token = CustomersToken::where(['customer_id' => $reservations->customer_id])->first();

      if(!empty($customer_token)) {
        $pm = new PushMessage();
        $fcm = new FirebaseMessage();

        $pm->setTitle("Your reservation has been cancelled");
        $pm->setMessage("Reservation schedule : Date:".$reservations->reservation_date.", Time: ".$reservations->reservation_time." ");
        $pm->setId($reservations->id);
        $pm->setImage("");
        $pm->setIntent("Reservation");

        $jsonMessage = $pm->getPushMessage();
        $response = $fcm->send($customer_token->token_id,$jsonMessage);

      }

      return redirect('/admin/range-rental/pending/list')->with('flash_message_success','Reservation successfully updated!');

    }

    public function completeReservation($id) {
      $reservations = Reservation::find($id);
      $reservations->status = "Completed";
      $reservations->save();

      $customer_token = CustomersToken::where(['customer_id' => $reservations->customer_id])->first();

      if(!empty($customer_token)) {
        $pm = new PushMessage();
        $fcm = new FirebaseMessage();

        $pm->setTitle("Your reservation has been completed!");
        $pm->setMessage("Reservation schedule : Date:".$reservations->reservation_date.", Time: ".$reservations->reservation_time." ");
        $pm->setId($reservations->id);
        $pm->setImage("");
        $pm->setIntent("Reservation");

        $jsonMessage = $pm->getPushMessage();
        $response = $fcm->send($customer_token->token_id,$jsonMessage);

      }

      return redirect('/admin/range-rental/accepted/list')->with('flash_message_success','Reservation successfully updated!');

    }





}
