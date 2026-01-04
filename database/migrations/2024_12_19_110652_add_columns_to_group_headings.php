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
        Schema::table('group_headings', function (Blueprint $table) {
           $table->string('limit_type')->comment('limit check for retail')->nullable();
           $table->string('limit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_headings', function (Blueprint $table) {
            $table->dropColumn('limit_type');
            $table->dropColumn('limit');
        });
    }
};
