<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('subdomains', function (Blueprint $table) {
            $table->renameColumn('sk_penunjukan', 'surat_penunjukan');
        });
    }

    public function down(): void
    {
        Schema::table('subdomains', function (Blueprint $table) {
            $table->renameColumn('surat_penunjukan', 'sk_penunjukan');
        });
    }
};
