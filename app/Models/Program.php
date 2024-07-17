<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function Menu(){
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    // public function durations()
    // {
    //     return $this->hasManyThrough(
    //         Duration::class,
    //         Program_Duration::class,
    //         'program_id',  // Foreign key on Program_Duration table
    //         'id',          // Foreign key on Duration table
    //         'id',          // Local key on Program table
    //         'duration_id'  // Local key on Program_Duration table
    //     );
    // }

    public function meals()
    {
        return $this->hasManyThrough(
            Meal::class,
            Program_Duration::class,
            'program_id',  // Foreign key on Program_Duration table
            'id',          // Foreign key on Meal table
            'id',          // Local key on Program table
            'meal_id'      // Local key on Program_Duration table
        );
    }

    public function durations_pro(){
        return $this->hasMany(Program_Duration::class,'program_id');
    }
}
