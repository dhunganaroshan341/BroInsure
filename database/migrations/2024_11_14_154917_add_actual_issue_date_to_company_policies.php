<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('company_policies', function (Blueprint $table) {
            if (!Schema::hasColumn('company_policies', 'actual_issue_date')) {
                $table->date('actual_issue_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_policies', function (Blueprint $table) {
            if (!Schema::hasColumn('company_policies', 'actual_issue_date')) {
                $table->dropColumn('actual_issue_date');
            }
        });
    }
};
