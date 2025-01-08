<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateActivityLogsForeignKey extends Migration
{
    public function up()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropForeign(['submitted_requirement_id']);
            $table->foreign('submitted_requirement_id')
                  ->references('id')->on('submitted_requirements')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropForeign(['submitted_requirement_id']);
            $table->foreign('submitted_requirement_id')
                  ->references('id')->on('submitted_requirements')
                  ->onDelete('restrict');
        });
    }
}