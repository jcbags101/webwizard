<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('class_records', function (Blueprint $table) {
            // Quizzes (6)
            $table->decimal('quiz_1', 5, 2)->nullable();
            $table->decimal('quiz_2', 5, 2)->nullable();
            $table->decimal('quiz_3', 5, 2)->nullable();
            $table->decimal('quiz_4', 5, 2)->nullable();
            $table->decimal('quiz_5', 5, 2)->nullable();
            $table->decimal('quiz_6', 5, 2)->nullable();
            
            // Oral Exams (6)
            $table->decimal('oral_1', 5, 2)->nullable();
            $table->decimal('oral_2', 5, 2)->nullable();
            $table->decimal('oral_3', 5, 2)->nullable();
            $table->decimal('oral_4', 5, 2)->nullable();
            $table->decimal('oral_5', 5, 2)->nullable();
            $table->decimal('oral_6', 5, 2)->nullable();
            
            // Projects (4)
            $table->decimal('project_1', 5, 2)->nullable();
            $table->decimal('project_2', 5, 2)->nullable();
            $table->decimal('project_3', 5, 2)->nullable();
            $table->decimal('project_4', 5, 2)->nullable();
            
            // Term Exams (2)
            $table->decimal('midterm', 5, 2)->nullable();
            $table->decimal('final', 5, 2)->nullable();
            
            // Final Grade
            $table->decimal('final_grade', 5, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('class_records', function (Blueprint $table) {
            $table->dropColumn([
                'quiz_1', 'quiz_2', 'quiz_3', 'quiz_4', 'quiz_5', 'quiz_6',
                'oral_1', 'oral_2', 'oral_3', 'oral_4', 'oral_5', 'oral_6',
                'project_1', 'project_2', 'project_3', 'project_4',
                'midterm', 'final',
                'final_grade'
            ]);
        });
    }
}; 