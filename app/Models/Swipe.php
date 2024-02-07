<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Swipe extends Model
{
    use HasFactory;

    protected $guarded =[];

    /* representing the user who made the swipe  */
    function user() : BelongsTo {

        return $this->belongsTo(User::class);
    }


    /* representing the user who was swiped */
    function swipedUser() : BelongsTo {

        return $this->belongsTo(User::class,'swiped_user_id');
    }

    /* check if user is super like  */

    function isSuperLike() : bool {

        return $this->type=='up';
        
    }



    /* has one */
    public function match()
    {
        
        return $this->hasOne(Swipe::class,'swipe_id_1')->orWhere('swipe_id_2',$this->getKey());
    }
}
