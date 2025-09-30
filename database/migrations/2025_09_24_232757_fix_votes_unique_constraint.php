<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            // Drop the old unique (student_id, election_id)
            $table->dropUnique('votes_student_id_election_id_unique');

            // Add new unique (student_id, election_id, position)
            $table->unique(['student_id', 'election_id', 'position'], 'unique_vote_per_position');
        });
    }

    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            // Rollback: drop the new unique
            $table->dropUnique('unique_vote_per_position');

            // Restore the old one
            $table->unique(['student_id', 'election_id']);
        });
    }
};
