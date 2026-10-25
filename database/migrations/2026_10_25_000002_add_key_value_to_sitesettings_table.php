<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sitesettings', function (Blueprint $table) {
            if (!Schema::hasColumn('sitesettings', 'key')) {
                $table->string('key', 150)->nullable()->index()->after('user_id');
            }
            if (!Schema::hasColumn('sitesettings', 'value')) {
                $table->longText('value')->nullable()->after('key');
            }
        });

        // Ensure legacy columns are nullable so key-value rows can be inserted without dummy data
        try {
            DB::statement("ALTER TABLE `sitesettings` MODIFY `background_music` TEXT NULL");
            DB::statement("ALTER TABLE `sitesettings` MODIFY `background_music_status` VARCHAR(255) NULL");
        } catch (\Throwable $e) {
            // ignore if not supported or already nullable
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sitesettings', function (Blueprint $table) {
            if (Schema::hasColumn('sitesettings', 'key')) {
                $table->dropColumn('key');
            }
            if (Schema::hasColumn('sitesettings', 'value')) {
                $table->dropColumn('value');
            }
        });
    }
};
