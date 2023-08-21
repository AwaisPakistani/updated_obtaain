<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignPaper extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_id',
        'assign_to',
        'assign_by',
    ];
}
