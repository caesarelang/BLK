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
        Schema::table('materi', function (Blueprint $table) {
            // Pastikan kolom yang diperlukan ada
            if (!Schema::hasColumn('materi', 'program_id')) {
                $table->unsignedBigInteger('program_id');
            }
            if (!Schema::hasColumn('materi', 'soal')) {
                $table->text('soal');
            }
            if (!Schema::hasColumn('materi', 'jawaban')) {
                $table->text('jawaban');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->dropColumn(['program_id', 'soal', 'jawaban']);
        });
    }
};
