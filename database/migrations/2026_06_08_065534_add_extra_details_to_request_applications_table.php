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
        Schema::table('request_applications', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('user_id');
            $table->string('rank')->nullable()->after('nip');
            $table->string('kadis_name')->nullable()->after('admin_notes');
            $table->string('kadis_nip')->nullable()->after('kadis_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_applications', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'rank', 'kadis_name', 'kadis_nip']);
        });
    }
};
