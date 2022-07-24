<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->id();
                $table->string('slug');
                $table->timestamps();
                $table->softDeletes();
            });
            DB::table('permissions')->insert([

                ['slug'=>'admins-show'],
                ['slug'=>'admins-create'],
                ['slug'=>'admins-edit'],
                ['slug'=>'admins-delete'],

                ['slug'=>'users-show'],
                ['slug'=>'admins-create'],
                ['slug'=>'users-edit'],
                ['slug'=>'users-delete'],


                ['slug'=>'faculties-show'],
                ['slug'=>'faculties-create'],
                ['slug'=>'faculties-edit'],
                ['slug'=>'faculties-delete'],


                ['slug'=>'departments-show'],
                ['slug'=>'departments-create'],
                ['slug'=>'departments-edit'],
                ['slug'=>'departments-delete'],


                ['slug'=>'courses-show'],
                ['slug'=>'courses-create'],
                ['slug'=>'courses-edit'],
                ['slug'=>'courses-delete'],


                ['slug'=>'videos-show'],
                ['slug'=>'videos-create'],
                ['slug'=>'videos-edit'],
                ['slug'=>'videos-delete'],

                ['slug'=>'files-show'],
                ['slug'=>'files-create'],
                ['slug'=>'files-edit'],
                ['slug'=>'files-delete'],

                ['slug'=>'roles-show'],
                ['slug'=>'roles-create'],
                ['slug'=>'roles-edit'],
                ['slug'=>'roles-delete'],

                ['slug'=>'requirements-show'],
                ['slug'=>'requirements-create'],
                ['slug'=>'requirements-edit'],
                ['slug'=>'requirements-delete'],



            ]);
        }
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');

    }
}
