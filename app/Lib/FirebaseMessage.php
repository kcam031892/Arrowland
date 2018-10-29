<?php
namespace App\Lib;

class FirebaseMessage {

  public  function send($to,$message) {
    $fields = array(
      'to' => $to,
      'data' => $message

    );

    return $this->sendNotification($fields);
  }

  public  function sendToTopic($to,$message) {
    $fields = array(
      'to' => '/topics/' . $to,
      'data' => $message

    );
    return $this->sendNotification($fields);
  }
  




  public  function sendNotification($fields) {
      define('FIREBASE_API_KEY','AAAAWJakDag:APA91bFA0hWFZWRQkvXpab1vlH-sx69THr1xK4eP4XHotQ-ixrg9micoeCm-Qn7rBIcrCXHqxAEg965MBF51gqEXWAOhbeGbzVfRG_CamlOD0lygrjTTXH5m0CKPwjEFebKaj_ztvWJrJXbEcLKUKipvG7x4-2csmw');

      $url = 'https://fcm.googleapis.com/fcm/send';

      $headers = array(
          'Authorization: key=' . FIREBASE_API_KEY,
          'Content-Type:application/json'

      );

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
      curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
      $result = curl_exec($ch );

      if($result == FALSE) {
          die('Curl Failed: ' . curl_error($ch));
      }

      curl_close( $ch );
      return $result;

    }

  }



 ?>
