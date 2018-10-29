<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\NotificationCustomer;
use App\NotificationAdmin;
use App\Reservation;
use App\Payment;
use App\Customer;
use Helpers;

class NotificationController extends Controller
{

  // NOTIFICATION FOR CUSTOMERS
  public function count() {
    $count = NotificationCustomer::where(['status'=>'Unread'])->count();

    return response()->json(array('count' => $count));
  }

  public function notification_count($id) {
    $count = NotificationCustomer::where(['status'=> 'Unread','customer_id' => $id])->count();
    return response()->json(array('count' => $count));
  }


  public function list($id) {

    $notification = NotificationCustomer::where(['customer_id' => $id])->with('notificationable')->orderBy('id','DESC')->limit(20)->get();

    $arr = array();
    foreach($notification as $data)
    {


      // echo $data->notificationable_type;
      if($data->notificationable_type == "App\Reservation") {
        if($data->notificationable->status == "Accepted") {
          $rows['message'] = "Your reservation has been accepted. Reservation Detail : Date ".$data->notificationable->reservation_date . " Time : " . $data->notificationable->reservation_time . " Code : ". $data->notificationable->reservation_code;
          $rows['id'] = $data->notificationable->id;
          $rows['notificationable_type'] = "Reservation";
          $rows['time'] = Helpers::time_elapsed_string($data->notificationable->created_at);
          $rows['status'] = $data->notificationable->status;
        }else {
          $rows['message'] = "Your reservation has been cancel";
          $rows['id'] = $data->notificationable->id;
          $rows['notificationable_type'] = "Reservation";
          $rows['time'] = Helpers::time_elapsed_string($data->notificationable->created_at);
          $rows['status'] = $data->notificationable->status;
        }
      }

      if($data->notificationable_type == "App\Payment") {
        $rows['message'] = "Your payment is not valid";
        $rows['id'] = $data->notificationable->id;
        $rows['notificationable_type'] = "Payment";
        $rows['time'] = Helpers::time_elapsed_string($data->notificationable->created_at);
      }
      // echo $data->notificationable;
      // echo $data->notificationable;

          array_push($arr,$rows);
    }

    $message['notificationList'] = $arr;

    return response()->json($message);

  }


  // NOTIFICATION FOR ADIN


  public function admin_count() {
    $count = NotificationAdmin::where('status','Unread')->count();

    return response()->json(array('count'=>$count));
  }
  public function admin_list() {

        $notification = NotificationAdmin::with('notificationable')->orderBy('id','DESC')->limit(5)->get();

        $arr = array();
        foreach($notification as $data)
        {
          // echo $data->notificationable_type;
          if($data->notificationable_type == "App\Reservation") {
            if($data->notificationable->status == "Pending") {
              $rows['message'] = "New Reservation has been request with Reservation Date: ".$data->notificationable->reservation_date." and Reservation time : ".$data->notificationable->reservation_date;
              $rows['id'] = $data->notificationable->id;
              $rows['notificationable_type'] = "Reservation";
              $rows['time'] = Helpers::time_elapsed_string($data->notificationable->created_at);
            }else {
              $rows['message'] = "Reservaton cancelled with Reservation Code:".$data->notificationable->reservation_code;
              $rows['id'] = $data->notificationable->id;
              $rows['notificationable_type'] = "Reservation";
              $rows['time'] = Helpers::time_elapsed_string($data->notificationable->created_at);
            }
          }

          if($data->notificationable_type == "App\Payment") {
            $customers = Payment::where(['payments.id' => $data->notificationable->id])
                                  ->join('reservations','payments.reservation_id','=','reservations.id')
                                  ->join('customers','reservations.customer_id','=','customers.id')
                                  ->select('customers.first_name','customers.last_name')
                                  ->first();

            $rows['message'] = "You have new payment from ".$customers->first_name . " " . $customers->last_name;
            $rows['id'] = $data->notificationable->id;
            $rows['notificationable_type'] = "Payment";
            $rows['time'] = Helpers::time_elapsed_string($data->notificationable->created_at);

            // $rows['customer_name'] = $customers->first_name . " " . $customers->last_name;
          }
          $rows['status'] = $data->status;
          // echo $data->notificationable;
          // echo $data->notificationable;


              array_push($arr,$rows);
        }

        $message['notificationList'] = $arr;

        return response()->json($message);

  }

  public function admin_view_all() {
       $notification = NotificationAdmin::with('notificationable')->orderBy('id','DESC')->paginate(5);

        $arr = array();

        foreach($notification as $data)
        {
          // echo $data->notificationable_type;
          if($data->notificationable_type == "App\Reservation") {
            if($data->notificationable->status == "Pending") {
              $rows['message'] = "New Reservation has been request with Reservation Date: ".$data->notificationable->reservation_date." and Reservation time : ".$data->notificationable->reservation_date;
              $rows['id'] = $data->notificationable->id;
              $rows['notificationable_type'] = "Reservation";
              $rows['time'] = Helpers::time_elapsed_string($data->notificationable->created_at);
            }else {
              $rows['message'] = "Reservaton cancelled with Reservation Code:".$data->notificationable->reservation_code;
              $rows['id'] = $data->notificationable->id;
              $rows['notificationable_type'] = "Reservation";
              $rows['time'] = Helpers::time_elapsed_string($data->notificationable->created_at);
            }
          }

          if($data->notificationable_type == "App\Payment") {
            $customers = Payment::where(['payments.id' => $data->notificationable->id])
                                  ->join('reservations','payments.reservation_id','=','reservations.id')
                                  ->join('customers','reservations.customer_id','=','customers.id')
                                  ->select('customers.first_name','customers.last_name')
                                  ->first();

            $rows['message'] = "You have new payment from ".$customers->first_name . " " . $customers->last_name;
            $rows['id'] = $data->notificationable->id;
            $rows['notificationable_type'] = "Payment";
            $rows['time'] = Helpers::time_elapsed_string($data->notificationable->created_at);

            // $rows['customer_name'] = $customers->first_name . " " . $customers->last_name;
          }
          $rows['status'] = $data->status;
          // echo $data->notificationable;
          // echo $data->notificationable;


              array_push($arr,$rows);
        }


        $message[] = $arr;



        // echo json_encode($message);die;




        return view('admin.notification.notification_view_all')->with(compact('message','notification'));

  }


}
