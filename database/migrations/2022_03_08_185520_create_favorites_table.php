<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('favorites')){
            Schema::create('favorites', function (Blueprint $table) {
                $table->id();
                $table->string('user_key');
                $table->integer('user_id');
                $table->integer('video_id');
                $table->timestamps();
                $table->softDeletes();
            });
    }
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
