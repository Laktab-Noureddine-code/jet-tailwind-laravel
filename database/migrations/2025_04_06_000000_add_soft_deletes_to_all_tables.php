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
        // Tables qui nécessitent soft deletes
        $tables = [
            'affectations',
            'imprimantes',
            'notifications',
            'ordinateurs',
            'recrutements',
            'telephones',
            'utilisateurs',
            'materiels'
        ];

        foreach ($tables as $table) {
            if (!Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->softDeletes();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'affectations',
            'imprimantes',
            'notifications',
            'ordinateurs',
            'recrutements',
            'telephones',
            'utilisateurs',
            'materiels'
        ];

        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropSoftDeletes();
                });
            }
        }
    }
};
