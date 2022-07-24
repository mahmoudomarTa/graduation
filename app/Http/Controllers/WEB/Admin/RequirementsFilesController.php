<?php

namespace App\Http\Controllers\WEB\Admin;


use App\Models\Course;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\File;
use App\Models\Language;
use App\Models\Semester;
use App\Models\Setting;
use App\Models\Year;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

class RequirementsFilesController extends Controller
{

    public function image_extensions(){

        return array('jpg','png','jpeg','gif','bmp','pdf');

    }


    public function __construct()
    {
        $this->settings = Setting::query()->first();
        view()->share([
            'settings' => $this->settings,
        ]);

         $route=Route::currentRouteAction();
         $route_name = substr($route, strpos($route, "@") + 1);
         $this->middleware(function ($request, $next) use($route_name){
         if(can('files')){
            return $next($request);
         }
          if($route_name== 'index' ){
             if(can(['files-show' , 'files-create' , 'files-edit' , 'files-delete'])){
                 return $next($request);
             }
          }elseif($route_name== 'create' || $route_name== 'store'){
              if(can('files-create')){
                 return $next($request);
             }
          }elseif($route_name== 'edit' || $route_name== 'update'){
              if(can('files-edit')){
                 return $next($request);
             }
          }elseif($route_name== 'destroy' || $route_name== 'delete'){
              if(can('files-delete')){
                 return $next($request);
             }
          }else{
              return $next($request);
          }
          return redirect()->back()->withErrors(__('cp.you_dont_have_premession'));
        });

    }

    public function index(){
        $items = File::filter()->where('is_requirement','1')->orderBy('id', 'desc')->get();

        $courses = Course::where('is_requirement','1')->orderBy('id', 'desc')->get();

        return view('admin.requirements_files.home', [
            'items' =>$items,
            'courses' =>$courses,
        ]);
    }





    public function create()
    {
        $courses = Course::where('is_requirement','1')->orderBy('id', 'desc')->get();
        return view('admin.requirements_files.create')->with(compact('courses'));

    }


    public function store(Request $request)
    {
        $roles = [
            'file' => 'required',
            'name'=>'required',
            'course_id'=>'required',
            'status'=>'required',
            ];

        $this->validate($request, $roles);
        $course = Course::query()->where('id',$request->course_id)->first();


        $item = new File();


        $item->name=$request->name;
        $item->course_id=$request->course_id;
        $item->status=$request->status;
        $item->is_requirement='1';

        if ($request->hasFile('file')) {
            $attachment = $request->file('file');
            $extention = $attachment->getClientOriginalExtension();
            $attachment_name=Str::random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) .'.' . $extention;
            $attachment->move(public_path('/uploads/files/'), $attachment_name);
            $item->file=$attachment_name;
        }

        $item->save();

        return redirect()->back()->with('status', __('cp.create'));

    }



    public function edit($id)
    {
        $item = File::findOrFail($id);
        $courses = Course::where('is_requirement','1')->orderBy('id', 'desc')->get();
        return view('admin.requirements_files.edit',compact('item','courses'));
    }

    public function update(Request $request, $id)
    {
        $item = File::findOrFail($id);
        $roles = [
            'file' => '',
            'name'=>'required',
            'course_id'=>'required',
            'status'=>'required',
        ];

        $this->validate($request, $roles);
        $course = Course::query()->where('id',$request->course_id)->first();

        $item->name=$request->name;
        $item->course_id=$request->course_id;
        $item->status=$request->status;
        $item->is_requirement='1';

        if ($request->hasFile('file')) {
            $attachment = $request->file('file');
            $extention = $attachment->getClientOriginalExtension();
            $attachment_name=Str::random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) .'.' . $extention;
            $attachment->move(public_path('/uploads/files/'), $attachment_name);
            $item->file=$attachment_name;
        }
        $item->save();

        return redirect()->back()->with('status', __('cp.update'));
    }

    public function destroy($id)
    {
        $item = File::query()->findOrFail($id);
        if ($item) {
            File::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }


}
