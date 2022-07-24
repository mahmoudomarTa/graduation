<?php

namespace App\Http\Controllers\WEB\Admin;


use App\Models\Course;
use App\Models\Department;
use App\Models\DepartmentYear;
use App\Models\Faculty;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Year;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

class DepartmentController extends Controller
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
         if(can('departments')){
            return $next($request);
         }
          if($route_name== 'index' ){
             if(can(['departments-show' , 'departments-create' , 'departments-edit' , 'departments-delete'])){
                 return $next($request);
             }
          }elseif($route_name== 'create' || $route_name== 'store'){
              if(can('departments-create')){
                 return $next($request);
             }
          }elseif($route_name== 'edit' || $route_name== 'update'){
              if(can('departments-edit')){
                 return $next($request);
             }
          }elseif($route_name== 'destroy' || $route_name== 'delete'){
              if(can('departments-delete')){
                 return $next($request);
             }
          }else{
              return $next($request);
          }
          return redirect()->back()->withErrors(__('cp.you_dont_have_premession'));
        });

    }

    public function index(Request $request){
        $items = Department::filter()->orderBy('id', 'desc')->get();
        return view('admin.departments.home', [
            'items' =>$items,
        ]);
    }


    public function create()
    {
        $faculties=Faculty::all();
        $years=Year::all();
        return view('admin.departments.create')->with(compact('faculties','years'));
    }


    public function store(Request $request)
    {

        $roles = [
            'faculty_id'=>'required',
//            'image' => 'required|image|mimes:jpeg,jpg,png,gif',

        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);


        $item = new Department();
        $item->faculty_id=$request->faculty_id;
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
//        if ($request->hasFile('image')) {
//            $image = $request->file('image');
//            $extention = $image->getClientOriginalExtension();
//
//            $name = Str::random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) .'.' . $extention;
//
//            Image::make($image)->resize(800, null, function ($constraint) {
//                $constraint->aspectRatio();
//            })->save("uploads/images/departments/$name");
//            $item->image=$name;
//        }

        $item->save();
        if($request->years != null){
            foreach($request->years as $one){
                $values[] = [
                    'department_id' => $item->id,
                    'year_id' => $one,

                ];
            }
            DepartmentYear::insert($values);

        }
        return redirect()->back()->with('status', __('cp.create'));

    }



    public function edit($id)
    {
        $item = Department::findOrFail($id);
        $faculties=Faculty::all();
        $years=Year::all();

        return view('admin.departments.edit',compact('item','faculties','years'));
    }

    public function update(Request $request, $id)
    {
//        return $request;
        $item = Department::findOrFail($id);

        $roles = [
            'faculty_id'=>'required',
//            'image' => 'image|mimes:jpeg,jpg,png,gif',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item->faculty_id=$request->faculty_id;
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
//        if ($request->hasFile('image')) {
//            $image = $request->file('image');
//            $extention = $image->getClientOriginalExtension();
//
//            $name = Str::random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) .'.' . $extention;
//
//            Image::make($image)->resize(800, null, function ($constraint) {
//                $constraint->aspectRatio();
//            })->save("uploads/images/departments/$name");
//            $item->image=$name;
//        }

        $item->save();
        if($request->years != null){
            foreach($request->years as $one){
                $values[] = [
                    'department_id' => $item->id,
                    'year_id' => $one,

                ];
            }
            DepartmentYear::where('department_id',$item->id)->delete();
            DepartmentYear::insert($values);

        }
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function destroy($id)
    {
        $item = Department::query()->findOrFail($id);
        if ($item) {
            Department::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function getYears(Request $request)
    {
        $id = $request->id;
        $items = DepartmentYear::where('department_id',$id)->with('year')->get();
        return response()->json([
            'items' => $items
        ]);
    }

    public function getCourses(Request $request)
    {
        $id = $request->id;
        $items = Course::where('department_id',$id)->get();
        return response()->json([
            'items' => $items
        ]);
    }
}
