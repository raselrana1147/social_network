<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Page;
use App\Models\Follower;
use App\Models\PageFollower;
use App\Models\Post;
use App\Models\PagePost;

class Person extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table="persons";
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /*
    |--------------------------------------------------------------------------
    | Table Reletion
    |--------------------------------------------------------------------------
    |
    |
    */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function followers()
    {
        return $this->hasMany(Follower::class,'follower_id'); //follower_id Foreign key on the followrs table
    }

    public function followings()
    {
        return $this->hasMany(Follower::class,'following_id'); //following_id Foreign key on the followrs table
    }

    public function pagefollower()
    {
        return $this->hasMany(PageFollower::class,'person_id'); //person_id Foreign key on the page_followers table
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function pagePosts()
    {
        return $this->hasMany(PagePost::class);
    }


    public function feeds()
    {
        return $this->hasManyThrough(Post::class,
            Follower::class,'follower_id','person_id','id','id');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    
    public function getJWTCustomClaims()
    {
        return [];
    }
}
