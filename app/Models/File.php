<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
    	'revision',
        'paper_id',
        'filepath',
    ];
    public function paper(){
        return $this->belongsTo(Paper::class);
    }
}
