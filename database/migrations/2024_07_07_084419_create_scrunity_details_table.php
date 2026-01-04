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
        Schema::create('scrunity_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scrunity_id')->constrained('scrunities')->onDelete('cascade');
            $table->foreignId('group_heading_id')->constrained('group_headings')->onDelete('cascade');
            $table->foreignId('heading_id')->constrained('insurance_headings')->onDelete('cascade');
            $table->string('bill_amount');
            $table->string('approved_amount');
            $table->string('deduct_amount')->nullable();
            $table->string('bill_no');
            $table->string('file')->nullable();
            $table->text('remarks')->nullable();
            $table->json('extra')->nullable();
            $table->timestamps();
            $table->userinfos();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrunity_details');
    }
};
