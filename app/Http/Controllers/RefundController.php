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


class RefundController extends Controller
{
    public function refund_list() {

      $reservations = Reservation::with('payment')
                      ->join('customers','reservations.customer_id','=','customers.id')
                      ->select('reservations.*','customers.first_name','customers.last_name')
                      ->where('reservations.status','Cancelled')
                      ->orderBy('reservation_date','DESC')
                      ->get();

    // foreach($reservations as $data) {
    //   if($data->payment['is_valid'] == 'Valid') {
    //     echo $data;
    //   }
    // }

    // echo json_encode($reservations);

      return view('admin.refund.refund_list')->with(compact('reservations'));
    }
}
