<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mensajes', function (Blueprint $table) {
            $table->foreignId('conversacion_id')
                ->after('id')
                ->constrained('conversaciones')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('mensajes', function (Blueprint $table) {
            $table->dropForeign(['conversacion_id']);
            $table->dropColumn('conversacion_id');
        });
    }
};