<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('barangs')) {
            // nothing to do if table doesn't exist
            return;
        }

        if (!Schema::hasColumn('barangs', 'owner_id')) {
            Schema::table('barangs', function (Blueprint $table) {
                $table->unsignedBigInteger('owner_id')->nullable()->after('id');
                $table->foreign('owner_id')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    public function down(): void {
        if (!Schema::hasTable('barangs')) {
            return;
        }

        Schema::table('barangs', function (Blueprint $table) {
            if (Schema::hasColumn('barangs', 'owner_id')) {
                $table->dropForeign(['owner_id']);
                $table->dropColumn('owner_id');
            }
        });
    }
};
