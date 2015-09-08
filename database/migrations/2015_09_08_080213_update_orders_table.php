<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        if (!Schema::hasColumn('orders', 'open_way')) {
            Schema::table('orders', function ($table) {
                $table->enum('open_way', ['not_open', 'auto', 'manual']);    // 开通方式
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
