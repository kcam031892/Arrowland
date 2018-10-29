<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\News;

use Image;
use Helpers;
use App\Lib\FirebaseMessage;
use App\Lib\PushMessage;

class NewsController extends Controller
{
    public function add(Request $request) {
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

          Image::make($image_tmp)->resize(600,300)->save($image_path);
          $image_url = Helpers::eventsImagePath() . $filename;

        }
      }

      $pm = new PushMessage();
      $fcm = new FirebaseMessage();

      $pm->setTitle($data['title']);
      $pm->setMessage($data['message']);
      $pm->setImage($image_url);
      $pm->setId($id);
      $pm->setIntent("All");


      $jsonMessage = $pm->getPushMessage();
      $jsonDatabase = $pm->getPushDatabase();

      $fcm->sendToTopic("Arrowland",$jsonMessage);
      $fdb->push($path . '/',$jsonDatabase);
      $message['message'] = "Success";

      return response()->json($message);





    }
}
