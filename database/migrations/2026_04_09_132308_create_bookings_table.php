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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->unique();
            $table->enum('status', ['pending', 'paid', 'used', 'cancelled'])->default('pending');
            $table->decimal('price', 10, 2);
            $table->string('proof_of_payment');
            $table->timestamp('check_in_at')->nullable();
            $table->foreignId('ticket_package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
