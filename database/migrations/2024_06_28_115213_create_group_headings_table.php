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
        Schema::create('group_headings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups');
            $table->foreignId('heading_id')->constrained('insurance_headings');
            $table->string('is_employee',1)->default('N');
            $table->string('is_spouse',1)->default('N');
            $table->string('is_child',1)->default('N');
            $table->string('is_parent',1)->default('N');
            $table->string('amount');
            $table->string('is_spouse_amount')->nullable();
            $table->string('is_child_amount')->nullable();
            $table->string('is_parent_amount')->nullable();
            $table->json('exclusive')->nullable();
            $table->json('rules')->nullable();
            $table->timestamps();
            $table->userinfos();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_headings');
    }
};
