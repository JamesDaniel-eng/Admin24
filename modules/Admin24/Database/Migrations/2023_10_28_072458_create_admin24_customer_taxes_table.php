<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmin24CustomerTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin24_customer_taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->integer('user_id');
            $table->integer('business_id');
            $table->text('name');
            $table->text('type');
            $table->text('state');
            $table->integer('percentage');
            $table->text('desc')->nullable();
            $table->foreignId('sale_items_id')->constrained('admin24_sale_items')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::table('admin24_customer_taxes', function (Blueprint $table) {
            $table->dropForeign(['sale_items_id']);
            $table->dropColumn('sale_items_id');
        });

        Schema::dropIfExists('admin24_customer_taxes');
    }
}
