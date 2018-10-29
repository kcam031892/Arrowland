<?php

use Illuminate\Http\Request;

use Helpers as Helpers;
use App\Lesson;
use App\Membership;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'cors'], function(){

  // ACCOUNT
  Route::post('account/register','API\AccountController@register');
  Route::post('/account/login','API\AccountController@login');

  // RESERVATION
  Route::get('/reservation/count/{id}', 'API\ReservationController@count');
  Route::post('/reservation/get_time', 'API\ReservationController@get_available_time');
  Route::post('/reservation/set', 'API\ReservationController@set');
  Route::get('/reservation/list/{id}/{status}', 'API\ReservationController@list');
  Route::get('/reservation/detail/{id}', 'API\ReservationController@detail');
  Route::get('/reservation/cancel/{id}','API\ReservationController@cancel');
  Route::get('/reservation/total/{id}', 'API\ReservationController@getTotal');

  // MEMBERSHIP
  Route::get('/membership/status/{id}','Api\MembershipController@status');
  Route::get('/membership/detail/{id}', 'Api\MembershipController@detail');
  Route::get('/membership/set/{id}', 'Api\MembershipController@set');
  Route::post('/membership/check_id/{customer_id}','Api\MembershipController@checkId');

  // LESSON

  Route::post('/lesson/set/{id}', 'API\LessonController@set');
  Route::get('/lesson/status/{id}', 'API\LessonController@lesson_status');
  Route::post('/lesson/{id}/set_schedule','API\LessonController@lesson_set_schedule');
  Route::post('/lesson/get_time/{id}','API\LessonController@lesson_schedule_available_date');

  // PAYMENT
  Route::get('/payment/check_paid/{reservation_id}','Api\PaymentController@checkPaid');
  Route::post('/payment/set/{reservation_id}','Api\PaymentController@insertPayment');
  Route::get('/payment/{id}/detail','API\PaymentController@paymentDetail');
  Route::post('/payment/set/cc/{reservation_id}','API\PaymentController@insertPaymentCC');
  Route::post('/payment/set/paypal/{reservation_id}','API\PaymentController@insertPaymentPaypal');

  Route::post('/enroll-membership/{id}', function(Request $request, $id){
    $data = $request->all();

    $lesson = new Lesson;
    $lesson->customer_id = $id;
    $lesson->member_status = $data['member_status'];
    $lesson->save();

    $membership_id = $id . '-' . Helpers::generateRandomString(12);
    $membership = Membership::create(['customer_id' => $id, 'membership_id' => $membership_id]);

    if(!empty($lesson) && !empty($membership)) {
      $message['message'] = "Successfully Apply!";
    }else {
      $message['message'] = 'Error!';
    }
    return response()->json($message);

  });

  Route::get('/enroll-membership-status/{id}', function($id) {
    $memberships = Membership::where(['customer_id' => $id])->where('status','<>','Cancelled')->count();
    $lesson = Lesson::where('customer_id',$id)->where('status','<>','Cancelled')->count();

    $count = $memberships + $lesson;
    if($count == 2) {
      $message['status'] = "Success";
    }else {
      $message['status'] = "Failed";
    }

    return response()->json($message);




  });

  // GALLERY

  Route::get('/gallery', function(){

    $gallery = App\Gallery::all();
    // $message['galleryList'] = $gallery;
    $rows = array();
    foreach($gallery as $data) {
      $res['img_url'] =  Helpers::galleryImagePath(). $data->image_url;
      $res['img_name'] = $data->image_name;
      array_push($rows,$res);
    }
    $message['galleryList'] = $rows;

    return response()->json($message);

  });

  // NEWS
  Route::post('/news/add', 'API\NewsController@add')->name('api.news_add');


  // FIREBASE
  Route::post('/firebase/token', function(Request $request){

    $data = $request->all();
    $token = App\CustomersToken::where(['customer_id' => $data['id']])->count();

    if($token <= 0) {
      App\CustomersToken::create(['customer_id' => $data['id'], 'token_id' => $data['token']]);
      $message['success'] = 1;


    }else {
      App\CustomersToken::where(['customer_id' => $data['id']])->update(['token_id' => $data['token']]);
      $message['success'] = 0;
    }
    return response()->json($message);

  });


  // NOTIFICATIONS
  // CUSTOMERS
  Route::get('/notification/count','API\NotificationController@count');
  Route::get('/notification/list/{id}','API\NotificationController@list');
  Route::get('/notification/count/{id}','Api\NotificationController@notification_count');

  //ADMIN
  Route::get('/notification/admin/count','API\NotificationController@admin_count');
  Route::get('/notification/admin/list','API\NotificationController@admin_list');





});
