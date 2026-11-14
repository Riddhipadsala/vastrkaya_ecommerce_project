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
        Schema::table('cart_contact_information', function (Blueprint $table) {
            $table->tinyInteger('is_selected')->default(0)->after('pincode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_contact_information', function (Blueprint $table) {
            $table->dropColumn('is_selected');
        });
    }
};
