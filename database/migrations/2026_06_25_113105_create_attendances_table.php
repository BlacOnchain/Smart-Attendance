<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The student
            $table->foreignId('attendance_session_id')->constrained()->onDelete('cascade'); // The class session
            $table->timestamp('scanned_at');
            $table->timestamps();
            
            // Prevents a student from scanning into the same session twice
            $table->unique(['user_id', 'attendance_session_id']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};