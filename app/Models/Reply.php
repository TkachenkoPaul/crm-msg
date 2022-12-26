<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Reply extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
    ];

    public static function boot() {
        parent::boot();
        self::deleting(function($reply) { // before delete() method call this
            $reply->attachment()->each(function($attachment) {
                Log::alert('Log attachment delete ID:'.$attachment->id);
                Log::alert('Storage path:'.$attachment->path);
                $attachment->delete(); // <-- direct deletion

            });
        });
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class,'admin_id','id');
    }

    public function message(): BelongsTo
    {
        return $this->belongsTo(Messages::class,'message_id','id');
    }

    public function attachment(): HasMany
    {
        return $this->hasMany(Attachment::class,'reply_id','id');
    }
}
