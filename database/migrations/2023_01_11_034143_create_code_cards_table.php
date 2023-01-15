<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('code_cards', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            for ($i=1; $i<=env('CODE_COUNT'); $i++){
                $table->string("$i")->unique();
            }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('code_cards');
    }
};
