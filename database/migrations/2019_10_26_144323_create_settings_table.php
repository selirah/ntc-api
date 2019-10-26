<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('college_id')->index();
            $table->string('academic_year', 20);
            $table->tinyInteger('semester');
            $table->decimal('fee_percentage_freshers', 3, 2)->default(100.00);
            $table->decimal('fee_percentage_continuing', 3, 2)->default(100.00);
            $table->date('exam_start')->nullable();
            $table->date('exam_end')->nullable();
            $table->date('results_upload_start')->nullable();
            $table->date('results_upload_end')->nullable();
            $table->date('registration_start')->nullable();
            $table->date('registration_end')->nullable();
            $table->date('semester_vacation')->nullable();
            $table->date('next_semester_reopening')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
