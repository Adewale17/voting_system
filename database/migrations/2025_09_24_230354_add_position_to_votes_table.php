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
        Schema::table('votes', function (Blueprint $table) {
            $table->string('position')->after('election_id'); // add position column
            $table->unique(['student_id', 'election_id', 'position']); // ensure one vote per position per election
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropUnique(['student_id', 'election_id', 'position']);
            $table->dropColumn('position');
        });
    }
};
