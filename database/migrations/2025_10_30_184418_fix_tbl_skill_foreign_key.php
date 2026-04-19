<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tbl_skill', function (Blueprint $table) {
            // Drop the old foreign key first
            $table->dropForeign(['login_id']);

            // Add the correct one (pointing to tbl_seeker_profile)
            $table->foreign('login_id')
                ->references('login_id')  // use login_id if tbl_seeker_profile uses it
                ->on('tbl_seeker_profile')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_skill', function (Blueprint $table) {
            $table->dropForeign(['login_id']);
            $table->foreign('login_id')
                ->references('id')
                ->on('tbl_company')
                ->onDelete('cascade');
        });
    }
};
