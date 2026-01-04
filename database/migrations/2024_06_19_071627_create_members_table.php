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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('date_of_birth_bs')->nullable();
            $table->date('date_of_birth_ad')->nullable();
            $table->string('marital_status')->default('married');
            $table->string('gender')->default('male');
            $table->foreignId('perm_province')->nullable()->constrained('states', 'id');
            $table->foreignId('perm_district')->nullable()->constrained('districts', 'id');
            $table->foreignId('perm_city')->nullable()->constrained('vdcmcpts', 'id');
            $table->integer('perm_ward_no')->nullable();
            $table->string('perm_street')->nullable();
            $table->string('perm_house_no')->nullable();
            $table->string('is_address_same')->nullable();
            $table->foreignId('present_province')->nullable()->constrained('states', 'id');
            $table->foreignId('present_district')->nullable()->constrained('districts', 'id');
            $table->string('present_city')->nullable()->constrained('vdcmcpts', 'id');
            $table->integer('present_ward_no')->nullable();
            $table->string('present_street')->nullable();
            $table->string('present_house_no')->nullable();
            $table->string('mail_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('branch')->nullable();
            $table->string('designation')->nullable();
            $table->date('date_of_join')->nullable();
            $table->bigInteger('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->string('nationality');
            $table->char('is_active', 1)->default('Y');
            $table->timestamps();
            $table->nullabledefaultinfos();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
