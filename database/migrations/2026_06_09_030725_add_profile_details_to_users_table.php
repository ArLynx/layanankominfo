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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik')->nullable()->after('password');
            $table->string('instansi')->nullable()->after('nik');
            $table->string('no_hp_wa')->nullable()->after('instansi');
            $table->string('status_pegawai')->nullable()->after('no_hp_wa');
            $table->string('kartu_pegawai')->nullable()->after('status_pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'instansi', 'no_hp_wa', 'status_pegawai', 'kartu_pegawai']);
        });
    }
};
