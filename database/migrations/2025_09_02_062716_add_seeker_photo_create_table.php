<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tbl_seeker_profile', function (Blueprint $table) {
            $table->string('seeker_photo')->after('seeker_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_seeker_profile', function (Blueprint $table) {
             $table->dropColumn('seeker_photo');
        });
    }
};
