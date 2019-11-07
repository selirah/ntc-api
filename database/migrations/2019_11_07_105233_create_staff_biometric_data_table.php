<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffBiometricDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_biometric_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('college_id');
            $table->string('staff_id')->index();
            $table->string('template_key')->unique()->index();
            $table->string('finger_one')->unique()->index();
            $table->string('finger_two')->unique()->index();
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
        Schema::dropIfExists('staff_biometric_data');
    }
}
