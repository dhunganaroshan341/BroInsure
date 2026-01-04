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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobilenumber');
            $table->string('countrycode')->default('977');
            $table->foreignId('usertype')->constrained('usertype');
            $table->string('profile_pic')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('default_password')->nullable();
            $table->char('is_active',1)->default('Y');
            $table->rememberToken();
            $table->index(['usertype','fname']);
            $table->timestamps();
            $table->nullabledefaultinfos();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
