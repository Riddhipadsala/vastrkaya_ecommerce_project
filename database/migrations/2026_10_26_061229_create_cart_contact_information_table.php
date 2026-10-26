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
        Schema::create('cart_contact_information', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('contact_number');
            $table->string('address_type_line_1');
            $table->text('address_type_line_2');
            $table->string('city');
            $table->string('state');
            $table->integer('pincode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_contact_information');
    }
};
