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
        Schema::table('imprimantes', function (Blueprint $table) {
            $table->string('ip_adresse')->nullable()->after('toner_jaune');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('imprimantes', function (Blueprint $table) {
            $table->dropColumn('ip_adresse');
        });
    }
};
