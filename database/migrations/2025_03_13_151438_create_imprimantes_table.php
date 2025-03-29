<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImprimantesTable extends Migration
{
    public function up()
    {
        Schema::create('imprimantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materiel_id')->constrained('materiels')->onDelete('cascade');
            $table->string("identifiant_noir")->nullable();
            $table->string("identifiant_bleu")->nullable();
            $table->string("identifiant_magenta")->nullable();
            $table->string("identifiant_jaune")->nullable();
            $table->integer('toner_noir')->nullable()->default(0);
            $table->integer('toner_bleu')->nullable()->default(0);
            $table->integer('toner_magenta')->nullable()->default(0);
            $table->integer('toner_jaune')->nullable()->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imprimantes');
    }
}
