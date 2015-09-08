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
            if (!Schema::hasColumn('courses', 'sub_ablesky_category')) {
            Schema::table('courses', function ($table) {
                $table->string('sub_ablesky_category');   // 子科 Ablesky目录课程
            });
        }
        
        if (!Schema::hasColumn('courses', 'zonghe_ablesky_category')) {
            Schema::table('courses', function ($table) {
                $table->string('zonghe_ablesky_category');   // 综合 Ablesky目录课程
            });
        }
                
        if (!Schema::hasColumn('courses', 'nengli_ablesky_category')) {
            Schema::table('courses', function ($table) {
                $table->string('nengli_ablesky_category');   // 能力 Ablesky目录课程
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
