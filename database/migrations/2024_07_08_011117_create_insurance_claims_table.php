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
        Schema::create('insurance_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members');
            $table->foreignId('heading_id')->constrained('insurance_headings');
            $table->foreignId('group_id')->nullable()->constrained('groups');
            $table->foreignId('sub_heading_id')->constrained('insurance_sub_headings');
            $table->foreignId('relative_id')->nullable()->constrained('member_relatives');
            $table->enum('claim_for', ['self', 'other'])->comment('self or other')->default('self');
            $table->enum('document_type', ['bill', 'prescription', 'report'])->comment('bill or prescription or report');
            $table->string('bill_file_name');
            $table->string('bill_file_size')->nullable();
            $table->string('file_path');
            $table->date('document_date')->nullable();
            $table->text('remark')->nullable();
            $table->string('bill_amount')->nullable();
            $table->string('clinical_facility_name');
            $table->string('diagnosis_treatment');
            $table->enum('claim_type', ['claim', 'draft'])->default('draft');
            $table->foreignId('register_no')->nullable()->constrained('claim_registers');
            $table->foreignId('scrutiny_id')->nullable()->constrained('scrunities');
            $table->string('status')->nullable();
            $table->string('claim_id')->nullable();
            $table->timestamps();
            $table->nullabledefaultinfos();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_claims');
    }
};
