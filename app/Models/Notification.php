<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_id',
        'to_user_id',
        'from_user_id',
        'content',
        'status',
    ];
}
