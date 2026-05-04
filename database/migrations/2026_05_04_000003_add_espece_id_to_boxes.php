<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boxes', function (Blueprint $table) {
            $table->unsignedBigInteger('espece_id')->nullable()->after('pension_id');
            $table->foreign('espece_id')->references('id')->on('especes')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('boxes', function (Blueprint $table) {
            $table->dropForeign(['espece_id']);
            $table->dropColumn('espece_id');
        });
    }
};
