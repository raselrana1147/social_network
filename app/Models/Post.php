<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;

class Post extends Model
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

    public function persons()
    {
    	return $this->belognsTo(Person::class);
    }
}
