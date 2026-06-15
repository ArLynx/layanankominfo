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
            $table->string('nip')->nullable()->after('user_id');
            $table->string('position')->nullable()->after('nip');
            $table->string('department')->nullable()->after('position');
            $table->string('unit_work')->nullable()->after('department');
            $table->string('proposed_name')->nullable()->after('reason');
            $table->string('document_path')->nullable()->after('proposed_name');
        });
    }

    public function down(): void
    {
        Schema::table('request_applications', function (Blueprint $table) {
            $table->dropColumn(['nip', 'position', 'department', 'unit_work', 'proposed_name', 'document_path']);
        });
    }
};
