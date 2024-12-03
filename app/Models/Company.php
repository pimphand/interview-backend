<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Company extends Model
{
    use HasUuids,SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
