<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration *adds* boolean permission columns to the existing users table.
     * It checks for column existence first so it's safe to run on databases that
     * already have some (or none) of these columns.
     */
    public function up(): void
    {
        // Only modify if users table exists
        if (!Schema::hasTable('users')) {
            // nothing to do if table doesn't exist — prevents crash on misconfigured DB
            return;
        }

        // Add can_add
        if (!Schema::hasColumn('users', 'can_add')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('can_add')->default(false)->after('role');
            });
        }

        // Add can_edit
        if (!Schema::hasColumn('users', 'can_edit')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('can_edit')->default(false)->after('can_add');
            });
        }

        // Add can_delete
        if (!Schema::hasColumn('users', 'can_delete')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('can_delete')->default(false)->after('can_edit');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * Drops the columns if present.
     */
    public function down(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'can_delete')) {
                $table->dropColumn('can_delete');
            }
            if (Schema::hasColumn('users', 'can_edit')) {
                $table->dropColumn('can_edit');
            }
            if (Schema::hasColumn('users', 'can_add')) {
                $table->dropColumn('can_add');
            }
        });
    }
};
