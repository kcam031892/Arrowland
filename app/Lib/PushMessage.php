<?php
namespace App\Lib;

class PushMessage {
  private $title;
  private $message;
  private $image;
  private $data;
  private $isBackground;
  private $intent;
  private $id;
  private $fbIntent;


// SET FUNCTION
  public  function setTitle($title) {
    $this->title = $title;
  }
  public  function setMessage($message) {
    $this->message = $message;
  }
  public  function setImage($imageUrl) {
    $this->image = $imageUrl;

  }
  public  function setPayload($data){
    $this->data = $data;

  }
  public  function setIsBackground($isBackground) {
    $this->$isBackground = $isBackground;
  }
  public  function setIntent($intent){
    $this->intent = $intent;
  }
  public  function setId($id) {
    $this->id = $id;
  }
  public function setFbIntent($fbIntent) {
    $this->fbIntent = $fbIntent;
  }

// GET FUNCTION
  public  function getTitle() {
    return $this->title;
  }
  public  function getMessage() {
    return $this->message;
  }
  public  function getImageUrl() {
    return $this->image;
  }
  public  function getDataPayload() {
    return $this->data;
  }
  public  function getId() {
    return $this->id;
  }

  public  function getPushMessage() {
    $arr = array();
    $arr['data']['title'] = $this->title;
    $arr['data']['message'] = $this->message;
    $arr['data']['image'] = $this->image;
    $arr['data']['isBackground'] = $this->isBackground;
    $arr['data']['payload'] = $this->data;
    $arr['data']['intent'] = $this->intent;
    $arr['data']['id'] = $this->id;
    $arr['data']['fbIntent'] = $this->fbIntent;
    $arr['data']['timestamp'] = date('Y-m-d G:i:s');

    return $arr;
  }

  public  function getPushDatabase() {
    $arr = array();
    $arr['title'] = $this->title;
    $arr['message'] = $this->message;
    $arr['image_url'] = $this->image;
    $arr['id'] = $this->id;
    $arr['created_at'] = date('Y-m-d G:i:s');

    return $arr;
  }

}


 ?>
