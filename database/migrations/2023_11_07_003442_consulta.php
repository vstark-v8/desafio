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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->string('codigo_os')->unique();
            $table->foreignId('consultor_id');
        });

        Schema::create('consultas_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mecanico_id');
            $table->foreignId('produto_id');
            $table->integer('quantidade');
            $table->float('valor', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
