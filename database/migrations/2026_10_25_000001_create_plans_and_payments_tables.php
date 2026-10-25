<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Update users table with multi-tenant Admin, Plan, Custom Overrides and Razorpay credentials
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'admin_id')) {
                $table->unsignedBigInteger('admin_id')->nullable()->after('id')->index();
            }
            if (!Schema::hasColumn('users', 'plan_id')) {
                $table->unsignedBigInteger('plan_id')->nullable()->after('admin_id')->index();
            }
            if (!Schema::hasColumn('users', 'extra_spin_rounds')) {
                $table->integer('extra_spin_rounds')->default(0)->after('spin_whell_round');
            }
            if (!Schema::hasColumn('users', 'extra_campaigns_limit')) {
                $table->integer('extra_campaigns_limit')->default(0)->after('extra_spin_rounds');
            }
            if (!Schema::hasColumn('users', 'custom_access_override')) {
                $table->text('custom_access_override')->nullable()->after('extra_campaigns_limit');
            }
            if (!Schema::hasColumn('users', 'razorpay_key_id')) {
                $table->string('razorpay_key_id')->nullable()->after('custom_access_override');
            }
            if (!Schema::hasColumn('users', 'razorpay_key_secret')) {
                $table->string('razorpay_key_secret')->nullable()->after('razorpay_key_id');
            }
            if (!Schema::hasColumn('users', 'razorpay_enabled')) {
                $table->boolean('razorpay_enabled')->default(false)->after('razorpay_key_secret');
            }
        });

        // 2. Create Plans table (Each admin creates their own plans and access limits)
        if (!Schema::hasTable('plans')) {
            Schema::create('plans', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id')->index();
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2)->default(0.00);
                $table->integer('duration_days')->default(30);
                $table->integer('spin_rounds_limit')->default(500); // -1 = Unlimited
                $table->integer('campaigns_limit')->default(1);     // -1 = Unlimited
                $table->boolean('has_ip_skip')->default(true);
                $table->boolean('has_whatsapp')->default(true);
                $table->boolean('has_custom_branding')->default(true);
                $table->text('features_list')->nullable();
                $table->string('status')->default('active'); // active / inactive
                $table->boolean('is_popular')->default(false);
                $table->timestamps();
            });
        }

        // 3. Create Payments table (Track all Razorpay transactions)
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->string('payment_unique_id')->unique();
                $table->unsignedBigInteger('admin_id')->index();
                $table->unsignedBigInteger('user_id')->index();
                $table->unsignedBigInteger('plan_id')->nullable()->index();
                $table->string('plan_name');
                $table->decimal('amount', 10, 2);
                $table->string('currency', 10)->default('INR');
                $table->string('razorpay_order_id')->nullable()->index();
                $table->string('razorpay_payment_id')->nullable()->index();
                $table->string('razorpay_signature')->nullable();
                $table->string('status')->default('pending'); // pending, success, failed
                $table->string('payment_method')->nullable();
                $table->text('billing_details')->nullable();
                $table->date('expiry_extended_to')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('plans');
        Schema::table('users', function (Blueprint $table) {
            $cols = [
                'admin_id', 'plan_id', 'extra_spin_rounds', 'extra_campaigns_limit',
                'custom_access_override', 'razorpay_key_id', 'razorpay_key_secret', 'razorpay_enabled'
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
