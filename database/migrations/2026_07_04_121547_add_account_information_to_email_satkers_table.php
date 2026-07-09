<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('email_satkers', function (Blueprint $table) {
            $table->string('dokumen_akun')->nullable()->after('nama_instansi');

            $table->timestamp('email_sent_at')->nullable()->after('dokumen_akun');
        });
    }

    public function down(): void
    {
        Schema::table('email_satkers', function (Blueprint $table) {
            $table->dropColumn(['dokumen_akun', 'email_sent_at']);
        });
    }
};
