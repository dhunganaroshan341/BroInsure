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
        Schema::table('company_policies', function (Blueprint $table) {
            $table->string('is_active','1')->default('Y');
            $table->string('is_current','1')->default('Y');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_policies', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('is_current');
        });
    }
};
