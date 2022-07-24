<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('videos')) {
            Schema::create('videos', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->text('url');
                $table->string('image');
                $table->integer('faculty_id');
                $table->integer('department_id');
                $table->integer('course_id');
                $table->integer('year_id');
                $table->integer('semester_id');
                $table->integer('is_requirement')->default('0')->comment('1->yes , 0->no');
                $table->enum('status',['active','not_active'])->default('active');
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
        Schema::dropIfExists('videos');
    }
}
