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
        if (!Schema::hasColumn('courses', 'discount_subprice')) {
            Schema::table('courses', function ($table) {
                $table->float('discount_subprice')->default(0);   // 子科 优惠价
            });
        }
        
        if (!Schema::hasColumn('courses', 'discount_zongheprice')) {
            Schema::table('courses', function ($table) {
                $table->float('discount_zongheprice')->default(0);   // 综合 优惠价
            });
        }
                
        if (!Schema::hasColumn('courses', 'discount_nengliprice')) {
            Schema::table('courses', function ($table) {
                $table->float('discount_nengliprice')->default(0);   // 能力 优惠价
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
