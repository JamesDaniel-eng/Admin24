<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompositeItemsV210 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('composite_items_document_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('type');
            $table->integer('document_id');
            $table->integer('item_id');
            $table->integer('document_item_id');
            $table->integer('warehouse_id')->nullable();
            $table->double('quantity', 12, 2)->nullable();
            $table->double('price', 15, 4);
            $table->float('tax', 15, 4)->default('0.0000');
            $table->string('discount_type')->default('normal');
            $table->double('discount_rate', 15, 4)->default('0.0000');
            $table->double('total', 15, 4);
            $table->string('created_by', 30)->nullable();
            $table->string('created_from', 30)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('composite_items_document_items');
    }
}
