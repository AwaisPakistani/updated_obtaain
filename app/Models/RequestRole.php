<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestRole extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'request_role_id',
        'old_role_id',
        'status',
    ];
}
