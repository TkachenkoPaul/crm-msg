<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\MessageType
 *
 * @property int $id
 * @property int $admin_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\MessageTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MessageType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MessageType query()
 * @method static \Illuminate\Database\Eloquent\Builder|MessageType whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MessageType extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s', // Change your format
        'updated_at' => 'datetime:Y-m-d h:i:s',
    ];

    public function admin(): HasOne
    {
        return $this->hasOne(User::class,'id','admin_id');
    }
}
