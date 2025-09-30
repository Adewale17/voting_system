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
            $table->foreignId('election_id')
                ->constrained('elections')
                ->onDelete('cascade')
                ->after('student_id');

            $table->unique(['student_id', 'election_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropForeign(['election_id']);
            $table->dropColumn('election_id');

            $table->dropUnique(['student_id', 'election_id']);
        });
    }
};
