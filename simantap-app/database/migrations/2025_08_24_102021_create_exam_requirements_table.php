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
        Schema::create('exam_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_type_id')->constrained()->onDelete('cascade');
            $table->string('document_name'); // Nama dokumen yang dibutuhkan
            $table->text('description')->nullable(); // Deskripsi dokumen
            $table->boolean('is_required')->default(true); // Apakah dokumen wajib
            $table->string('file_types')->nullable(); // Tipe file yang diperbolehkan (pdf, doc, dll)
            $table->integer('max_size')->nullable(); // Ukuran maksimal file dalam KB
            $table->integer('order')->default(0); // Urutan dokumen
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_requirements');
    }
};
