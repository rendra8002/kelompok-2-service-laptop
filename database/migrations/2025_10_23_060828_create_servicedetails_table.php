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
        Schema::create('servicedetails', function (Blueprint $table) {
            $table->id();

            // relasi ke tabel services
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');

            // relasi ke tabel service_items
            $table->unsignedBigInteger('service_type_id');
            $table->foreign('service_type_id')
                ->references('id')
                ->on('serviceitems')
                ->onDelete('cascade');

            // harga layanan saat transaksi (bisa berbeda dari harga di master)
            $table->integer('price')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicedetails');
    }
};
