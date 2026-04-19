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
        Schema::create('tbl_job_application', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seeker_id')->constrained('tbl_seeker_profile')->onDelete('cascade');
            $table->foreignId('job_id')->constrained('tbl_job')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('tbl_company')->onDelete('cascade');
            $table->string('seeker_name', 255);
            $table->integer('seeker_current_salary');
            $table->integer('seeker_expected_salary');
            $table->integer('seeker_experience');
            $table->string('cover_letter',2000);
            $table->string('seeker_resume', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_job_application');
    }
};
