<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_record_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes');
            
            // Quiz scores
            for ($i = 1; $i <= 6; $i++) {
                $table->decimal('quiz_' . $i, 5, 2)->nullable();
            }
            
            // Oral scores
            for ($i = 1; $i <= 6; $i++) {
                $table->decimal('oral_' . $i, 5, 2)->nullable();
            }
            
            // Project scores
            for ($i = 1; $i <= 4; $i++) {
                $table->decimal('project_' . $i, 5, 2)->nullable();
            }
            
            // Exam scores
            $table->decimal('midterm', 5, 2)->nullable();
            $table->decimal('final', 5, 2)->nullable();
            $table->decimal('final_grade', 5, 2)->nullable();
            
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_record_items');
    }
};