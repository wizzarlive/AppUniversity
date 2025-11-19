<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->decimal('grade', 4, 2)->nullable();
            $table->string('status', 20)->default('pendiente');
            $table->date('registration_date');

            $table->unsignedBigInteger('fk_student');
            $table->unsignedBigInteger('fk_course');
            $table->timestamps();

            $table->foreign('fk_student')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('fk_course')->references('id')->on('courses')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
