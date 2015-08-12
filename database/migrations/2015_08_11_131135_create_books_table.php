<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('level', ['zhongxue', 'xiaoxue', 'youer']);    // 级别
            $table->enum('kind', ['bishi', 'mianshi']); // 类别
            $table->string('name');                     // 教材名称
            $table->float('price')->default(0);   //  定价
            $table->float('discount')->default(0);   //  折扣
            $table->float('discount_price')->default(0);   // 折扣价
            $table->integer('inventory')->default(0);         // 库存
            $table->integer('buytimes')->default(0);    // 购买次数           
            
            $table->string('author');                  // 作者   
            $table->string('cover');            // 教材封面图片
            $table->string('summary');          // 教材介绍
            $table->string('pagetitle');        // 页面title
            $table->string('pagekeyword');      // 页面keyword
            $table->string('pagedescription');  // 页面description
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
        Schema::drop('books');
    }
}
