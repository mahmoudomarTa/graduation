<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('setting_translations')) {
            Schema::create('setting_translations', function (Blueprint $table) {
                $table->id();
                $table->string('locale')->index();
                $table->integer('setting_id')->unsigned();
                $table->string('address');
                $table->string('title');
                $table->string('description');
                $table->text('key_words');
                $table->text('login_cover');
                $table->text('plan_cover');
                $table->text('videos_cover');
                $table->timestamps();
                $table->softDeletes();
            });
            DB::table('setting_translations')->insert([
                ['locale'=>'en'
                    ,'setting_id'=>'1'
                    ,'address'=>'60 Grant Ave. Carteret NJ 0708'
                    ,'description'=>'description'
                    ,'key_words'=>'key_words'],
                ['locale'=>'ar'
                    ,'setting_id'=>'1'
                    ,'address'=>'60 جرانت افي. كارتريت نيوجيرسي 0708'
                    ,'description'=>'الوصف'
                    ,'key_words'=>'الكلمات المفتاحية'],

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
        Schema::dropIfExists('setting_translations');
    }
}
