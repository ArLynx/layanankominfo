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
        Schema::create('email_pribadis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('nama');
            $table->string('nip');
            $table->string('jabatan');
            $table->string('pangkat_gol');
            $table->string('nama_instansi');
            $table->string('email');
            $table->string('no_hp');
            $table->string('nama_akun')->unique();
            $table->enum('jenis_layanan', ['baru', 'reset', 'hapus', 'ubah']);
            $table->enum('pengajuan', ['diri_sendiri', 'orang_lain']);
            $table->string('nama_kadis');
            $table->string('nip_kadis');
            $table->text('karpeg')->nullable();
            $table->enum('status', ['terbuka', 'baru', 'diproses', 'tunda', 'selesai', 'tutup'])->default('terbuka');
            $table->string('nomor_tiket')->unique();
            $table->text('catatan_admin')->nullable();
            $table->text('catatan_pimpinan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_pribadis');
    }
};
