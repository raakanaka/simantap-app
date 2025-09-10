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
        Schema::create('formulir_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('submission_id');
            $table->string('student_nim');
            $table->string('student_name');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->string('semester');
            $table->string('study_program');
            $table->string('phone_number');
            $table->string('thesis_title');
            $table->string('supervisor');
            $table->json('document_status'); // Status upload untuk setiap dokumen
            $table->string('status')->default('pending'); // pending, generated, downloaded
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulir_pendaftarans');
    }
};
