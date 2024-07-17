<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function menuItem(){
        return $this->hasMany(MenuItem::class,'item_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    
}
