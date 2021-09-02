<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionLogsTable extends Migration {
    public function up() {
        Schema::create('actionlogs', function(Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('user_id')->nullable();
           $table->text('action');
           $table->longText('payload');
           $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('actionlogs');
    }
}
