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
        Schema::create('constructions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_of_calamity_id');
            $table->unsignedBigInteger('type_of_construction_id');
            $table->unsignedBigInteger('risk_level_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('construction_code')->nullable();
            $table->text('address')->nullable();
            $table->date('construction_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->text('year_of_construction')->nullable();
            $table->text('year_of_completion')->nullable();
            $table->text('length')->nullable();
            $table->text('width')->nullable();
            $table->text('scale')->nullable();
            $table->text('characteristic')->nullable();
            $table->text('total_investment')->nullable();
            $table->text('main_function')->nullable();
            $table->date('update_time')->nullable();
            $table->text('influence_level')->nullable();
            $table->text('efficiency_level')->nullable();
            $table->text('capital_source')->nullable();
            $table->text('progress')->nullable();
            $table->text('size')->nullable();
            $table->text('status')->nullable();
            $table->text('operating_status')->nullable();
            $table->text('contractor')->nullable();
            $table->text('coordinates')->nullable();
            $table->text('width_of_door')->nullable();
            $table->text('base_level')->nullable();
            $table->text('pillar_top_level')->nullable();
            $table->text('total_door_width')->nullable();
            $table->text('notes')->nullable();
            $table->text('operation_method')->nullable();
            $table->text('irrigation_system')->nullable();
            $table->text('irrigation_area')->nullable();
            $table->text('culver_type')->nullable();
            $table->text('culver_code')->nullable();
            $table->text('management_unit')->nullable();

            $table->longText('map')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->timestamps();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreign('type_of_calamity_id')->references('id')->on('type_of_calamities')->onDelete('cascade');
            $table->foreign('type_of_construction_id')->references('id')->on('type_of_constructions')->onDelete('cascade');
            $table->foreign('risk_level_id')->references('id')->on('risk_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constructions');
    }
};
