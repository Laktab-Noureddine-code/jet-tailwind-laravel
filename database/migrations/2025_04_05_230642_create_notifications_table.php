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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recrutement_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('is_read')->default(false);
            $table->string('type')->nullable(); // materiel
            $table->string('etat')->nullable(); // materiel
            $table->date('date_affectation')->nullable(); // affectation
            $table->string('chantier')->nullable(); // affectation
            $table->string('utilisateur')->nullable(); // affectation
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
