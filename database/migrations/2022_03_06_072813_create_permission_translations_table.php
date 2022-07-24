<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('permission_translations')) {
            Schema::create('permission_translations', function (Blueprint $table) {
                $table->id();
                $table->integer('permission_id');
                $table->string('locale');
                $table->string('name');
                $table->timestamps();
                $table->softDeletes();
            });
            DB::table('permission_translations')->insert([

                ['permission_id'=>'1','locale'=>'en','name'=>'admins-show'],
                ['permission_id'=>'1','locale'=>'ar','name'=>'عرض المدراء'],
                ['permission_id'=>'2','locale'=>'en','name'=>'admins-create'],
                ['permission_id'=>'2','locale'=>'ar','name'=>'إضافة المدراء'],
                ['permission_id'=>'3','locale'=>'en','name'=>'admins-edit'],
                ['permission_id'=>'3','locale'=>'ar','name'=>'تعديل المدراء'],
                ['permission_id'=>'4','locale'=>'en','name'=>'admins-delete'],
                ['permission_id'=>'4','locale'=>'ar','name'=>'حذف المدراء'],

                ['permission_id'=>'5','locale'=>'en','name'=>'users-show'],
                ['permission_id'=>'5','locale'=>'ar','name'=>'عرض المستخدمين'],
                ['permission_id'=>'6','locale'=>'en','name'=>'users-create'],
                ['permission_id'=>'6','locale'=>'ar','name'=>'إضافة المستخدمين'],
                ['permission_id'=>'7','locale'=>'en','name'=>'users-edit'],
                ['permission_id'=>'7','locale'=>'ar','name'=>'تعديل المستخدمين'],
                ['permission_id'=>'8','locale'=>'en','name'=>'users-delete'],
                ['permission_id'=>'8','locale'=>'ar','name'=>'حذف المستخدمين'],



                ['permission_id'=>'9','locale'=>'en','name'=>'faculties-show'],
                ['permission_id'=>'9','locale'=>'ar','name'=>'عرض الكليات'],
                ['permission_id'=>'10','locale'=>'en','name'=>'faculties-create'],
                ['permission_id'=>'10','locale'=>'ar','name'=>'إضافة الكليات'],
                ['permission_id'=>'11','locale'=>'en','name'=>'faculties-edit'],
                ['permission_id'=>'11','locale'=>'ar','name'=>'تعديل الكليات'],
                ['permission_id'=>'12','locale'=>'en','name'=>'faculties-delete'],
                ['permission_id'=>'12','locale'=>'ar','name'=>'حذف الكليات'],


                ['permission_id'=>'13','locale'=>'en','name'=>'departments-show'],
                ['permission_id'=>'13','locale'=>'ar','name'=>'عرض الأقسام'],
                ['permission_id'=>'14','locale'=>'en','name'=>'departments-create'],
                ['permission_id'=>'14','locale'=>'ar','name'=>'إضافة الأقسام'],
                ['permission_id'=>'25','locale'=>'en','name'=>'departments-edit'],
                ['permission_id'=>'25','locale'=>'ar','name'=>'تعديل الأقسام'],
                ['permission_id'=>'16','locale'=>'en','name'=>'departments-delete'],
                ['permission_id'=>'16','locale'=>'ar','name'=>'حذف الأقسام'],


                ['permission_id'=>'17','locale'=>'en','name'=>'courses-show'],
                ['permission_id'=>'17','locale'=>'ar','name'=>'عرض المساقات'],
                ['permission_id'=>'18','locale'=>'en','name'=>'courses-create'],
                ['permission_id'=>'18','locale'=>'ar','name'=>'إضافة المساقات'],
                ['permission_id'=>'19','locale'=>'en','name'=>'courses-edit'],
                ['permission_id'=>'19','locale'=>'ar','name'=>'تعديل المساقات'],
                ['permission_id'=>'20','locale'=>'en','name'=>'courses-delete'],
                ['permission_id'=>'20','locale'=>'ar','name'=>'حذف المساقات'],


                ['permission_id'=>'21','locale'=>'en','name'=>'videos-show'],
                ['permission_id'=>'21','locale'=>'ar','name'=>'عرض المحاضرات المصورة'],
                ['permission_id'=>'22','locale'=>'en','name'=>'videos-create'],
                ['permission_id'=>'22','locale'=>'ar','name'=>'إضافة المحاضرات المصورة'],
                ['permission_id'=>'23','locale'=>'en','name'=>'videos-edit'],
                ['permission_id'=>'23','locale'=>'ar','name'=>'تعديل المحاضرات المصورة'],
                ['permission_id'=>'24','locale'=>'en','name'=>'videos-delete'],
                ['permission_id'=>'24','locale'=>'ar','name'=>'حذف المحاضرات المصورة'],


                ['permission_id'=>'25','locale'=>'en','name'=>'files-show'],
                ['permission_id'=>'25','locale'=>'ar','name'=>'عرض الملفات المرفقة'],
                ['permission_id'=>'26','locale'=>'en','name'=>'files-create'],
                ['permission_id'=>'26','locale'=>'ar','name'=>'إضافة الملفات المرفقة'],
                ['permission_id'=>'27','locale'=>'en','name'=>'files-edit'],
                ['permission_id'=>'27','locale'=>'ar','name'=>'تعديل الملفات المرفقة'],
                ['permission_id'=>'28','locale'=>'en','name'=>'files-delete'],
                ['permission_id'=>'28','locale'=>'ar','name'=>'حذف الملفات المرفقة'],


                ['permission_id'=>'29','locale'=>'en','name'=>'roles-show'],
                ['permission_id'=>'29','locale'=>'ar','name'=>'عرض الصلاحيات'],
                ['permission_id'=>'30','locale'=>'en','name'=>'roles-create'],
                ['permission_id'=>'30','locale'=>'ar','name'=>'إضافة الصلاحيات'],
                ['permission_id'=>'31','locale'=>'en','name'=>'roles-edit'],
                ['permission_id'=>'31','locale'=>'ar','name'=>'تعديل الصلاحيات'],
                ['permission_id'=>'32','locale'=>'en','name'=>'roles-delete'],
                ['permission_id'=>'32','locale'=>'ar','name'=>'حذف الصلاحيات'],


                ['permission_id'=>'33','locale'=>'en','name'=>'requirements-show'],
                ['permission_id'=>'33','locale'=>'ar','name'=>'عرض المتطلبات الجامعية'],
                ['permission_id'=>'34','locale'=>'en','name'=>'requirements-create'],
                ['permission_id'=>'34','locale'=>'ar','name'=>'إضافة المتطلبات الجامعية'],
                ['permission_id'=>'35','locale'=>'en','name'=>'requirements-edit'],
                ['permission_id'=>'35','locale'=>'ar','name'=>'تعديل المتطلبات الجامعية'],
                ['permission_id'=>'36','locale'=>'en','name'=>'requirements-delete'],
                ['permission_id'=>'36','locale'=>'ar','name'=>'حذف المتطلبات الجامعية'],




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
        Schema::dropIfExists('permission_translations');
    }
}
