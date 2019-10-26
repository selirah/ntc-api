<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('college_id')->default(0);
            $table->integer('parent_id')->default(0)->index();
            $table->string('name');
            $table->string('email')->unique()->index();
            $table->string('phone')->unique()->index();
            $table->tinyInteger('is_verified')->default(0);
            $table->tinyInteger('is_revoke')->default(0);
            $table->string('role', 20);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token')->unique();
            $table->bigInteger('token_expiry');
            $table->string('avatar')->nullable();
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
        Schema::dropIfExists('users');
    }
}
