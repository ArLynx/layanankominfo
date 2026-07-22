<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->string('actor_type')->after('id');
            $table->unsignedBigInteger('actor_id')->after('actor_type');
            $table->string('role')->after('actor_id');

        });
    }

    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {

            $table->dropColumn([
                'actor_type',
                'actor_id',
                'role',
            ]);

            $table->unsignedBigInteger('user_id')->after('id');

        });
    }
};
