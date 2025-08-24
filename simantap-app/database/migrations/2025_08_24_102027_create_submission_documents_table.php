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
        Schema::create('submission_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_submission_id')->constrained()->onDelete('cascade');
            $table->foreignId('exam_requirement_id')->constrained()->onDelete('cascade');
            $table->string('document_name'); // Nama dokumen
            $table->string('file_path'); // Path file yang diupload
            $table->string('file_name'); // Nama asli file
            $table->string('file_type'); // Tipe file
            $table->integer('file_size'); // Ukuran file dalam bytes
            $table->enum('status', ['uploaded', 'verified', 'rejected'])->default('uploaded');
            $table->text('rejection_reason')->nullable(); // Alasan penolakan jika ditolak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_documents');
    }
};
