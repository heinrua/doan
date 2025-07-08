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
        Schema::create('calamities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_of_calamity_id'); // loaị thiên tai
            $table->unsignedBigInteger('risk_level_id'); // cấp độ thiên tai
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('address')->nullable();
            $table->text('length')->nullable();
            $table->text('width')->nullable();
            $table->text('acreage')->nullable();
            $table->text('coordinates')->nullable();
            $table->longText('map')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->date('time')->nullable();
            $table->text('reason')->nullable();
            $table->text('geology')->nullable();
            $table->text('watermark_points')->nullable();
            $table->text('human_damage')->nullable();
            $table->text('property_damage')->nullable();
            $table->text('investment_level')->nullable();
            $table->text('mitigation_measures')->nullable();
            $table->text('support_policy')->nullable();
            $table->text('flood_level')->nullable();
            $table->text('flooded_area')->nullable();
            $table->text('flood_range')->nullable();
            $table->date('time_start')->nullable();
            $table->date('time_end')->nullable();
            $table->text('sprint_time')->nullable();
            $table->text('number_of_people_affected')->nullable();
            $table->text('damaged_infrastructure')->nullable();
            $table->text('data_source')->nullable();

            $table->timestamps();

           
            $table->foreign('risk_level_id')->references('id')->on('risk_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calamities');
    }
};
