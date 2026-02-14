<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmin24SaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin24_sale_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->integer('user_id');
            $table->integer('invoice_id');
            $table->text('item_name');
            $table->text('item_desc')->nullable();
            $table->integer('price');
            $table->integer('tax');
            $table->foreignId('customer_invoices_id')->constrained('admin24_customer_invoices')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::table('admin24_sale_items', function (Blueprint $table) {
            $table->dropForeign(['customer_invoices_id']);
            $table->dropColumn('customer_invoices_id');
        });

        Schema::dropIfExists('admin24_sale_items');
    }
}
