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
        Schema::create('playingsports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studentId')->constrained('students')->onDelete('restrict');
            $table->foreignId('sportId')->constrained('sports')->onDelete('restrict');
 
            $table->timestamps();
 
            $table->unique(['studentId', 'sportId']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playingsports');
    }
};
