<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    public static function boot() {
        parent::boot();
        self::deleting(function($attachment) {
            Log::alert('Log IMAGE delete ID:'.$attachment->id);
            Storage::delete($attachment->path);
        });
    }

    public function reply(): BelongsTo
    {
        return $this->belongsTo(Reply::class,'id','reply_id');
    }
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class,'id','admin_id');
    }
}
