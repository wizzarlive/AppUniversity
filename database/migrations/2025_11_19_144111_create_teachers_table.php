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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id(); // ID (Primary Key)
            $table->string('dni', 15)->unique(); // DNI (Único)
            $table->string('name', 100); // NAME
            $table->string('phone', 15)->nullable(); // PHONE (opcional)
            $table->string('email', 100)->unique(); // EMAIL (Único)
            $table->string('status', 20)->default('activo'); // STATUS
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
