<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('class_records', function (Blueprint $table) {
            $table->decimal('midterm_grade', 3, 1)->nullable()->after('midterm');
            $table->decimal('prefinal_grade', 3, 1)->nullable()->after('final');
        });
    }

    public function down()
    {
        Schema::table('class_records', function (Blueprint $table) {
            $table->dropColumn(['midterm_grade', 'prefinal_grade']);
        });
    }
};