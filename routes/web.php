<?php
use Helpers as Helpers;
use Customer as Customer;

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

});

// BACKEND ROUTES
//  Login

Route::match(['get','post'],'/admin','AdminController@login')->name('login');

// Logout

  Route::get('/admin/refund','RefundController@refund_list')->name('refund');
// GROUP AUTH
Route::group(['middleware' => ['auth']], function(){
  Route::match(['get','post'], '/admin/profile','AdminController@profile')->name('profile');
  Route::get('/admin/dashboard', 'AdminController@dashboard')->name('dashboard');
  Route::get('/admin/logout', 'AdminController@logout')->name('logout');


  // REFUND


  // RESERVATION
  Route::get('/admin/range-rental/{status}/list','ReservationController@list');
  Route::get('/admin/range-rental/{id}/detail','ReservationController@detail');
  Route::get('/admin/range-rental/accept/{id}/{payment_id}','ReservationController@acceptPendingRequest');
  Route::get('/admin/range-rental/cancel/{id}','ReservationController@cancelReservation');
  Route::get('/admin/range-rental/complete/{id}','ReservationController@completeReservation');

  // PAYMENT
  Route::get('/admin/payment/{id}/detail', 'PaymentController@detail');
  Route::get('/admin/payment/delete/{id}','PaymentController@delete');

  // Route::get('/admin/range-rental/list/accepted/','ReservationController@acceptedList');

  // MEMBERSHIP
  Route::get('/admin/membership/list','MembershipController@list')->name('membership_list');
  Route::get('/admin/membership/request','MembershipController@requestList')->name('membership_request');
  Route::get('/admin/membership/accept/{id}', 'MembershipController@accept');
  Route::get('/admin/membership/cancel/{id}','MembershipController@cancel');

  // LESSONS

  Route::get('/admin/lesson/list','LessonController@list')->name('lesson_list');
  Route::get('/admin/lesson/request','LessonController@requestList')->name('lesson_request');
  Route::get('/admin/lesson/accept/{id}', 'LessonController@accept');
  Route::get('/admin/lesson/cancel/{id}','LessonController@cancel');
  Route::get('/admin/lesson/schedule-request/','LessonController@schedule_request');
  Route::get('/admin/lesson/schedule-request/accepted','LessonController@schedule_request_accepted');
  Route::get('/admin/lesson/schedule-request/accept/{id}','LessonController@schedule_accept');
  Route::get('/admin/lesson/schedule-request/complete/{id}','LessonController@schedule_complete');

  // GALLERY
  Route::match(['get','post'], '/admin/gallery/add', 'GalleryController@add');
  Route::get('/admin/gallery/list', 'GalleryController@list');
  Route::get('/admin/gallery/delete/{id}', 'GalleryController@delete');


  // EVENTS
  Route::match(['get','post'],'/admin/events/add','EventsController@add');
  Route::get('/admin/events/list','EventsController@list');
  Route::get('/admin/events/delete/{id}', 'EventsController@delete');

  // NEWS
  Route::match(['get','post'], '/admin/news/add', 'NewsController@add');
  Route::get('/admin/news/list', 'NewsController@list');
  Route::get('/admin/news/delete/{id}','NewsController@delete');
  // Route::post('/admin/news/test','NewsController@test');


  // NOTIFICATION
  Route::get('/admin/notification/list', 'API\NotificationController@admin_view_all');

});

Route::get('/verifyemail/{token}','AccountController@verify');
Route::get('/email',function(){
  return view('email.email');

});



Route::get('/admin/time',function(){

  return date('Y-m-d G:i:s');

});










 // CURL TEST
// Route::get('/test',function(){
//   $url = 'http://arrowland.test/api/gallery';
//   $ch = curl_init();
//   curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//   curl_setopt($ch,CURLOPT_URL,$url);
//   $result = curl_exec($ch);
//   curl_close($ch);
//
//   $json = json_decode($result,1);
//   foreach($json['galleryList'] as $data) {
//     echo $data['img_name'] .'<br />';
//   }
//
// // });
// //
// Route::get('/test2',function(){
// //
// //   $url = 'http://arrowland.test/api/account/login';
// //   $headers = array('Content-Type:application/json');
// //
// //   $fields = array('username'=>'jimmeer123','password'=>'jimmeer123');
// //
// //   $ch = curl_init();
// //   curl_setopt($ch,CURLOPT_URL,$url);
// //   curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
// //   curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
// //   curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
// //   $result = curl_exec($ch);
// //   curl_close($ch);
// //   return $result;
// //
// //
// //
// // });

// REGISTER ADMIN
// Route::get('/admin/register_account', function(){
//   $users = new App\User;
//   $users->name = 'Admin';
//   $users->email = 'admin@admin.com';
//   $users->username = 'admin';
//   $users->password = bcrypt('admin');
//   $users->level = 'admin';
//   $users->remember_token = csrf_token();
//   $users->save();
//
// });
