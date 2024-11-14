<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('points')->nullable();
            $table->enum('discount_type', ['precentage', 'fixed'])->nullable();
            $table->integer('discount')->nullable();
            $table->string('coupon_code')->nullable();
            $table->enum('status', ['active', 'deactive'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rewards');
    }
}
