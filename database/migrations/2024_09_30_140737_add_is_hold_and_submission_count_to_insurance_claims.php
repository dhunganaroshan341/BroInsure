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
        Schema::table('insurance_claims', function (Blueprint $table) {
            if (!Schema::hasColumn('insurance_claims', 'submission_count')) {
                $table->integer('submission_count')->default(1);
            }
            if (!Schema::hasColumn('insurance_claims', 'is_hold')) {
                $table->string('is_hold')->default('N');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance_claims', function (Blueprint $table) {
            if (Schema::hasColumn('insurance_claims', 'submission_count')) {
                $table->dropColumn('submission_count');
            }
            if (Schema::hasColumn('insurance_claims', 'is_hold')) {
                $table->dropColumn('is_hold');
            }
        });
    }
};
