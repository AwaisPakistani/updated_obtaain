<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'author_id',
        'paper_id',
        'to_user_id',
        'from_user_id',
        'title_remarks',
        'abstract_remarks',
        'keyword_remarks',
        'introduction_remarks',
        'originality_remarks',
        'relationship_remarks',
        'framework_remarks',
        'methodology_remarks',
        'population_remarks',
        'instrument_remarks',
        'result_remarks',
        'implications_remarks',
        'quality_remarks',
        'recommendation_remarks',
        'revision_status',
        'for_author_comments',
        'for_chiefeditor_comments',
        'chiefeditor_remarks',
        'report_status',
        'deleted_at',
    ];
}
