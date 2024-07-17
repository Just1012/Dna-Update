<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Program(){
        return $this->belongsTo(Program::class);
    }
    public function Duration(){
        return $this->belongsTo(Duration::class);
    }
    public function OrderDays(){
        return $this->hasMany(orderDayes::class);
    }
    
    
}
