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
        Schema::create('hero_banners', function (Blueprint $table) {
            $table->id();

            // 小字：比如 "New • Laravel + Filament Ecommerce"
            $table->string('eyebrow')->nullable();

            // 大标题
            $table->string('title');

            // 副标题 / 说明
            $table->text('subtitle')->nullable();

            // 图片路径（存 public disk）
            $table->string('image_path')->nullable();

            // 主按钮
            $table->string('primary_button_label')->nullable();
            $table->string('primary_button_url')->nullable();

            // 副按钮
            $table->string('secondary_button_label')->nullable();
            $table->string('secondary_button_url')->nullable();

            // 是否启用
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_banners');
    }
};
