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
            $table->decimal('fee_percentage_freshers', 10, 2)->default(100.00);
            $table->decimal('fee_percentage_continuing', 10, 2)->default(100.00);
            $table->date('exam_start')->nullable()->default(null);
            $table->date('exam_end')->nullable()->default(null);
            $table->date('results_upload_start')->nullable()->default(null);
            $table->date('results_upload_end')->nullable()->default(null);
            $table->date('registration_start')->nullable()->default(null);
            $table->date('registration_end')->nullable()->default(null);
            $table->date('semester_vacation')->nullable()->default(null);
            $table->date('next_semester_reopening')->nullable()->default(null);
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
