<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create1555355612782UsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();
            $table->datetime('email_verified_at')->nullable();
            $table->enum('is_phone_verified', ['1', '0'])->default(0);
            $table->string('remember_token')->nullable();
            $table->enum('status', ['1', '0'])->default(1);
            $table->string('device_token')->nullable();
            $table->string('isd_code')->nullable();
            $table->datetime('last_login')->nullable();
            $table->integer('total_login')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
