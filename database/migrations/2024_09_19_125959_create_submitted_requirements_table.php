<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('submitted_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requirement_id'); // Assuming requirement_id is a foreign key
            $table->string('file'); // Path to the file
            $table->unsignedBigInteger('instructor_id'); // Assuming instructor_id is a foreign key
            $table->unsignedBigInteger('class_id'); // Add the class_id column
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade'); // Add foreign key constraint
            $table->foreign('requirement_id')->references('id')->on('requirements')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submitted_requirements');
    }
};
