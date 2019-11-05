<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('staff_id', 10)->unique()->index();
            $table->integer('college_id')->index();
            $table->string('title', 5);
            $table->string('name', 100);
            $table->date('dob')->nullable();
            $table->tinyInteger('staff_category')->index();
            $table->tinyInteger('staff_position')->index();
            $table->string('tin_number', 20)->nullable();
            $table->string('ssnit_number', 20)->nullable();
            $table->date('date_commenced')->nullable();
            $table->string('picture')->nullable();
            $table->string('email', 100);
            $table->string('phone', 20);
            $table->enum('certificate', ['PhD', 'Masters', 'Bachelor', 'Diploma', 'HND', 'Others', 'None', 'BECE', 'WASSCE']);
            $table->decimal('salary', 10, 2);
            $table->decimal('bonus', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
