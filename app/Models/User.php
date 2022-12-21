<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $login
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'login',
        'password',
        'disable'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s', // Change your format
        'updated_at' => 'datetime:Y-m-d h:i:s',
    ];

    public function master()
    {
        return $this->hasOne(User::class,'id','admin_id');
    }

    public function opened()
    {
        return $this->hasMany(Messages::class,'responsible_id','id')
            ->where('messages.status_id','=','0');
    }

    public function done()
    {
        return $this->hasMany(Messages::class,'responsible_id','id')
            ->where('messages.status_id','=','1');
    }
    public function closed()
    {
        return $this->hasMany(Messages::class,'responsible_id','id')
            ->where('messages.status_id','=','2');
    }
    public function edit()
    {
        return $this->hasMany(Messages::class,'responsible_id','id')
            ->where('messages.status_id','=','3');
    }
    public function plan()
    {
        return $this->hasMany(Messages::class,'responsible_id','id')
            ->where('messages.status_id','=','4');
    }
     public function paid()
    {
        return $this->hasMany(Messages::class,'responsible_id','id')
            ->where('messages.status_id','=','5');
    }
    public function checked()
    {
        return $this->hasMany(Messages::class,'responsible_id','id')
            ->where('messages.status_id','=','6');
    }

}
