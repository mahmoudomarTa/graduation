<?php

namespace App\Http\Controllers\WEB\Admin;


use App\Models\Course;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Language;
use App\Models\Semester;
use App\Models\Setting;
use App\Models\Video;
use App\Models\Year;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

class VideoController extends Controller
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
         if(can('videos')){
            return $next($request);
         }
          if($route_name== 'index' ){
             if(can(['videos-show' , 'videos-create' , 'videos-edit' , 'videos-delete'])){
                 return $next($request);
             }
          }elseif($route_name== 'create' || $route_name== 'store'){
              if(can('videos-create')){
                 return $next($request);
             }
          }elseif($route_name== 'edit' || $route_name== 'update'){
              if(can('videos-edit')){
                 return $next($request);
             }
          }elseif($route_name== 'destroy' || $route_name== 'delete'){
              if(can('videos-delete')){
                 return $next($request);
             }
          }else{
              return $next($request);
          }
          return redirect()->back()->withErrors(__('cp.you_dont_have_premession'));
        });

    }

    public function index(){
        $items = Video::filter()->where('is_requirement','0')->orderBy('id', 'desc')->paginate(20);
        $faculties = Faculty::all();
        $departments = Department::all();
        $courses = Course::all();
        $years = Year::all();
        $semesters = Semester::all();
        return view('admin.videos.home', [
            'items' =>$items,
            'faculties' =>$faculties,
            'departments' =>$departments,
            'courses' =>$courses,
            'years' =>$years,
            'semesters' =>$semesters,
        ]);
    }





    public function create()
    {
        $faculties=Faculty::all();
        $semesters = Semester::all();
        return view('admin.videos.create')->with(compact('faculties','semesters'));

    }


    public function store(Request $request)
    {
        $roles = [
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',
            'name'=>'required',
            'faculty_id'=>'required',
            'department_id'=>'required',
            'course_id'=>'required',
            'url'=>'required|url',
            'status'=>'required',
            ];

        $this->validate($request, $roles);
        $course = Course::query()->where('id',$request->course_id)->first();


        $item = new Video();


        $item->name=$request->name;
        $item->description=$request->description;
        $item->faculty_id=$request->faculty_id;
        $item->department_id=$request->department_id;
        $item->course_id=$request->course_id;
        $item->url=$request->url;
        $item->year_id=@$course->year->id;
        $item->semester_id=@$course->semester->id;
        $item->status=$request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extention = $image->getClientOriginalExtension();

            $name = Str::random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) .'.' . $extention;

            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploads/images/videos/$name");
            $item->image=$name;
        }

        $item->save();

        return redirect()->back()->with('status', __('cp.create'));

    }



    public function edit($id)
    {
        $item = Video::findOrFail($id);
        $faculties=Faculty::all();
        $departments = Department::query()->where('faculty_id',$item->faculty_id)->get();
        $courses = Course::query()->where('department_id',$item->department_id)->get();

        return view('admin.videos.edit',compact('item','faculties','departments','courses'));
    }

    public function update(Request $request, $id)
    {
//        return $request;
        $item = Video::findOrFail($id);
        $roles = [
            'image' => 'image|mimes:jpeg,jpg,png,gif',
            'name'=>'required',
            'faculty_id'=>'required',
            'department_id'=>'required',
            'course_id'=>'required',
            'url'=>'required|url',
            'status'=>'required',
//            'description'=>'required',
        ];

        $this->validate($request, $roles);
        $course = Course::query()->where('id',$request->course_id)->first();

        $item->name=$request->name;
        $item->description=$request->description;
        $item->faculty_id=$request->faculty_id;
        $item->department_id=$request->department_id;
        $item->course_id=$request->course_id;
        $item->url=$request->url;
        $item->year_id=@$course->year->id;
        $item->semester_id=@$course->semester->id;
        $item->status=$request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extention = $image->getClientOriginalExtension();

            $name = Str::random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) .'.' . $extention;

            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploads/images/videos/$name");
            $item->image=$name;
        }

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));
    }

    public function destroy($id)
    {
        $item = Video::query()->findOrFail($id);
        if ($item) {
            Video::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function getDepartments(Request $request)
    {
        $id = $request->id;
        $items = Department::where('faculty_id',$id)->get();
        return response()->json([
            'items' => $items
        ]);
    }



}
