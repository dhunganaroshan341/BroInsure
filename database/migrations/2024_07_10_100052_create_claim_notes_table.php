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
        Schema::create('claim_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claim_no_id')->constrained('claim_registers');
            $table->foreignId('client_id')->nullable()->constrained('clients');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->nullabledefaultinfos();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claim_notes');
    }
};
