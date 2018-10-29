<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationAdmin extends Model
{
  public function notificationable() {
    return $this->morphTo();
  }
}
