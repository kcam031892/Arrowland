<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomersToken extends Model
{
    protected $table = "customers_token";

    protected $fillable = [
      'customer_id','token_id'
    ];
}
