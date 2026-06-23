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
            $table->string('nip', 20);
            $table->string('jabatan', 50);
            $table->string('pangkat_gol', 50);
            $table->string('nama_instansi');
            $table->string('email', 50);
            $table->string('no_hp', 50);
            $table->string('nama_akun', 50)->unique();
            $table->enum('jenis_layanan', ['baru', 'reset', 'hapus', 'ubah']);
            $table->enum('pengajuan', ['diri_sendiri', 'orang_lain']);
            $table->string('nama_kadis', 100);
            $table->string('nip_kadis', 30);
            $table->text('karpeg')->nullable();
            $table->enum('status', ['terbuka', 'baru', 'diproses', 'tunda', 'selesai', 'tutup'])->default('terbuka');
            $table->string('nomor_tiket', 50)->unique();
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
