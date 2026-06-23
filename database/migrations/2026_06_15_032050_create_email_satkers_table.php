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
        Schema::create('email_satkers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('nama_instansi');
            $table->string('nama_akun_dinas')->unique();
            $table->string('nama_penanggung_jawab', 50);
            $table->string('nip', 20);
            $table->string('jabatan', 50);
            $table->string('pangkat_gol', 50);
            $table->string('email', 50);
            $table->string('no_hp', 50);
            $table->enum('jenis_layanan', ['baru', 'reset', 'hapus', 'ubah']);
            $table->string('nama_kadis');
            $table->string('nip_kadis');
            $table->string('karpeg')->nullable();
            $table->string('formulir_email')->nullable();
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
        Schema::dropIfExists('email_satkers');
    }
};
