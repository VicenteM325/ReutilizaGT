<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::table('mensajes', function (Blueprint $table) {
        // Primero elimina la clave y la columna producto_id
        if (Schema::hasColumn('mensajes', 'producto_id')) {
            $table->dropForeign(['producto_id']);
            $table->dropColumn('producto_id');
        }
    });

    Schema::table('mensajes', function (Blueprint $table) {
        // Luego agrega la nueva columna con relación
        if (!Schema::hasColumn('mensajes', 'conversacion_id')) {
            $table->foreignId('conversacion_id')->after('id')->constrained('conversaciones')->cascadeOnDelete();
        }
    });
}

};
