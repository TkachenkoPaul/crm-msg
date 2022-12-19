<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
     protected $fillable = [
        'admin_id',
        'reply_id',
        'path',
        'name',
        'size',
        ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
    ];
    public function reply()
    {
        return $this->belongsTo(Reply::class,'id','reply_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class,'id','admin_id');
    }
}
