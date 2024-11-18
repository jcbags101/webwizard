<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('class_records');
        Schema::create('class_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            
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

            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_records');
    }
};
