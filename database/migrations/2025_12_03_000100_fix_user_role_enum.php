<?php

use App\Core\Enums\UserRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Normalize user role values and align enum definition with backing enum.
     */
    public function up(): void
    {
        // Normalize stored values to lowercase to match the enum backing values.
        DB::table('users')->where('role', 'User')->update(['role' => UserRole::USER->getValue()]);
        DB::table('users')->where('role', 'Admin')->update(['role' => UserRole::ADMIN->getValue()]);

        // Align column enum values with the backing enum (admin / user).
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin','user') NOT NULL DEFAULT 'user'");
        }
    }

    /**
     * Revert normalization (not recommended for production, but keeps migration reversible).
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('Admin','User') NOT NULL DEFAULT 'User'");
        }

        DB::table('users')->where('role', 'user')->update(['role' => 'User']);
        DB::table('users')->where('role', 'admin')->update(['role' => 'Admin']);
    }
};
