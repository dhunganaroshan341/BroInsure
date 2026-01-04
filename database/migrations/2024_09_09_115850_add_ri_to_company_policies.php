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
            $table->string('nepal_ri')->nullable();
            $table->string('himalayan_ri')->nullable();
            $table->string('retention')->nullable();
            $table->string('quota')->nullable();
            $table->string('surplus_i')->nullable();
            $table->string('surplus_ii')->nullable();
            $table->string('auto_fac')->nullable();
            $table->string('facultative')->nullable();
            $table->string('co_insurance')->nullable();
            $table->string('xol_i')->nullable();
            $table->string('xol_ii')->nullable();
            $table->string('xol_iii')->nullable();
            $table->string('xol_iiii')->nullable();
            $table->string('pool')->nullable();
            $table->json('excess')->nullable();
            if (Schema::hasColumn('company_policies', 'excess_type')) {
                $table->dropColumn('excess_type');
            }
            if (Schema::hasColumn('company_policies', 'excess_amount')) {
                $table->dropColumn('excess_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_policies', function (Blueprint $table) {
            $table->dropColumn('nepal_ri');
            $table->dropColumn('himalayan_ri');
            $table->dropColumn('retention');
            $table->dropColumn('quota');
            $table->dropColumn('surplus_i');
            $table->dropColumn('surplus_ii');
            $table->dropColumn('auto_fac');
            $table->dropColumn('facultative');
            $table->dropColumn('co_insurance');
            $table->dropColumn('xol_i');
            $table->dropColumn('xol_ii');
            $table->dropColumn('xol_iii');
            $table->dropColumn('xol_iiii');
            $table->dropColumn('pool');
            $table->dropColumn('excess');
        });
    }
};
