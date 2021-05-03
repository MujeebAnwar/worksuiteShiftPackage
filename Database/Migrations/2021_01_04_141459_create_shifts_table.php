<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the Migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('shift_date')->nullable();
            $table->integer('type')->comment('1 = recurring ,  2 = cyclic , 3 = free');
            $table->unsignedBigInteger('cyclic_duration')->nullable();
            $table->string('start_min_time')->nullable();
            $table->string('start_time')->nullable();
            $table->string('start_max_time')->nullable();
            $table->string('finish_min_time')->nullable();
            $table->string('finish_time')->nullable();
            $table->string('finish_max_time')->nullable();
            $table->unsignedBigInteger('break_time')->nullable();
            $table->unsignedBigInteger('free_work_time')->nullable();
            $table->unsignedBigInteger('free_work_time_range')->nullable();
            $table->string('free_work_time_from')->nullable();
            $table->string('free_work_time_to')->nullable();
            $table->unsignedBigInteger('range')->comment('0 = No , 1 = yes');
            $table->string('range_from')->nullable();
            $table->string('range_to')->nullable();
            $table->integer('unhealty_shift')->comment('0 = No , 1 = yes');
            $table->string('weekdays')->nullable();
            $table->integer('indefinite')->comment('0 = No , 1 = yes');
            $table->string('shift_end_on')->nullable();
            $table->unsignedBigInteger('project_id')->default(0);
            $table->unsignedBigInteger('task_id')->default(0);
            $table->string('tag')->nullable();
            $table->string('note')->nullable();
            $table->integer('publish')->comment('0 = No , 1 = yes');
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
        Schema::dropIfExists('shifts');
    }
}
