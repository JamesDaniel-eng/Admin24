<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmployeesV2023 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_dismissals', function (Blueprint $table) {
            $table->id('id');
            $table->integer('company_id');
            $table->integer('employee_id');
            $table->string('type');
            $table->date('dismissal_date');
            $table->text('reason')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
            $table->unique(['company_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employees_dismissals');
    }
}
