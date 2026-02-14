<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmin24QuantitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin24_quantities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('company_id');
            $table->integer('user_id');
            $table->integer('item_id')->nullable();
            $table->double('ratio');
            $table->double('multiplier');
            $table->timestamps();
            $table->date('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin24_quantities');
    }
}
