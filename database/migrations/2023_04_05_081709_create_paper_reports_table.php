<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('paper_id');
            $table->integer('to_user_id');
            $table->integer('from_user_id');
            $table->longText('title_remarks')->nullable();
            $table->longText('abstract_remarks')->nullable();
            $table->longText('keyword_remarks')->nullable();
            $table->longText('introduction_remarks')->nullable();
            $table->longText('originality_remarks')->nullable();
            $table->longText('relationship_remarks')->nullable();
            $table->longText('framework_remarks')->nullable();
            $table->longText('methodology_remarks')->nullable();
            $table->longText('population_remarks')->nullable();
            $table->longText('instrument_remarks')->nullable();
            $table->longText('result_remarks')->nullable();
            $table->longText('implications_remarks')->nullable();
            $table->longText('quality_remarks')->nullable();
            $table->longText('recommendation_remarks')->nullable();
            $table->longText('revision_status')->nullable();
            $table->longText('for_author_comments')->nullable();
            $table->longText('for_chiefeditor_comments')->nullable();
            $table->longText('chiefeditor_remarks')->nullable();
            $table->longText('report_status')->nullable();
            $table->longText('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paper_reports');
    }
};
