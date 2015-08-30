<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('courses', 'ablesky_category')) {
            Schema::table('courses', function ($table) {
                $table->string('ablesky_category'); // Ablesky目录课程
            });
        }
        
        if (!Schema::hasColumn('courses', 'discount_price')) {
            Schema::table('courses', function ($table) {
                $table->float('discount_price')->default(0);   // 优惠价
            });
        }
        
        if (!Schema::hasColumn('courses', 'image')) {
            Schema::table('courses', function ($table) {
                $table->string('image'); // 课程优势图片
            });
        }
        
        if (!Schema::hasColumn('courses', 'description')) {
            Schema::table('courses', function ($table) {
                $table->text('description'); // 课程介绍
            });
        }
        
        if (!Schema::hasColumn('courses', 'hours_description')) {
            Schema::table('courses', function ($table) {
                $table->text('hours_description'); // 课时说明
            });
        }
        
        if (!Schema::hasColumn('courses', 'teacher')) {
            Schema::table('courses', function ($table) {
                $table->text('teacher'); // 主讲老师
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
        //
    }
}
