<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public function childeren(){
        return $this->hasMany(Category::class,'parent_id');
    }
    public function parents(){
        return $this->belongsTo(Category::class,'id');

    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
