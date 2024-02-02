<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\BasicGroupEnum;
use App\Enums\RelationshipGoalsEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

     protected $guarded=[];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'relationship_goals'=>RelationshipGoalsEnum::class
    ];

    //Boot method

    protected static function boot(){
        parent::boot();

        static::created(function($user){

            $basics= Basic::all();
            //if wants children in the future
            $basic = $basics->where('group',BasicGroupEnum::children)->first();
            $user->basics()->attach($basic);


            //zodiac
            $basic = $basics->where('group',BasicGroupEnum::zodiac)->first();
            $user->basics()->attach($basic);



        });


    }



    function basics() : BelongsToMany {

        return $this->belongsToMany(Basic::class,'basic_user');
        
    }
}
