<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->string('deposit')->nullable()->after('condition');
            $table->string('daily_rate')->nullable()->after('deposit');
            $table->integer('max_days')->default(7)->after('daily_rate');
            $table->string('icon')->default('fas fa-dumbbell')->after('code');
            $table->decimal('rating', 3, 1)->default(0.0)->after('available');
            $table->integer('reviews')->default(0)->after('rating');
            $table->json('rules')->nullable()->after('reviews');
            $table->json('features')->nullable()->after('rules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn(['description', 'deposit', 'daily_rate', 'max_days', 'icon', 'rating', 'reviews', 'rules', 'features']);
        });
    }
}
