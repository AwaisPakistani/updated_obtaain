<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontAuthor extends Model
{
    use HasFactory;
    protected $fillable = [
        'frontuser_id',
        'affiliation',
        'country',
        'status',
    ];
    public function front_user_main(){
        return $this->belongsTo(Frontuser::class);
    }
}
