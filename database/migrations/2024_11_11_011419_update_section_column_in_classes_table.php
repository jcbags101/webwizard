<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('classes', function (Blueprint $table) {
            // First create the new column
            $table->unsignedBigInteger('section_id')->nullable();
            
            // Add foreign key constraint
            $table->foreign('section_id')
                  ->references('id')
                  ->on('sections')
                  ->onDelete('set null');

            // Remove the old column
            $table->dropColumn('section');
        });
    }

    public function down()
    {
        Schema::table('classes', function (Blueprint $table) {
            // Remove the foreign key constraint
            $table->dropForeign(['section_id']);
            
            // Drop the new column
            $table->dropColumn('section_id');
            
            // Recreate the original column
            $table->string('section')->nullable();
        });
    }
};