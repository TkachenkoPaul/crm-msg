<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Messages
 *
 * @property int $id
 * @property string $fio
 * @property string $address
 * @property string $house
 * @property int $type_id
 * @property string $phone
 * @property int $admin_id
 * @property string $closed
 * @property int $status_id
 * @property int $responsible_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $admin
 * @property-read \App\Models\User|null $responsible
 * @property-read \App\Models\StatusType|null $status
 * @property-read \App\Models\MessageType|null $type
 * @method static \Database\Factories\MessagesFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Messages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Messages query()
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereFio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereHouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereResponsibleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Messages extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'responsible_id',
        'type_id',
        'house',
        'address',
        'fio',
        'closed',
        'phone',
        'status_id',
        'uid','contract','photo','plan'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s', // Change your format
        'updated_at' => 'datetime:Y-m-d h:i:s',
    ];

    public function admin(): HasOne
    {
        return $this->hasOne(User::class,'id','admin_id');
    }
    public function responsible(): HasOne
    {
        return $this->hasOne(User::class,'id','responsible_id');
    }

    public function type(): HasOne
    {
        return $this->hasOne(MessageType::class,'id','type_id');
    }

    public function status(): HasOne
    {
        return $this->hasOne(StatusType::class,'type_id','status_id');
    }
}
