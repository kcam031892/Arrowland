<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationCustomer extends Model
{
    public function notificationable() {
      return $this->morphTo();
    }
}
