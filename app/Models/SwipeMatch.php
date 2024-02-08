<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwipeMatch extends Model
{
    use HasFactory;

    protected $guarded=[];

    public  function swipe1 ()
    {
        return $this->belongsTo(Swipe::class,'swipe_id_1','id');
        
    }
    
    public  function swipe2 ()
    {
        return $this->belongsTo(Swipe::class,'swipe_id_2','id');
        
    }

    public function conversation()
    {
        return $this->hasOne(Conversation::class);
        
    }
}
