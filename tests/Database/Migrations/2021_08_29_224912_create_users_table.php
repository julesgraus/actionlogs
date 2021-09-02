<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {
    public function up() {
        Schema::create('users', function(Blueprint $table) {
           $table->id();
           $table->text('first_name');
           $table->text('last_name');
           $table->text('email');
           $table->text('password');
           $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('users');
    }
}
