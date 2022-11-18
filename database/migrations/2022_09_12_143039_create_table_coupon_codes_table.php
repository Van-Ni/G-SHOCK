<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCouponCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_coupon_codes', function (Blueprint $table) {
            $table->id();
            $table->string("coupon_name");
            $table->string("coupon_code");
            $table->integer("coupon_qty");
            $table->enum("coupon_condition",['0','1'])->default('0');
            $table->integer("coupon_number");
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
        Schema::dropIfExists('table_coupon_codes');
    }
}
