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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('class_id')
                  ->constrained('school_classes');

            $table->string('roll_no', 20);
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('dob');
            $table->string('photo', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('contact_no', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
