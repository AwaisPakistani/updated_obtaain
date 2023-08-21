<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;
    protected $fillable = [
        'frontuser_id',
        'chief_id',
        'journal_id',
        'submission_language',
        'article_type',
        'ethical',
        'percentagePaper',
        'submission_title',
        'abstract',
        'keywords',
        'comments',
        'revision',
        'volume_id',
        'issue_id',
        'pdf',
        'submission_date',
        'deleted_at',
        'posting_status',
        'status',
        'revision_status',
    ];
    public function files(){
        return $this->hasMany(File::class);
    }
    
}
