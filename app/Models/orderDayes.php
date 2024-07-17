<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderDayes extends Model
{
    use HasFactory;
        protected $guarded = [];

        public function OrderDays(){
            return $this->belongsTo(Order::class);
        }
        public function Address(){
            return $this->belongsTo(Address::class,'address_id');
        }

}
