<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;

class Follower extends Model
{
    use HasFactory;

    protected $guarded=[];
    /*
    |--------------------------------------------------------------------------
    | Table Reletion
    |--------------------------------------------------------------------------
    |
    |
    */

    public function follower()
    {
    	return $this->belongsTo(Person::class,'follower_id');//follower_id Foreign key on the followrs table
    }

    public function following()
    {
    	return $this->belongsTo(Person::class,'following_id');//following_id Foreign key on the followrs table
    }
}
