<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Partner;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Riverline\MultiPartParser\Part;

class PartnersController extends Controller
{
    public function __construct()
    {
        $this->locales = Language::all();
        $this->settings = Setting::query()->first();
        view()->share([
            'locales' => $this->locales,
            'settings' => $this->settings,

        ]);


        $route=Route::currentRouteAction();
        $route_name = substr($route, strpos($route, "@") + 1);
        $this->middleware(function ($request, $next) use($route_name){
            if(can('partners')){
                return $next($request);
            }
            if($route_name== 'index' ){
                if(can(['partners-show' , 'partners-create' , 'partners-edit' , 'partners-delete'])){
                    return $next($request);
                }
            }elseif($route_name== 'create' || $route_name== 'store'){
                if(can('partners-create')){
                    return $next($request);
                }
            }elseif($route_name== 'edit' || $route_name== 'update'){
                if(can('partners-edit')){
                    return $next($request);
                }
            }elseif($route_name== 'destroy' || $route_name== 'delete'){
                if(can('partners-delete')){
                    return $next($request);
                }
            }else{
                return $next($request);
            }
            return redirect()->back()->withErrors(__('cp.you_dont_have_permission'));
        });

    }
    public function index()
    {
        $items = Partner::orderBy('id', 'desc')->get();
        return view('admin.partners.home', [
            'items' =>$items,
        ]);
    }

    public function create()
    {
        //
        return view('admin.partners.create');
    }


    public function store(Request $request)
    {
        $roles = [
            'status'=>'required',
            'link'=>'required|url',
            'image' => 'required|image|mimes:jpeg,jpg,png',
        ];

        $this->validate($request, $roles);

        $item= new Partner();
        $item->status=$request->get('status');
        $item->link=$request->get('link');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extention = $image->getClientOriginalExtension();

            $name = Str::random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) .'.' . $extention;

            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploads/images/partners/$name");
            $item->image=$name;
        }



        $item->save();
        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $item = Partner::findOrFail($id);
        return view('admin.partners.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $roles = [
            'status'=>'required',
            'link'=>'required|url',
            'image' => 'image|mimes:jpeg,jpg,png',
        ];

        $this->validate($request, $roles);



        $item = Partner::query()->findOrFail($id);
        $item->status=$request->get('status');
        $item->link=$request->get('link');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extention = $image->getClientOriginalExtension();

            $name = Str::random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) .'.' . $extention;

            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploads/images/partners/$name");
            $item->image=$name;
        }

        $item->save();
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function destroy($id)
    {
        //
        $ad = Partner::query()->findOrFail($id);
        if ($ad) {
            Partner::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
