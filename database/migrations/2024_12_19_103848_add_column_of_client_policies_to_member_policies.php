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
            $table->date('issue_date')->nullable();
            $table->string('colling_period')->nullable();
            $table->date('valid_date')->nullable();
            $table->string('imitation_days')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_policies', function (Blueprint $table) {
            $table->dropColumn('issue_date');
            $table->dropColumn('colling_period');
            $table->dropColumn('valid_date');
            $table->dropColumn('imitation_days');
        });
    }
};
