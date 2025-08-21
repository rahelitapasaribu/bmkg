<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::create('satker', function (Blueprint $table) {
        $table->id(); // kolom id (primary key, auto increment)
        $table->unsignedBigInteger('id_provinsi'); // kolom id_provinsi
        $table->string('nama_satker'); // kolom nama_satker
        $table->decimal('latitude', 10, 7)->nullable();  // contoh: -7.2504450
        $table->decimal('longitude', 10, 7)->nullable(); // contoh: 112.7688450
        $table->timestamps(); // created_at & updated_at
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satker');
    }
};
