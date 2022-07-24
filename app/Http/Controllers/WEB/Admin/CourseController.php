<?php

namespace App\Http\Controllers\WEB\Admin;


use App\Models\Course;
use App\Models\Department;
use App\Models\DepartmentYear;
use App\Models\Faculty;
use App\Models\Language;
use App\Models\Semester;
use App\Models\Setting;
use App\Models\Year;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

class CourseController extends Controller
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
         if(can('courses')){
            return $next($request);
         }
          if($route_name== 'index' ){
             if(can(['courses-show' , 'courses-create' , 'courses-edit' , 'courses-delete'])){
                 return $next($request);
             }
          }elseif($route_name== 'create' || $route_name== 'store'){
              if(can('courses-create')){
                 return $next($request);
             }
          }elseif($route_name== 'edit' || $route_name== 'update'){
              if(can('courses-edit')){
                 return $next($request);
             }
          }elseif($route_name== 'destroy' || $route_name== 'delete'){
              if(can('courses-delete')){
                 return $next($request);
             }
          }else{
              return $next($request);
          }
          return redirect()->back()->withErrors(__('cp.you_dont_have_premession'));
        });

    }

    public function index(){
        $items = Course::filter()->where('is_requirement','0')->orderBy('id', 'desc')->paginate(30);
        $departments = Department::all();
        return view('admin.courses.home', [
            'items' =>$items,
            'departments' =>$departments,
        ]);
    }


    public function create()
    {
        $faculties=Faculty::all();
        $semesters = Semester::all();
        return view('admin.courses.create')->with(compact('faculties','semesters'));
    }


    public function store(Request $request)
    {

        $roles = [
            'name'=>'required',
            'department_id'=>'required',
            'year_id'=>'required',
            'semester_id'=>'required',
            'status'=>'required',
        ];

        $this->validate($request, $roles);


        $item = new Course();
        $item->name=$request->name;
        $item->department_id=$request->department_id;
        $item->year_id=$request->year_id;
        $item->semester_id=$request->semester_id;
        $item->status=$request->status;

        $item->save();

        return redirect()->back()->with('status', __('cp.create'));

    }



    public function edit($id)
    {
        $item = Course::findOrFail($id);
        $faculties=Faculty::all();
        $semesters = Semester::all();
        $departments = Department::query()->where('faculty_id',$item->department->faculty_id)->get();
        $years = DepartmentYear::query()->where('department_id',$item->department->id)->get();
        return view('admin.courses.edit',compact('item','faculties','departments','years','semesters'));
    }

    public function update(Request $request, $id)
    {
//        return $request;
        $item = Course::findOrFail($id);

        $roles = [
            'name'=>'required',
            'department_id'=>'required',
            'year_id'=>'required',
            'semester_id'=>'required',
            'status'=>'required',
        ];

        $this->validate($request, $roles);
        $item->name=$request->name;
        $item->department_id=$request->department_id;
        $item->year_id=$request->year_id;
        $item->semester_id=$request->semester_id;
        $item->status=$request->status;

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));
    }

    public function destroy($id)
    {
        $item = Course::query()->findOrFail($id);
        if ($item) {
            Course::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }
}
