<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('partner_id')->nullable()->after('category_id')->constrained('partners')->nullOnDelete();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->timestamp('review_reminder_sent_at')->nullable()->after('snap_token');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('review_reminder_sent_at');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropConstrainedForeignId('partner_id');
        });
    }
};