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
        Schema::create('vdcmcpts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 90);
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->boolean('is_default')->default(0);
            $table->nullabledefaultinfos();
            $table->timestamps();
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vdcmcpts');
    }
};
