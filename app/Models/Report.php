<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'count',
        'job_id'
    ];

    public function admin(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'admin_id');
    }
}
