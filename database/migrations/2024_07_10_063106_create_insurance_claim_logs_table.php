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
        Schema::create('insurance_claim_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_claim_id')->constrained('insurance_claims');
            $table->foreignId('audit_id')->nullable()->constrained('audits');
            $table->string('type')->nullable();
            $table->text('remarks')->nullable();
            $table->json('description')->nullable();
            $table->timestamps();
            $table->nullabledefaultinfos();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_claim_logs');
    }
};
