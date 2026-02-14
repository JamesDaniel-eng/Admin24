<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmin24CustomerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin24_customer_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->integer('user_id');
            $table->integer('invoice_id');
            $table->integer('amount');
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
        Schema::table('admin24_customer_payments', function (Blueprint $table) {
            $table->dropForeign(['customer_invoices_id']);
            $table->dropColumn('customer_invoices_id');
        });

        Schema::dropIfExists('admin24_customer_payments');
    }
}
