<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('number')->unique();
            $table->string('name')->nullable();
            $table->integer('balance')->default(0);
            $table->string('currency')->default('EUR');
            $table->timestamps();
        });
    }

    public function down() :void
    {
        Schema::dropIfExists('accounts');
    }
};
