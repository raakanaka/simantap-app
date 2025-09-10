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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('submission_number')->unique();
            $table->string('student_nim');
            $table->string('student_name');
            $table->string('student_study_program');
            $table->foreignId('exam_type_id')->constrained('exam_types');
            $table->string('exam_type_name');
            $table->enum('status', ['menunggu_verifikasi', 'berkas_diterima', 'berkas_ditolak'])->default('menunggu_verifikasi');
            $table->timestamp('submitted_at');
            $table->text('revision_reason')->nullable();
            $table->string('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
