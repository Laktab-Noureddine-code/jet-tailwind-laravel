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
        Schema::table('affectations', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('imprimantes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('materiels', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('ordinateurs', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('recrutements', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('telephones', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('affectations', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('imprimantes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('materiels', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('ordinateurs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('recrutements', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('telephones', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
