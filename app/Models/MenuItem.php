<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public function Item1(){
        return $this->belongsTo(Item::class,'item_id')->withTrashed();
    }
    public function Menu(){
        return $this->belongsTo(Menu::class);
    }
}
