<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambahkan kolom last_login_at
        Schema::table('users', function (Blueprint $table) {
            // $table->timestamp('last_login_at')->nullable()->after('updated_at');
        });

        // Insert user dummy
        DB::table('users')->insert([
            'photo' => 'admin-df/santoso-dia-chan.jpeg',
            'name' => 'Satono Diamond',
            'address' => 'Satono',
            'phone_number' => '23221',
            'email' => 'satono@gmail.com',
            'password' => Hash::make('wleee'), // password default
            'role' => 'admin',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_login_at');
        });

        // Hapus dummy user
        DB::table('users')->where('email', 'admin@example.com')->delete();
    }
};
