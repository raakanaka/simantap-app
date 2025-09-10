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
            $table->foreignId('submission_id')->constrained('submissions')->onDelete('cascade');
            $table->foreignId('requirement_id')->constrained('exam_requirements');
            $table->string('original_filename');
            $table->string('stored_filename');
            $table->string('file_path');
            $table->integer('file_size'); // in bytes
            $table->string('mime_type');
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
