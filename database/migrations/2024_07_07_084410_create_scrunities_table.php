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
        Schema::create('scrunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claim_no_id')->constrained('claim_registers');
            $table->foreignId('member_id')->constrained('members');
            $table->foreignId('member_policy_id')->constrained('member_policies');
            $table->foreignId('relative_id')->nullable()->constrained('member_relatives');
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
        Schema::dropIfExists('scrunities');
    }
};
