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
            $table->string('jabatan_kadis')->after('nama_kadis');
        });
    }

    public function down(): void
    {
        Schema::table('email_satkers', function (Blueprint $table) {
            $table->dropColumn('jabatan_kadis');
        });
    }
};
