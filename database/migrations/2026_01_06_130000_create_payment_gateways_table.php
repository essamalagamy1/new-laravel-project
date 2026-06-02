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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Display name: Paymob, Fawry, PayPal
            $table->string('slug')->unique(); // paymob, fawry, paypal (used by factory)
            $table->json('credentials')->nullable(); // All gateway credentials as JSON
            $table->boolean('is_active')->default(false);
            $table->boolean('is_default')->default(false);
            //            $table->string('logo')->nullable();
            $table->string('currency')->default('EGP');
            $table->string('mode')->default('test'); // test or live
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
