<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('class_record_items', function (Blueprint $table) {
            // Pre-final Quizzes (6)
            $table->decimal('pre_final_quiz_1', 5, 2)->nullable()->after('quiz_6');
            $table->decimal('pre_final_quiz_2', 5, 2)->nullable();
            $table->decimal('pre_final_quiz_3', 5, 2)->nullable();
            $table->decimal('pre_final_quiz_4', 5, 2)->nullable();
            $table->decimal('pre_final_quiz_5', 5, 2)->nullable();
            $table->decimal('pre_final_quiz_6', 5, 2)->nullable();
            
            // Pre-final Oral Exams (6)
            $table->decimal('pre_final_oral_1', 5, 2)->nullable()->after('oral_6');
            $table->decimal('pre_final_oral_2', 5, 2)->nullable();
            $table->decimal('pre_final_oral_3', 5, 2)->nullable();
            $table->decimal('pre_final_oral_4', 5, 2)->nullable();
            $table->decimal('pre_final_oral_5', 5, 2)->nullable();
            $table->decimal('pre_final_oral_6', 5, 2)->nullable();
            
            // Pre-final Projects (4)
            $table->decimal('pre_final_project_1', 5, 2)->nullable()->after('project_4');
            $table->decimal('pre_final_project_2', 5, 2)->nullable();
            $table->decimal('pre_final_project_3', 5, 2)->nullable();
            $table->decimal('pre_final_project_4', 5, 2)->nullable();
            
            // Pre-final Term Exams
            $table->decimal('pre_final_midterm', 5, 2)->nullable()->after('midterm');
            $table->decimal('pre_final_final', 5, 2)->nullable()->after('final');
        });
    }

    public function down()
    {
        Schema::table('class_record_items', function (Blueprint $table) {
            $table->dropColumn([
                'pre_final_quiz_1',
                'pre_final_quiz_2',
                'pre_final_quiz_3',
                'pre_final_quiz_4',
                'pre_final_quiz_5',
                'pre_final_quiz_6',
                'pre_final_oral_1',
                'pre_final_oral_2',
                'pre_final_oral_3',
                'pre_final_oral_4',
                'pre_final_oral_5',
                'pre_final_oral_6',
                'pre_final_project_1',
                'pre_final_project_2',
                'pre_final_project_3',
                'pre_final_project_4',
                'pre_final_midterm',
                'pre_final_final'
            ]);
        });
    }
};