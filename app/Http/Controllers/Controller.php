<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Reservation;
use App\Membership;
use App\Lesson;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function rangeRentalCount($status) {

      $count = Reservation::join('customers','reservations.customer_id','=','customers.id')
                            ->where(['reservations.status' => $status])
                            ->where('reservation_date','>',date('m/d/Y'))
                            ->count();
      return $count;


    }

    public static function rangeRentalTotalCount() {
      $count = Reservation::where('reservation_date','>',date('m/d/Y'))->count();
      return $count;
    }

    public static function countMembersRequest() {
      $count = Membership::where(['status' => 'Pending'])->count();
      return $count;
    }
    public static function countTotalMembers() {
      $count = Membership::where(['status' => 'Accepted'])->count();
      return $count;
    }
    public static function countLessonRequest() {
      $count = Lesson::where(['status' => 'Pending'])->count();
      return $count;
    }
    public static function countLessonEnrolled() {
      $count = Lesson::where(['status' => 'Accepted'])->count();
      return $count;
    }

}
