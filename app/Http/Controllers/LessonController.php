<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Lesson;
use App\LessonSession;
use App\CustomersToken;
use App\Lib\FirebaseMessage;
use App\Lib\PushMessage;

class LessonController extends Controller
{
    //
    public function list() {
      $lesson = Lesson::join('customers','lessons.customer_id','=','customers.id')
                        ->where('lessons.status','Accepted')
                        ->select('lessons.*','customers.first_name','customers.last_name')

                        ->get();

      return view('admin.lesson.lesson_list')->with(compact('lesson'));
    }

    public function requestList() {
      $lesson = Lesson::join('customers','lessons.customer_id','=','customers.id')
                        ->where('lessons.status','Pending')
                        ->select('lessons.*','customers.first_name','customers.last_name')

                        ->get();

      return view('admin.lesson.lesson_request')->with(compact('lesson'));

    }

    public function accept($id) {
      $lesson = Lesson::find($id);
      $lesson->status = 'Accepted';
      $lesson->enrolled_date = date('Y-m-d');
      $lesson->save();

      $customer_token = CustomersToken::where(['customer_id' => $lesson->customer_id])->first();

      if(!empty($customer_token)) {
        $pm = new PushMessage();
        $fcm = new FirebaseMessage();

        $pm->setTitle("Your lesson apply has been accepted!");
        $pm->setMessage("Thank you for enjoying you can now schedule your session");
        $pm->setId($lesson->id);
        $pm->setImage("");
        $pm->setIntent("Lesson");

        $jsonMessage = $pm->getPushMessage();
        $response = $fcm->send($customer_token->token_id,$jsonMessage);


      }

      return redirect('/admin/lesson/list')->with('flash_message_success','Successfully Updated!');
    }

    public function cancel($id) {
      $lesson = Lesson::where('id',$id)->update(['status' => 'Cancelled']);
      return redirect()->back()->with('flash_message_success','Successfully Cancelled!');
    }

    public function schedule_request() {
      $lesson_session = LessonSession::join('lessons','lesson_sessions.lesson_id','=','lessons.id')
                                      ->join('customers','lessons.customer_id','=','customers.id')
                                      ->where('lesson_sessions.status','Pending')
                                      ->select('*','lesson_sessions.id as id')
                                      ->get();

      return view('admin.lesson.lesson_schedule_request')->with(compact('lesson_session'));

    }

    public function schedule_request_accepted() {
      $lesson_session = LessonSession::join('lessons','lesson_sessions.lesson_id','=','lessons.id')
                                      ->join('customers','lessons.customer_id','=','customers.id')
                                      ->where('lesson_sessions.status','Accepted')
                                      ->select('*','lesson_sessions.id as id')
                                      ->get();

      return view('admin.lesson.lesson_schedule_request_accepted')->with(compact('lesson_session'));

    }

    public function schedule_accept($id) {
      $lesson_session = LessonSession::find($id);
      $lesson_session->status = "Accepted";
      $lesson_session->save();

      return redirect('/admin/lesson/schedule-request/accepted')->with('flash_message_success','Successfully Updated');
    }
    public function schedule_complete($id) {
      $lesson_session = LessonSession::find($id);
      $lesson_session->status = "Completed";
      $lesson_session->save();

      return redirect('/admin/lesson/schedule-request/accepted')->with('flash_message_success','Successfully Updated');
    }
}
