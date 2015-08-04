<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('level', ['zhongxue', 'xiaoxue', 'youer']);    // 级别
            $table->enum('kind', ['bishi', 'mianshi']); // 类别
            $table->string('name');                     // 课程名称
            $table->boolean('enable')->default(true);   // 状态，上架 下架
            $table->integer('buytimes')->default(0);    // 购买次数
            $table->float('hours')->default(0);         // 课时
            $table->float('totalprice')->default(0);    // 总价格
            $table->string('subname');                  // 子科名称
            $table->float('subprice')->default(0);      // 子科价格
            $table->float('zongheprice')->default(0);   // 综合素质价格
            $table->float('nengliprice')->default(0);   // 学科知识与能力价格，只有级别选择“中学”，才会出现该项
            $table->string('cover');            // 课程封面图片
            $table->string('video');            // 课程视频接入链接, 可多个视频链接，一个回车算一个视频
            $table->string('trialvideo');       // 试听视频接入链接
            $table->string('summary');          // 课程介绍
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
        Schema::drop('courses');
    }
}
