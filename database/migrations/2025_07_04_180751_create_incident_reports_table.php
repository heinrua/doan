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
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->id();
            $table->string('reporter_name');                
            $table->string('contact_number')->nullable();   
            $table->string('coordinates');                     
            $table->text('description')->nullable();        
            $table->string('attachment')->nullable();       
            $table->timestamps();  

            $table->foreignId('commune_id')->constrained('communes')->onDelete('cascade');
            $table->foreignId('sub_type_of_calamity_id')->constrained('sub_type_of_calamities')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_reports');
    }
};
