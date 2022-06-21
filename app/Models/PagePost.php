<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;
use App\Models\Page;

class PagePost extends Model
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
    	return $this->belognsTo(Person::class);
    }

    public function page()
    {
    	return $this->belognsTo(Page::class);
    }
}
