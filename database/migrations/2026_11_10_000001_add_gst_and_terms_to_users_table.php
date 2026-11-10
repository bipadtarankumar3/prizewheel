<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'gst_number')) {
                $table->string('gst_number', 15)->nullable();
            }
            if (!Schema::hasColumn('users', 'terms_accepted_at')) {
                $table->timestamp('terms_accepted_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'gst_number')) {
                $table->dropColumn('gst_number');
            }
            if (Schema::hasColumn('users', 'terms_accepted_at')) {
                $table->dropColumn('terms_accepted_at');
            }
        });
    }
};
