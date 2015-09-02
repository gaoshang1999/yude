<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');                     // 名称
            $table->string('summary');          // 简介
            $table->integer('rank')->default(0);    // 显示顺序              
            $table->integer('zx_course');    // 中学课程
            $table->integer('xx_course');    // 小学课程
            $table->integer('yr_course');    // 幼儿课程
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
        //
    }
}
