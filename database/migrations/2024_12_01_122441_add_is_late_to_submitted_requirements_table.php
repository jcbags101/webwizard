<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('submitted_requirements', function (Blueprint $table) {
            $table->boolean('is_late')->default(false);
            $table->text('message')->nullable()->after('is_late');
        });
    }

    public function down()
    {
        Schema::table('submitted_requirements', function (Blueprint $table) {
            $table->dropColumn(['is_late', 'message']);
        });
    }
};