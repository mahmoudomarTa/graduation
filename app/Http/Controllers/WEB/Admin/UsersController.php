<?php

namespace App\Http\Controllers\WEB\Admin;


use App\Exports\UsersExport;
use App\Models\Favorite;
use App\Models\Subscribtion;
use App\Models\Setting;
use App\Models\User;
use App\Models\Video;
use Dotenv\Exception\ValidationException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Image;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->settings = Setting::query()->first();
        view()->share([
            'settings' => $this->settings,
        ]);

        $route=Route::currentRouteAction();
        $route_name = substr($route, strpos($route, "@") + 1);
        $this->middleware(function ($request, $next) use($route_name){
            if(can('users')){
                return $next($request);
            }
            if($route_name== 'index' ){
                if(can(['users-show' ,  'users-edit' , 'users-delete'])){
                    return $next($request);
                }
            }elseif($route_name== 'edit' || $route_name== 'update'){
                if(can('users-edit')){
                    return $next($request);
                }
            }elseif($route_name== 'destroy' || $route_name== 'delete'){
                if(can('users-delete')){
                    return $next($request);
                }
            }else{
                return $next($request);
            }
            return redirect()->back()->withErrors(__('cp.you_dont_have_permission'));
        });
    }

    public function index(Request $request)
    {
        $items = User::query()->filter()->orderBy('id', 'desc')->paginate($this->settings->paginate);

        return view('admin.users.home', [
            'items' => $items,
        ]);


    }


    public function create()
    {
       return view('admin.users.create');
    }

    public function show($id)
    {

        $item = User::where('id', $id)->first();
        $favorite_count=Favorite::where('user_id',$id)->count();
        return view('admin.users.show', [
            'item' => $item,
            'favorite_count'=>$favorite_count,
        ]);


    }

    public function store(Request $request)
    {

        $roles =[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'digits_between:8,13|unique:users,mobile',
            'status'=>'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password|min:6',
        ];
        $this->validate($request, $roles);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->status = $request->status;
        $user->password=bcrypt($request->password);
        $user->save();


        return redirect()->back()->with('status', __('cp.create'));

    }


    public function edit($id)
    {

        $item = User::findOrFail($id);
        return view('admin.users.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $roles =[
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'digits_between:8,13,mobile',
            'status'=>'required',
        ];
        $this->validate($request, $roles);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->status = $request->status;
        $user->save();

        return redirect()->back()->with('status', __('cp.update'));
    }


    public function edit_password($id)
    {
        $item = User::findOrFail($id);
        return view('admin.users.edit_password', ['item' => $item]);
    }


    public function update_password(Request $request, $id)
    {
        $users_rules = array(
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password|min:6',
        );
        $users_validation = Validator::make($request->all(), $users_rules);

        if ($users_validation->fails()) {
            return redirect()->back()->withErrors($users_validation)->withInput();
        }
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('status', __('cp.update'));
    }

    public function destroy($id)
    {
        $item = User::query()->findOrFail($id);
        if ($item) {
            User::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }


    public function exportUsers(Request $request)
    {
        return Excel::download(new UsersExport($request), 'users.xlsx');
    }


}
