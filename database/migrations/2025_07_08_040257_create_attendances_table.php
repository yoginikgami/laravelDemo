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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
             $table->foreignId('student_id')
                  ->constrained('students')
                  ->onDelete('cascade');

            $table->foreignId('class_id')
                  ->constrained('school_classes');

            $table->foreignId('subject_id')
                  ->nullable()
                  ->constrained('subjects');

            $table->date('date');

            $table->enum('status', ['Present', 'Absent', 'Leave']);

            $table->string('remarks', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
