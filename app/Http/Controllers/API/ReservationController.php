<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Reservation;
use Helpers;
use App\NotificationAdmin;

class ReservationController extends Controller
{
    // Count Reservation
    public function set(Request $request) {
      $data = $request->all();
      $date = date('m-d-Y',strtotime($data['reservation_date']));
      $reservation_code = $date . '-' . Helpers::generateRandomString(12);
      $reservation = new Reservation;
      $reservation->customer_id = $data['customer_id'];
      $reservation->reservation_code = $reservation_code;
      $reservation->reservation_date = $data['reservation_date'];
      $reservation->reservation_time = $data['reservation_time'];
      $reservation->package = $data['package'];
      $reservation->with_coaches = $data['with_coaches'];
      $reservation->total = $data['total'];
      $reservation->save();

      if(!empty($reservation)) {
        $message['message'] = 'Successfully Reserved!';
        $message['success'] = 1;
        $message['last_id'] = $reservation->id;
        $notification = new NotificationAdmin;
        $notification->notificationable_id = $reservation->id;
        $notification->notificationable_type = "App\Reservation";
        $notification->save();
      }else {
        $message['message'] = 'Error please try again!';
        $message['success'] = 0;
      }

      return response()->json($message);

    }

    public function list($id,$status) {
      $date = date('m/d/Y');
      if($status == "Pending") {
        $reservations = Reservation::where('customer_id',$id)
                                    ->select('*')
                                    ->selectRaw('YEAR(STR_TO_DATE(reservation_date, "%m/%d/%Y")) AS year')
                                  ->where('reservation_date','<=','CURDATE()')
                                    ->where('status','Pending')
                                    ->orderBy('year','ASC')
                                    ->orderBy('reservation_date', 'ASC')
                                    ->get();
        $arr = array();
        foreach($reservations as $reservation) {
          $reservation_date = date('F D d',strtotime($reservation->reservation_date));
          $reservation_year = date('Y', strtotime($reservation->reservation_date));
          $rows['reservation_time'] = $reservation->reservation_time;
          $rows['reservation_date'] = $reservation_date;
          $rows['year'] = $reservation_year;
          $rows['id'] = $reservation->id;
          $rows['status'] = $reservation->status;
          $package = array("25 Arrows","50 Arrows","75 Arrows","120 Arrows","150 Arrows","200 Arrows","240 Arrows","300 Arrows");
          $rows['package'] = $package[$reservation->package - 1];
          $rows['with_coaches'] = $reservation->with_coaches;
          $rows['total'] = $reservation->total;
          array_push($arr,$rows);
        }
        $message['reservationList'] = $arr;
      }else if($status == "Accepted") {
        $reservations = Reservation::where('customer_id',$id)
                                    ->where('reservation_date','>=',$date)
                                    ->where('status','Accepted')
                                    ->select('*')
                                    ->selectRaw('YEAR(STR_TO_DATE(reservation_date, "%m/%d/%Y")) AS year')
                                    ->orderBy('year','ASC')
                                    ->orderBy('reservation_date', 'DESC')
                                    ->get();
        $arr = array();
        foreach($reservations as $reservation) {
          $reservation_date = date('F D d',strtotime($reservation->reservation_date));
          $reservation_year = date('Y', strtotime($reservation->reservation_date));
          $rows['reservation_time'] = $reservation->reservation_time;
          $rows['reservation_date'] = $reservation_date;
          $rows['year'] = $reservation_year;
          $rows['id'] = $reservation->id;
          $rows['status'] = $reservation->status;
          $package = array("25 Arrows","50 Arrows","75 Arrows","120 Arrows","150 Arrows","200 Arrows","240 Arrows","300 Arrows");
          $rows['package'] = $package[$reservation->package - 1];
          $rows['with_coaches'] = $reservation->with_coaches;
          $rows['total'] = $reservation->total;
          array_push($arr,$rows);
        }
        $message['reservationList'] = $arr;

      }else {
        $reservations = Reservation::where(['customer_id' => $id, 'status' => $status])
                                    ->select('*')
                                    ->selectRaw('YEAR(STR_TO_DATE(reservation_date, "%m/%d/%Y")) AS year')
                                    ->orderBy('year','ASC')
                                    ->orderBy('reservation_date', 'ASC')
                                    ->get();
        $arr = array();
        foreach($reservations as $reservation) {
          $reservation_date = date('F D d',strtotime($reservation->reservation_date));
          $reservation_year = date('Y', strtotime($reservation->reservation_date));
          $rows['reservation_time'] = $reservation->reservation_time;
          $rows['reservation_date'] = $reservation_date;
          $rows['year'] = $reservation_year;
          $rows['id'] = $reservation->id;
          $rows['status'] = $reservation->status;
          $package = array("25 Arrows","50 Arrows","75 Arrows","120 Arrows","150 Arrows","200 Arrows","240 Arrows","300 Arrows");
          $rows['package'] = $package[$reservation->package - 1];
          $rows['with_coaches'] = $reservation->with_coaches;
          $rows['total'] = $reservation->total;
          array_push($arr,$rows);
        }
        $message['reservationList'] = $arr;

      }

      return response()->json($message);

    }

    public function detail($id) {
      $reservations = Reservation::where(['id' => $id])->get();
      $arr = array();
      foreach($reservations as $reservation) {
        $reservation_date = date("F D d",strtotime($reservation->reservation_date));
        $reservation_year = date("Y",strtotime($reservation->reservation_date));

        $rows['reservation_time'] = $reservation->reservation_time;
        $rows['reservation_date'] = $reservation_date;
        $rows['year'] = $reservation_year;
        $rows['reservation_code'] = $reservation->reservation_code;
        $rows['id'] = $reservation->id;
        $rows['status'] = $reservation->status;
        $package = array("25 Arrows","50 Arrows","75 Arrows","120 Arrows","150 Arrows","200 Arrows","240 Arrows","300 Arrows");
        $rows['package'] = $package[$reservation->package - 1];
        $rows['with_coaches'] = $reservation->with_coaches;
        $rows['total'] = $reservation->total;
        array_push($arr,$rows);
      }
      $message['reservationList'] = $arr;
      return response()->json($message);
    }

    public function cancel($id) {
      $reservations = Reservation::where('id',$id)->update(['status'=>'Cancelled']);
      $notification = new NotificationAdmin;
      $notification->notificationable_id = $id;
      $notification->notificationable_type = "App\Reservation";
      $notification->save();
      return response()->json(array('message'=>'Success'));
    }

    public function get_available_time(Request $request) {
      $data = $request->all();

      $reservations = Reservation::where(['reservation_date' => $data['reservation_date']])->where('status','<>','Cancelled')->get();
      $rows = array();
      $sucess = 1;
      foreach($reservations as $reservation) {
        if($reservation->status == 'Accepted') {
          $rows[] = $reservation;

        }


        if($reservation->customer_id == $data['customer_id']) {
          $sucess = 0;
        }

      }

      $response['success'] = $sucess;
      $response['reservationList'] = $rows;
      return response()->json($response);

    }

    public function count($id) {

      $date = date('m/d/Y');

      $reservation = Reservation::where('reservation_date','<=',$date)->where('customer_id','=',$id)->count();

      return $reservation;



    }

    public function getTotal($id) {
      $reservation = Reservation::findOrFail($id);
      $total = round($reservation->total);

      echo json_encode(array("total" => $total));


    }

}
