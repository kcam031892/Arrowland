<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Image;
use Helpers;
use App\Lib\FirebaseMessage;
use App\Lib\PushMessage;
use Firebase;

class NewsController extends Controller
{
    public function add(Request $request) {

          if($request->isMethod('post')) {
            $url = Helpers::firebaseDefaultUrl();
            $token = Helpers::firebaseDefaultToken();
            $fdb = new \Firebase\FirebaseLib($url,$token);

            $data = $request->all();
            $id = 'News-'.Helpers::generateRandomString(30);
            $path = '/news';

            if($request->hasFile('file')) {
              $image_tmp = Input::file('file');
              if($image_tmp->isValid()) {
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = Helpers::generateRandomString(15).'-'.Helpers::generateRandomString(15).'.'.$extension;
                $image_path = 'images/backend/news/'.$filename;

                Image::make($image_tmp)->save($image_path);
                $image_url = Helpers::newsImagePath() . $filename;

              }
            }

              $pm = new PushMessage();
              $fcm = new FirebaseMessage();

              $pm->setTitle($data['title']);
              $pm->setMessage($data['message']);
              $pm->setImage($image_url);
              $pm->setId($id);
              $pm->setIntent("All");
              $pm->setFbIntent("News");


              $jsonMessage = $pm->getPushMessage();
              $jsonDatabase = $pm->getPushDatabase();

              $fcm->sendToTopic("Arrowland",$jsonMessage);
              $fdb->push($path . '/',$jsonDatabase);
              $message['message'] = "Success";

              return redirect()->back()->with('flash_message_success','Successfully Added');


            }


      return view('admin.news.news_add');
    }

    public function list() {
      $url = Helpers::firebaseDefaultUrl();
      $token = Helpers::firebaseDefaultToken();
      $fdb = new \Firebase\FirebaseLib($url,$token);
      $path = '/news';
      $name = $fdb->get($path);
      $json = json_decode($name,1);
      if(!empty($json)) {
        $firebaseId = array_keys($json)[0];

      }else {
        $firebaseId = "";
      }

      // echo "<pre>";print_r($json);die;



      return view('admin.news.news_list')->with(compact('json','firebaseId'));
    }

    public function delete($id) {
      $url = Helpers::firebaseDefaultUrl();
      $token = Helpers::firebaseDefaultToken();
      $fdb = new \Firebase\FirebaseLib($url,$token);
      $path = '/news';
      $fdb->delete($path . '/' . $id);

      return redirect()->back()->with('flash_message_success','Successfully Deleted');
    }

    public function test(Request $request) {
      if($request->isMethod('post')) {
        $data = $request->all();

        return response()->json($data);
      }

    }

}
