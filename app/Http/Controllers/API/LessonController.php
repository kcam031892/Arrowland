<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Lesson;
use App\LessonSession;

class LessonController extends Controller
{
    public function set(Request $request, $id) {
      $data = $request->all();

      // $lesson = Lesson::create(['customer_id' => $id,'member_status' => $data['member_status']]);
      $lesson = new Lesson;
      $lesson->customer_id = $id;
      $lesson->member_status = $data['member_status'];
      $lesson->save();

      if(!empty($lesson)) {
        $message['message'] = "Successfully Apply";
      }else {
        $message['message'] = "Error";
      }


      return response()->json($message);

    }

    public function lesson_status($id) {

      $lesson = Lesson::where('customer_id',$id)->where('status','<>','Cancelled')->get();
      $arr = array();
      $count = 0;






      foreach($lesson as $data) {
        $count++;
        $lesson_session = LessonSession::where('lesson_id',$data->id)->get();
        $completed_count = 0;
        $pending_count = 0;
        $accepted_count = 0;
        $accepted_message = "";

        foreach($lesson_session as $nData) {
          if($nData->status == 'Pending') {
            $pending_count++;
          }else if($nData->status == 'Completed') {
            $completed_count++;
          }else {
            $accepted_count++;
            $accepted_message = "You have upcoming session on ".date("F d Y",strtotime($nData->session_date))." at " .$nData->session_time;

          }
        }

        $data['session_count'] = $completed_count;
        $data['accepted_count'] = $accepted_count;
        $data['pending_count'] = $pending_count;
        $data['accepted_message'] = $accepted_message;

        $rows = $data;
      }
      if($count == 0) {
        $rows['status'] = "None";
      }

      return response()->json($rows);


    }

    public function lesson_set_schedule(Request $request,$id) {
      $data = $request->all();
      $lesson_session = new LessonSession;
      $lesson_session->lesson_id = $id;
      $lesson_session->session_date = $data['schedule_date'];
      $lesson_session->session_time = $data['schedule_time'];
      $lesson_session->save();

      $message['count'] = 1;
      return response()->json($message);


    }

    public function lesson_schedule_available_date(Request $request,$id) {
      $data = $request->all();
      $lessons_schedule = LessonSession::where('lesson_id',$id)->where('session_date',$data['schedule_date'])->where('status','<>','Completed')->count();
      $message['count'] = $lessons_schedule;


      echo json_encode($message);

    }
}
