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

class RequirementController extends Controller
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
        $items = Course::filter()->where('is_requirement','1')->orderBy('id', 'desc')->get();
        return view('admin.requirements.home', [
            'items' =>$items,
        ]);
    }


    public function create()
    {
        return view('admin.requirements.create');
    }


    public function store(Request $request)
    {

        $roles = [
            'name'=>'required',
            'status'=>'required',
        ];

        $this->validate($request, $roles);


        $item = new Course();
        $item->name=$request->name;
        $item->status=$request->status;
        $item->is_requirement ='1';

        $item->save();

        return redirect()->back()->with('status', __('cp.create'));

    }



    public function edit($id)
    {
        $item = Course::findOrFail($id);
         return view('admin.requirements.edit')->with(compact('item'));
    }

    public function update(Request $request, $id)
    {
//        return $request;
        $item = Course::findOrFail($id);

        $roles = [
            'name'=>'required',
            'status'=>'required',
        ];

        $this->validate($request, $roles);
        $item->name=$request->name;
        $item->status=$request->status;
        $item->is_requirement ='1';

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
