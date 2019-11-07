<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('college_id')->index();
            $table->string('student_id', 15)->index()->unique();
            $table->string('index_number', 15)->index()->unique();
            $table->string('account_code', 15)->nullable();
            $table->integer('programme_id')->index();
            $table->integer('department_id')->index();
            $table->string('surname', 50);
            $table->string('othernames', 100);
            $table->enum('gender', ['M', 'F'])->index();
            $table->date('dob')->nullable();
            $table->string('admission_year', 4);
            $table->string('hall')->nullable();
            $table->text('address')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('phones');
            $table->string('picture')->nullable();
            $table->string('nationality', 50);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('payment_mode')->default(1);
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
        Schema::dropIfExists('students');
    }
}
