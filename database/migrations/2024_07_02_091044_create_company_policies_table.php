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
        Schema::create('company_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients');
            $table->string('policy_no');
            $table->date('issue_date');
            $table->date('valid_date');
            $table->string('imitation_days');
            $table->string('member_no');
            $table->string('issued_at')->nullable();
            $table->string('f_o_agent')->nullable();
            $table->string('receipt_no')->nullable();
            $table->string('vat_bill_no')->nullable();
            $table->string('sum_insured')->nullable();
            $table->string('premium')->nullable();
            $table->string('issued_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('excess_type')->default('fix');
            $table->string('excess_amount')->default('fix');
            $table->timestamps();
            $table->nullabledefaultinfos();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_policies');
    }
};
