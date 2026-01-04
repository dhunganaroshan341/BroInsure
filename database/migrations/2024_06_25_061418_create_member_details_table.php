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
        Schema::create('member_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');            
            $table->string('citizenship_no');
            $table->string('citizenship_district');
            $table->date('citizenship_issued_date');
            $table->string('idcard_no')->nullable();
            $table->string('idcard_issuing_authority')->nullable();
            $table->date('idcard_issuedate')->nullable();
            $table->date('idcard_valid_till')->nullable();
            $table->string('income_source')->nullable();
            $table->string('occupation')->nullable();
            $table->string('occupation_other')->nullable();
            $table->timestamps();
            $table->nullabledefaultinfos();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_details');
    }
};
