<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmin24BusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin24_businesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->integer('user_id');
            $table->integer('sub_no')->unique();
            $table->text('name');
            $table->text('email')->unique();
            $table->text('reg_no');
            $table->text('state');
            $table->foreignId('business_book_keeping_method_id')
                  ->constrained('admin24_business_book_keeping_methods')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('tax_status_id')
                  ->constrained('admin24_tax_statuses')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('business_type_id')
                  ->constrained('admin24_business_types')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('business_industry_id')
                  ->constrained('admin24_business_industries')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
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
        Schema::table('admin24_businesses', function (Blueprint $table) {
            $table->dropForeign(['business_book_keeping_method_id']);
            $table->dropForeign(['tax_status_id']);
            $table->dropForeign(['business_type_id']);
            $table->dropForeign(['business_industry_id']);

            $table->dropColumn('business_book_keeping_method_id');
            $table->dropColumn('tax_status_id');
            $table->dropColumn('business_type_id');
            $table->dropColumn('business_industry_id');
        });

        Schema::dropIfExists('admin24_businesses');
    }
}
