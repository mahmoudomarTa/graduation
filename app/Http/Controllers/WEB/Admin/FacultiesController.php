<?php

namespace App\Http\Controllers\WEB\Admin;


use App\Models\Department;
use App\Models\Faculty;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

class FacultiesController extends Controller
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
         if(can('faculties')){
            return $next($request);
         }
          if($route_name== 'index' ){
             if(can(['faculties-show' , 'faculties-create' , 'faculties-edit' , 'faculties-delete'])){
                 return $next($request);
             }
          }elseif($route_name== 'create' || $route_name== 'store'){
              if(can('faculties-create')){
                 return $next($request);
             }
          }elseif($route_name== 'edit' || $route_name== 'update'){
              if(can('faculties-edit')){
                 return $next($request);
             }
          }elseif($route_name== 'destroy' || $route_name== 'delete'){
              if(can('faculties-delete')){
                 return $next($request);
             }
          }else{
              return $next($request);
          }
          return redirect()->back()->withErrors(__('cp.you_dont_have_premession'));
        });

    }

    public function index(Request $request){
        $items = Faculty::filter()->orderBy('id', 'desc')->get();
        return view('admin.faculties.home', [
            'items' =>$items,
        ]);
    }





    public function create()
    {
        return view('admin.faculties.create');
    }


    public function store(Request $request)
    {
        $roles = [
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);


        $item = new Faculty();
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extention = $image->getClientOriginalExtension();

            $name = Str::random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) .'.' . $extention;

            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploads/images/faculties/$name");
            $item->image=$name;
        }

        $item->save();

        return redirect()->back()->with('status', __('cp.create'));

    }



    public function edit($id)
    {
        $item = Faculty::findOrFail($id);
        return view('admin.faculties.edit',compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Faculty::findOrFail($id);

        $roles = [
            'image' => 'image|mimes:jpeg,jpg,png,gif',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extention = $image->getClientOriginalExtension();

            $name = Str::random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) .'.' . $extention;

            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploads/images/faculties/$name");
            $item->image=$name;
        }

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));
    }

    public function destroy($id)
    {
        $item = Faculty::query()->findOrFail($id);
        if ($item) {
            Faculty::query()->where('id', $id)->delete();
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
