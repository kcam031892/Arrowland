<?php
use App\Customer;
class Helpers {

  public static function generateRandomString($len,$chars = 15 ) {

    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
    $charsLen = strlen($chars);
    $randString = '';
    for($i = 0; $i <$len; $i++ ) {
      $randString .= $chars[rand(0,$charsLen-1)];
    }
    return $randString;
  }

  public static function checkUsername($username) {

    $customer = Customer::where(['username' => $username])->get();
    if($customer->isEmpty()) {
      return true;
    }else {
      return false;
    }


  }

  public static function defaultURL() {
    $url = 'http://arrowlandcp.com/';
    return $url;
  }

  public static function galleryImagePath() {
    $url = Helpers::defaultURL() . 'images/backend/gallery/large/';
    return $url;
  }

  public static function eventsImagePath(){
    $url = Helpers::defaultURL() . 'images/backend/events/';
    return $url;
  }

  public static function newsImagePath() {
    $url = Helpers::defaultURL() . 'images/backend/news/';
    return $url;

  }

  public static function firebaseDefaultUrl() {
    $url = 'https://arrowland-5505e.firebaseio.com/';
    return $url;

  }
  public static function firebaseDefaultToken() {
    $token = 'Py1IH4CTz77n9trTcRpUD7Y1XYf3g95OUT2In3P0';
    return $token;
  }
  public static function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';

  }

}

 ?>
