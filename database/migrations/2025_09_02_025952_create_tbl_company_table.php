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
        Schema::create('tbl_company', function (Blueprint $table) {
            $table->id();
            $table->foreignId('login_id')->constrained('tbl_login')->onDelete('cascade');
            $table->string('company_title');
            $table->string('comapny_logo');
            $table->string('company_email');
            $table->string('comapny_phone');
            $table->string('company_location');
            $table->string('comapny_year');
            $table->string('company_details');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_company');
    }
};
