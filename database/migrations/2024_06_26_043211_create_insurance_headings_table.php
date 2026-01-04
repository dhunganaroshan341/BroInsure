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
        Schema::create('insurance_headings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status',1)->default('Y');
            $table->string('code')->nullable();
            $table->timestamps();
            $table->nullabledefaultinfos();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_headings');
    }
};
