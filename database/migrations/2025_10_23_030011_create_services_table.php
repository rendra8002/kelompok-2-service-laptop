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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice')->unique()->nullable();

            // 🔹 Relasi ke tabel users & laptops
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('technician_id');
            $table->unsignedBigInteger('laptop_id');

            // 🔹 Deskripsi dan status service
            $table->string('damage_description');
            $table->enum('status', ['accepted', 'process', 'finished', 'taken', 'canceled'])
                ->default('accepted');

            // 🔹 Biaya & pembayaran
            $table->bigInteger('other_cost')->default(0);
            $table->bigInteger('total_cost')->default(0);
            $table->bigInteger('paid')->default(0);
            $table->bigInteger('change')->default(0);

            // 🔹 Status pembayaran & metode
            $table->enum('status_paid', ['unpaid', 'debt', 'paid'])->default('unpaid');
            $table->enum('paymentmethod', ['cash', 'transfer'])->nullable();

            $table->timestamps();

            // 🔹 Foreign key
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('technician_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('laptop_id')->references('id')->on('laptops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
