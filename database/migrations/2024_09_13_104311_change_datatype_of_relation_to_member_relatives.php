<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('member_relatives', function (Blueprint $table) {
        //     // $table->enum('rel_relation',['father','mother','monther-in-law','father-in-law','spouse','child1','child2'])->change();
        //      // Add the new enum type
        //      DB::statement("CREATE TYPE rel_relation_enum AS ENUM ('father', 'mother', 'mother-in-law', 'father-in-law', 'spouse', 'child1', 'child2')");

        //      // Change column using the new enum type
        //      DB::statement("ALTER TABLE member_relatives ALTER COLUMN rel_relation TYPE rel_relation_enum USING rel_relation::rel_relation_enum");
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_relatives', function (Blueprint $table) {
            //
        });
    }
};
