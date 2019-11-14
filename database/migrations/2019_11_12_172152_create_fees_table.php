<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('college_id')->index();
            $table->integer('programme_id')->index();
            $table->string('academic_year', 20)->index();
            $table->tinyInteger('student_payment_mode')->index();
            $table->tinyInteger('student_type')->index();
            $table->string('currency', 10)->default('GHS');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->json('breakdown');
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
        Schema::dropIfExists('fees');
    }
}
