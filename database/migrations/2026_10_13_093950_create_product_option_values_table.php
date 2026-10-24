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
        Schema::create('product_option_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
            $table->foreignId('product_option_id')->constrained('product_options')->onDelete('cascade');
            $table->foreignId('option_value_id')->constrained('option_values')->onDelete('cascade');
            $table->tinyInteger('status')->default(1)->comment('0 for inactive, 1 for active');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_option_values');
    }
};
