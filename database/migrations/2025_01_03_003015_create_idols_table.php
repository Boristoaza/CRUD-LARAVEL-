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
        Schema::create('idols', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 40);
            $table->tinyInteger('edad');
            $table->text('datos_curiosos')->nullable();
            $table->string('actividad', 240);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idols');
    }
};
