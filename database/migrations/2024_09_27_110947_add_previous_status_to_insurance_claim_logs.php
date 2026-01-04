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
        Schema::table('insurance_claim_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('insurance_claim_logs', 'previous_status')) {
                $table->string('previous_status')->nullable();
            }
            if (!Schema::hasColumn('insurance_claim_logs', 'new_status')) {
                $table->string('new_status')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance_claim_logs', function (Blueprint $table) {
            if (Schema::hasColumn('insurance_claim_logs', 'previous_status')) {
                $table->dropColumn('previous_status');
            }
            if (Schema::hasColumn('insurance_claim_logs', 'new_status')) {
                $table->dropColumn('new_status');
            }
        });
    }
};
