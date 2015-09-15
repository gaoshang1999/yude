<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHasSubToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (!Schema::hasColumn('courses', 'has_sub')) {
            Schema::table('courses', function ($table) {
                $table->boolean('has_sub')->default(true);   // 是否有子科
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
