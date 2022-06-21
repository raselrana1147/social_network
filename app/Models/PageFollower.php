<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;

class PageFollower extends Model
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
    public function person()
    {
    	return $this->belongsTo(Person::class);
    }
}
