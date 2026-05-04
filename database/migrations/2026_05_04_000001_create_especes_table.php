<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('especes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');                          // ex: Chien, Chat, Tortue
            $table->float('temperature_min')->nullable();       // °C
            $table->float('temperature_max')->nullable();       // °C
            $table->float('humidite_min')->nullable();          // %
            $table->float('humidite_max')->nullable();          // %
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insérer les espèces de base
        DB::table('especes')->insert([
            ['libelle' => 'Chien',   'temperature_min' => 15, 'temperature_max' => 25, 'humidite_min' => 40, 'humidite_max' => 70, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Chat',    'temperature_min' => 18, 'temperature_max' => 26, 'humidite_min' => 40, 'humidite_max' => 60, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['libelle' => 'Tortue',  'temperature_min' => 22, 'temperature_max' => 30, 'humidite_min' => 60, 'humidite_max' => 80, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('especes');
    }
};
