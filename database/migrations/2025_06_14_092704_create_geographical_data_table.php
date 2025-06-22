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
        Schema::create('geographical_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_of_calamity_id');
            $table->unsignedBigInteger('commune_id');
            $table->string('type'); // Phân biệt loại dữ liệu
            $table->string('name')->nullable(); // Tên khu vực/đoạn đường/mặt cắt/mốc quan trắc

            $table->string('category')->nullable(); // Phân loại xói bồi (cho khu vực xói bồi)
            $table->string('progress')->nullable(); // Tiến độ thực hiện
            $table->integer('start_year')->nullable(); // Năm bắt đầu
            $table->integer('end_year')->nullable(); // Năm hoàn thành
            $table->decimal('area', 10, 2)->nullable(); // Diện tích (ha)
            $table->string('scale')->nullable(); // Quy mô ảnh hưởng
            $table->string('impact_level')->nullable(); // Mức độ ảnh hưởng
            $table->string('coordinates')->nullable(); // Tọa độ (mảng JSON)
            $table->string('total_investment')->nullable(); // Tổng mức đầu tư
            $table->string('funding_source')->nullable(); // Nguồn vốn

            $table->decimal('length', 10, 2)->nullable(); // Chiều dài (km) (cho đường bờ)
            $table->decimal('width', 10, 2)->nullable(); // Chiều rộng (m)
            $table->string('start_coordinates')->nullable(); // Tọa độ bắt đầu
            $table->string('end_coordinates')->nullable(); // Tọa độ kết thúc

            $table->integer('survey_year')->nullable(); // Năm khảo sát
            $table->string('reference_number')->nullable(); // Số hiệu mặt cắt
            $table->date('last_updated')->nullable(); // Thời gian cập nhật

            $table->string('monitoring_position')->nullable(); // Vị trí quan trắc
            $table->string('river')->nullable(); // Thuộc sông
            $table->decimal('elevation_z', 10, 2)->nullable(); // Cao trình Z
            $table->bigInteger('population'); // sức chứa người dân tại 1 địa điểm
            $table->text('description')->nullable(); // Mô tả chung
            $table->json('map')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();

            $table->timestamps();
           
            $table->foreign('type_of_calamity_id')->references('id')->on('type_of_calamities')->onDelete('cascade');
            $table->foreign('commune_id')->references('id')->on('communes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geographical_data');
    }
};
