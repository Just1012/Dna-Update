<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function Menu(){
        return $this->hasMany(MenuItem::class);
    }


    public function Program(){
        return $this->hasMany(Program::class, 'menu_id');
    }
}
