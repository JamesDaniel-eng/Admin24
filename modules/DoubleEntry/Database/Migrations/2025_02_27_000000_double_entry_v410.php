<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('double_entry_rcr_ledger', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('account_id');
            $table->integer('transaction_id')->nullable();
            $table->morphs('ledgerable');
            $table->dateTime('issued_at');
            $table->string('entry_type');
            $table->double('debit', 15, 4)->nullable();
            $table->double('credit', 15, 4)->nullable();
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            $table->string('created_from', 100)->nullable();
            $table->unsignedInteger('created_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('double_entry_rcr_ledger');
    }
};
