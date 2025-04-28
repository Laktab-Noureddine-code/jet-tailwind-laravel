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
        Schema::create('recrutements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('fonction');
            $table->string('departement');
            $table->string('date_affectation');
            $table->string('email');
            $table->string('type_contrat');
            $table->string('telephone');
            $table->string('model')->nullable();
            $table->string('num_serie')->unique()->nullable();
            $table->string('puk')->nullable();
            $table->string('pin')->nullable();
            $table->string('status')->default('en attente')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recrutements');
    }
};
