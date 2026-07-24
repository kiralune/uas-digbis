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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('attendance_status')->default('pending')->after('status');
            $table->timestamp('attendance_verified_at')->nullable()->after('attendance_status');
            $table->string('certificate_path')->nullable()->after('attendance_verified_at');
            $table->timestamp('certificate_sent_at')->nullable()->after('certificate_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
