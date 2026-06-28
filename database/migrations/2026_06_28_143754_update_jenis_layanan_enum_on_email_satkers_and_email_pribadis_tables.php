<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE email_satkers
            MODIFY COLUMN jenis_layanan
            ENUM(
                'baru',
                'reset',
                'reaktivasi',
                'ubah_akun',
                'ubah_penanggung'
            )
            NOT NULL
            DEFAULT 'baru'
        ");

        DB::statement("
            ALTER TABLE email_pribadis
            MODIFY COLUMN jenis_layanan
            ENUM(
                'baru',
                'reset',
                'reaktivasi',
                'ubah_akun'
            )
            NOT NULL
            DEFAULT 'baru'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE email_satkers
            MODIFY COLUMN jenis_layanan
            ENUM(
                'baru',
                'reset',
                'ubah',
                'hapus'
            )
            NOT NULL
            DEFAULT 'baru'
        ");

        DB::statement("
            ALTER TABLE email_pribadis
            MODIFY COLUMN jenis_layanan
            ENUM(
                'baru',
                'reset',
                'ubah',
                'hapus'
            )
            NOT NULL
            DEFAULT 'baru'
        ");
    }
};
