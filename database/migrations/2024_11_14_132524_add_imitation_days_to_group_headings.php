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
        Schema::table('group_headings', function (Blueprint $table) {
            if (!Schema::hasColumn('group_headings', 'imitation_days')) {
                $table->string('imitation_days')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_headings', function (Blueprint $table) {
            if (!Schema::hasColumn('group_headings', 'imitation_days')) {
                $table->dropColumn('imitation_days');
            }
        });
    }
};
