<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function payment() {
      return $this->hasOne('App\Payment');
    }
    public function paymentIsNotValid() {
      return $this->hasOne('App\Payment')->where('is_valid','<>','Not Valid')->orWhereNull('is_valid');
    }

    public function customer() {
      return $this->belongsTo('App\Customer');
    }

    public function notification() {
      return $this->morphMany('App\NotificationCustomer','notificationable');
    }
}
