<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('laptops', function (Blueprint $table) {
            $table->softDeletes(); // otomatis membuat kolom deleted_at
        });
    }

    public function down()
    {
        Schema::table('laptops', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
