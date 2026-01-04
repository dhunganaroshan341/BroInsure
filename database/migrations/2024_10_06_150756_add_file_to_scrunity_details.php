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
        Schema::table('scrunity_details', function (Blueprint $table) {
            if (!Schema::hasColumn('scrunity_details', 'file')) {
                $table->string('file')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scrunity_details', function (Blueprint $table) {
            if (Schema::hasColumn('scrunity_details', 'file')) {
                $table->dropColumn('file');
            }
        });
    }
};
