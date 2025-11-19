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
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // ID (Primary Key)
            $table->string('dni', 15)->unique(); // DNI
            $table->string('name', 100); // NAME
            $table->string('phone', 15)->nullable(); // PHONE
            $table->unsignedSmallInteger('ciclo')->nullable(); // CICLO (usamos smallint para números pequeños)
            $table->string('email', 100)->unique(); // EMAIL (Único)
            $table->string('status', 20)->default('activo'); // STATUS
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
