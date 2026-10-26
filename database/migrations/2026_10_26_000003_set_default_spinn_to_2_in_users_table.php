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
        try {
            DB::statement("ALTER TABLE `users` ALTER `default_spinn` SET DEFAULT 2");
        } catch (\Throwable $e) {
            try {
                DB::statement("ALTER TABLE `users` MODIFY `default_spinn` INT NOT NULL DEFAULT 2");
            } catch (\Throwable $e2) {
                // Ignore if not supported or already modified
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            DB::statement("ALTER TABLE `users` ALTER `default_spinn` SET DEFAULT 1");
        } catch (\Throwable $e) {
            try {
                DB::statement("ALTER TABLE `users` MODIFY `default_spinn` INT NOT NULL DEFAULT 1");
            } catch (\Throwable $e2) {
                // Ignore
            }
        }
    }
};
