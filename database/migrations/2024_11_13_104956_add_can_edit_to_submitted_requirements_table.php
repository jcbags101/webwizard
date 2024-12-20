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
        Schema::table('submitted_requirements', function (Blueprint $table) {
            $table->enum('edit_status', ['pending', 'approved', 'rejected', 'request_submitted'])->default('pending');
        });
    }

    public function down()
    {
        Schema::table('submitted_requirements', function (Blueprint $table) {
            $table->dropColumn('edit_status');
        });
    }
};
