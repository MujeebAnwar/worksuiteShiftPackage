<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignShiftsTable extends Migration
{
    /**
     * Run the Migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('department_id')->nullable();
            $table->string('color')->nullable();
            $table->unsignedBigInteger('shift_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->integer('extra_hours')->nullable();
            $table->integer('publish')->nullable();
            $table->string('date_added')->nullable();
            $table->string('month_added')->nullable();
            $table->string('year_added')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the Migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assign_shifts');
    }
}
