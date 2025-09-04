<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id');
            $table->year('year');
            $table->unsignedTinyInteger('month'); // angka 1-12
            $table->decimal('percentage', 5, 2)->nullable();
            $table->timestamps();

            $table->unique(['site_id', 'year', 'month']); // biar ga duplicate
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance');
    }
};
