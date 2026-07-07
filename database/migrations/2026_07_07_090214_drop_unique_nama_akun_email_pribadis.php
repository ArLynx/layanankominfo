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
        Schema::table('email_pribadis', function (Blueprint $table) {

            $table->dropUnique('email_pribadis_nama_akun_unique');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_pribadis', function (Blueprint $table) {

            $table->unique('nama_akun');

        });
    }
};