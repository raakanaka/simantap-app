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
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nip')->unique();
            $table->string('study_program');
            $table->string('faculty');
            $table->string('position')->default('Dosen'); // Dosen, Ketua Program Studi, Dekan, dll
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
