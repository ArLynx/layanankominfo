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
        Schema::create('subdomains', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('nama_subdomain');
            $table->string('nama_subdomain_baru')->nullable();
            $table->text('deskripsi_website');

            $table->string('nama_penanggung_jawab');
            $table->string('nip_penanggung_jawab');
            $table->string('jabatan');
            $table->string('pangkat_gol');
            $table->string('nama_instansi');
            $table->string('no_hp');
            $table->string('email');

            $table->string('nama_penanggung_jawab_baru')->nullable();
            $table->string('nip_penanggung_jawab_baru')->nullable();
            $table->string('jabatan_baru')->nullable();
            $table->string('pangkat_gol_baru')->nullable();
            $table->string('no_hp_baru')->nullable();
            $table->string('email_baru')->nullable();

            $table->enum('jenis_layanan', ['baru', 'ubah_penanggung', 'ubah_subdomain', 'nonaktif']);
            $table->string('nama_kadis');
            $table->string('nip_kadis');
            $table->string('jabatan_kadis');

            $table->string('karpeg')->nullable();
            $table->string('formulir_subdomain')->nullable();
            $table->string('surat_penunjukan')->nullable();
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
        Schema::dropIfExists('subdomains');
    }
};
