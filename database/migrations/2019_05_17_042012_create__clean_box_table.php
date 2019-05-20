<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCleanBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CleanBox', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('region');
            $table->string('road');
            $table->string('location');
            $table->float('latitude',15,10);
            $table->float('longitude',15,10);
            $table->string('remarks');
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
        Schema::dropIfExists('CleanBox');
    }
}
