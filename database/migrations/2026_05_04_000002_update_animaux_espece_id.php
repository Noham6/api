<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter espece_id (FK vers especes)
        Schema::table('animaux', function (Blueprint $table) {
            $table->unsignedBigInteger('espece_id')->nullable()->after('nom');
            $table->foreign('espece_id')->references('id')->on('especes')->onDelete('set null');
        });

        // Migrer les données existantes (espece string → espece_id)
        $especes = DB::table('especes')->pluck('id', 'libelle');
        $animaux = DB::table('animaux')->get();
        foreach ($animaux as $animal) {
            $libelle  = ucfirst(strtolower($animal->espece ?? ''));
            $especeId = $especes[$libelle] ?? null;
            DB::table('animaux')->where('id', $animal->id)->update(['espece_id' => $especeId]);
        }

        // Supprimer l'ancienne colonne string
        Schema::table('animaux', function (Blueprint $table) {
            $table->dropColumn('espece');
        });
    }

    public function down(): void
    {
        Schema::table('animaux', function (Blueprint $table) {
            $table->string('espece')->nullable();
        });
        Schema::table('animaux', function (Blueprint $table) {
            $table->dropForeign(['espece_id']);
            $table->dropColumn('espece_id');
        });
    }
};
