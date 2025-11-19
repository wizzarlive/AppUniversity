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
        Schema::create('tuitions', function (Blueprint $table) {
            $table->id();
            $table->string('period', 50);
            $table->string('status', 20);
            $table->date('registration_date');

            $table->unsignedBigInteger('fk_student');
            $table->unsignedBigInteger('fk_teacher_processed')->nullable();
            $table->timestamps();

            $table->foreign('fk_student')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('fk_teacher_processed')->references('id')->on('teachers')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuitions');
    }
};
