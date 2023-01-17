<?php

namespace App\Models;

use Database\Factories\StatusTypeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\StatusType
 *
 * @property int $id
 * @property int $admin_id
 * @property int $type_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static StatusTypeFactory factory(...$parameters)
 * @method static Builder|StatusType newModelQuery()
 * @method static Builder|StatusType newQuery()
 * @method static Builder|StatusType query()
 * @method static Builder|StatusType whereAdminId($value)
 * @method static Builder|StatusType whereCreatedAt($value)
 * @method static Builder|StatusType whereId($value)
 * @method static Builder|StatusType whereName($value)
 * @method static Builder|StatusType whereTypeId($value)
 * @method static Builder|StatusType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StatusType extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s', // Change your format
        'updated_at' => 'datetime:Y-m-d h:i:s',
    ];

    public function admin(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'admin_id');
    }

    public function messages()
    {
        return $this->hasMany(Messages::class, 'status_id', 'type_id');
    }
}
