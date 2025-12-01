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
            $table->string('diakNev');
            //dzsingiszkan hatalmas birodalma ._.
            $table->foreignId('schoolclassId')->constrained('schoolclasses')->onDelete('restrict');
            //erre kellene megirni hibakodot :)
            $table->boolean('neme')->default(true);
            $table->string('iranyitoszam')->nullable();
            $table->string('lakHelyseg')->nullable();
            $table->string('lakCim')->nullable();
            $table->string('szulHelyseg')->nullable();
            $table->date('szulDatum')->nullable();
            $table->string('igazolvanyszam')->nullable();
            $table->unique('igazolvanyszam');
            $table->decimal('atlag', 2, 1)->nullable();
            $table->decimal('osztondij', 10, 0)->nullable();
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
