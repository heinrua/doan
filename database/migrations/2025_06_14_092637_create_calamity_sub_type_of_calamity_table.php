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
        Schema::create('calamity_sub_type_of_calamity', function (Blueprint $table) {
            $table->foreignId('calamity_id')->constrained('calamities')->onDelete('cascade');
            $table->foreignId('sub_type_of_calamity_id')->constrained('sub_type_of_calamities')->onDelete('cascade');
            $table->primary(['calamity_id', 'sub_type_of_calamity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calamity_sub_type_of_calamity');
    }
};
