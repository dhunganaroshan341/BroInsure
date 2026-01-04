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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('mobile')->nullable();
            $table->string('land_line')->nullable();
            $table->foreignId('province_id')->nullable()->constrained('states', 'id');
            $table->foreignId('district_id')->nullable()->constrained('districts', 'id');
            $table->foreignId('city_id')->nullable()->constrained('vdcmcpts', 'id');
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_person_contact')->nullable();
            $table->text('extra')->nullable();
            $table->timestamps();
            $table->nullabledefaultinfos();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
