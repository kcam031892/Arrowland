<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

  public function reservation() {
    return $this->belongsTo('App\Reservation');
  }

  public function notification() {
    return $this->morphMany('App\NotificationCustomer','notificationable');
  }

}
