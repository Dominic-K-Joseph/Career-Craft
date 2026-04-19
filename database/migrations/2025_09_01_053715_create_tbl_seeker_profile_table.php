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
        Schema::create('tbl_seeker_profile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('login_id')->constrained('tbl_login')->onDelete('cascade');
            $table->string('seeker_name');
            $table->string('seeker_email')->unique();
            $table->string('seeker_phone');
            $table->string('seeker_address');
            $table->string('seeker_education');
            $table->string('seeker_location');
            $table->binary('seeker_skills');
            $table->string('seeker_experience')->nullable();
            $table->string('seeker_resume')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_seeker_profile');
    }
};
