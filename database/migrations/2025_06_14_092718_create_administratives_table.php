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
        Schema::create('administratives', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('type', ['school', 'medical', 'center']);
            $table->string('code')->nullable();
            $table->string('address')->nullable();
            $table->string('option')->nullable();
            $table->string('classify')->nullable();
            $table->string('coordinates')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('population');
            $table->unsignedBigInteger('commune_id')->nullable();
            $table->timestamps();
            $table->foreign('commune_id')->references('id')->on('communes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administratives');
    }
};
