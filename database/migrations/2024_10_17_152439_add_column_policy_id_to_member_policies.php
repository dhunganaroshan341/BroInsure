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
        Schema::table('member_policies', function (Blueprint $table) {
            $table->foreignId('policy_id')->nullable()->constrained('company_policies');
            $table->string('individual_policy_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_policies', function (Blueprint $table) {
            //
        });
    }
};
