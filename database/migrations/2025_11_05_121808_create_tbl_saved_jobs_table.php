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
        Schema::create('tbl_saved_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seeker_id')->constrained('tbl_seeker_profile')->onDelete('cascade');
            $table->foreignId('job_id')->constrained('tbl_job')->onDelete('cascade');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_saved_jobs');
    }
};
