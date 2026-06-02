<?php

use App\Enums\Status;
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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedInteger('usage_count')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('type', ['fixed', 'percent'])->default('fixed');
            $table->decimal('value', 8, 2);
            $table->decimal('min_order_value', 8, 2);
            $table->decimal('max_discount', 8, 2);
            $table->integer('usage_limit')->nullable();
            $table->date('expiry_date');
            $table->string('status')->default(Status::Inactive);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
