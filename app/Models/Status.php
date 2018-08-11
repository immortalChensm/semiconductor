<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Status extends Model
{
    //
    protected $guarded = [];
    
    public function users()
    {
        return $this->belongsTo(User::class,"user_id","id");
    }
}
