<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('orderno');              // 订单号
            $table->json('items');                  // 购买项目，json格式
            $table->float('totalprice')->default(0);// 总价
            $table->string('receiver');             // 收件人
            $table->string('phone');                // 电话
            $table->string('postcode');             // 邮编
            $table->string('address');              // 地址
            $table->string('paymode')->nullable();  // 支付方式，alipay，weixin，bank
            $table->dateTime('paytime')->nullable();// 支付完成时间
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
        Schema::drop('orders');
    }
}
