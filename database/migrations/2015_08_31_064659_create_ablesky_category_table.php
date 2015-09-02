<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbleskyCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ablesky_category', function (Blueprint $table) {
            $table->string('id');            
            $table->string('categoryName');    
            $table->string('parentId');              
            $table->integer('categoryLevel');
            $table->integer('rank');    
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
