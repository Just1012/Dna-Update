<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program_Duration extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function duration()
    {
        return $this->belongsTo(Duration::class);
    }
}
