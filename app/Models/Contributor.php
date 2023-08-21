<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contributor extends Model
{
    use HasFactory;
    protected $fillable = [
          'author_id',
          'journal_id',
          'paper_id',
          'first_name',
          'last_name',
          'email',
          'degree',
          'position',
          'institution',
          'department',
          'country',
    ];
}
