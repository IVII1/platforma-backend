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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('year', [1, 2, 3]);
            $table->enum('semester', ['winter', 'spring']);
            $table->enum('studies_type', ['bachelors', 'masters']);
            $table->foreignId('teacher_id')->constrained('users');
            $table->foreignId('teaching_assistant_id');
            $table->foreignId('prerequisite_subject_id')->nullable();
            $table->longText('description');
            $table->string('grading_guide_file_path');
            $table->string('curriculum_overview_file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
