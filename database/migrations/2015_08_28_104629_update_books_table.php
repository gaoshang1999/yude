<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('books', 'press')) {
            Schema::table('books', function ($table) {
                $table->string('press'); // 出版社
            });
        }
        
        if (!Schema::hasColumn('books', 'pulish_date')) {
            Schema::table('books', function ($table) {
                $table->string('publish_date'); // 出版时间
            });
        }
        
        if (!Schema::hasColumn('books', 'description')) {
            Schema::table('books', function ($table) {
                $table->text('description'); // 教材介绍
            });
        }
        
        if (!Schema::hasColumn('books', 'cover2')) {
            Schema::table('books', function ($table) {
                $table->string('cover2'); // 课程封面图片2
            });
        }
        
        if (!Schema::hasColumn('books', 'cover3')) {
            Schema::table('books', function ($table) {
                $table->string('cover3'); // 课程封面图片3
            });
        }
        
        if (!Schema::hasColumn('books', 'cover4')) {
            Schema::table('books', function ($table) {
                $table->string('cover4'); // 课程封面图片4
            });
        }
        
        if (!Schema::hasColumn('books', 'image')) {
            Schema::table('books', function ($table) {
                $table->string('image'); // 教材特色图片
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
