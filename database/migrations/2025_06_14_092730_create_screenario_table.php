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
        //Kịch bản ứng phó
        Schema::create('scenarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_of_calamity_id');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->string('name');
            $table->text('short_description')->nullable();
            $table->date('updated_time')->nullable();
            $table->string('status')->nullable();
            $table->longText('document_path')->nullable();
            $table->longText('document_text')->nullable();
            $table->timestamps();

            $table->foreign('type_of_calamity_id')->references('id')->on('type_of_calamities')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scenarios');
    }
};
