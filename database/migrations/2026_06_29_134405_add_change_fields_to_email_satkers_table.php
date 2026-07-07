<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('email_satkers', function (Blueprint $table) {
            // untuk ubah penanggung
            $table->string('nama_penanggung_jawab_baru')->nullable()->after('no_hp');
            $table->string('nip_baru')->nullable()->after('nama_penanggung_jawab_baru');
            $table->string('jabatan_baru')->nullable()->after('nip_baru');
            $table->string('pangkat_gol_baru')->nullable()->after('jabatan_baru');
            $table->string('email_baru')->nullable()->after('pangkat_gol_baru');
            $table->string('no_hp_baru')->nullable()->after('email_baru');

            // untuk ubah nama akun
            $table->string('nama_akun_dinas_baru')->nullable()->after('nama_akun_dinas');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_satkers', function (Blueprint $table) {
            $table->dropColumn(['nama_penanggung_jawab_baru', 'nip_baru', 'jabatan_baru', 'pangkat_gol_baru', 'email_baru', 'no_hp_baru', 'nama_akun_dinas_baru']);
        });
    }
};
