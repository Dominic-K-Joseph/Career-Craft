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
        Schema::create('tbl_job', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('tbl_company')->onDelete('cascade');
            $table->string('job_name');
            $table->string('job_salary');
            $table->string('job_location');
            $table->string('job_type');
            $table->string('job_expirience');
            $table->text('job_description');
            $table->boolean('status')->default(1);    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_job');
    }
};
