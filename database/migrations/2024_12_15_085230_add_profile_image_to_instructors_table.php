<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileImageToInstructorsTable extends Migration
{
    public function up()
    {
        Schema::table('instructors', function (Blueprint $table) {
            $table->string('profile_image')->nullable()->after('username'); // Add profile_image column
        });
    }

    public function down()
    {
        Schema::table('instructors', function (Blueprint $table) {
            $table->dropColumn('profile_image'); // Remove profile_image column
        });
    }
}