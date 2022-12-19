<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class,'admin_id','id');
    }

    public function message()
    {
        return $this->belongsTo(Messages::class,'message_id','id');
    }

    public function attachment()
    {
        return $this->hasMany(Attachment::class,'reply_id','id');
    }
}
