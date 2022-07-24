<?php

namespace App\Http\Controllers\WEB\Site;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\LandingPage;
use App\Models\Setting;
use App\Models\Language;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Page;
use App\Models\Cart;
use App\Models\Area;
use App\Models\Order;
use App\Models\UserAddress;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Session;
use App\Http\Controllers\Controller;

use Dotenv\Exception\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\RequestException;

class UsersController extends Controller
{
 public function __construct()
    {
        $this->locales = Language::all();
        $this->settings = Setting::query()->first();
        view()->share([
            'locales' => $this->locales,
            'settings' => $this->settings,

        ]);

}
    public function loginView()
    {
//     $type=   \Request::route()->getName();
    return view('website.login');
}


    public function loginPost(Request $request)
    {

        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'validator' =>implode("\n",$validator-> messages()-> all()) ,'code'=>400 ]);
        }

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $conditions = ['email' => $request->email, 'password' => $request->password];
        }
        else {
            $conditions = ['mobile' => $request->email, 'password' => $request->password];
        }
        if (Auth::attempt($conditions)) {
                if (Auth::user()->status == 'active') {
                    $user = Auth::user();
                    return redirect(route('home'));

                } else {
                    auth()->logout();

                    return response()->json(['message' => __('website.AccountNotActive') ,'code'=>403]);
                }
        }
        $message = __('website.emailOrpassword_incorrect');
        return response()->json(['status' => false, 'code' => 403 ,'message'=>$message]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
         Session::forget('cart.ids');

        return redirect('/');
    }

    public function registerPost (Request $request)
    {
        $settings = Setting::query()->first();

        $validator = Validator::make($request->all(), [
             'mobile' => 'required|min:9|max:10|unique:users',//regex:/(05)[0-9]{8}/
            'email' => 'required|email:filter|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
            'name' => 'required|min:3',


        ]);
        if ($validator->fails()) {
            return response()->json([
                'validator' =>implode("\n",$validator-> messages()-> all()) ,'code'=>400 ]);
        }
        $newUser = new User();
        $newUser->name = $request->name;
        $newUser->password = bcrypt($request->password);
         $newUser->mobile = $request->mobile;
        $newUser->email = $request->email;
        // $newUser->registration_language = app()->getLocale();
        // $newUser->last_login_at=Carbon::now()->toDateTimeString();
        $done = $newUser->save();
        if ($done) {

            $conditions = ['email'=>$request->email,'password' => $request->password];
                 if (Auth::attempt($conditions)) {
                        $user = Auth::user();
                        return redirect(route('home'));
                 }

        } else {
            return redirect()->back()->withErrors([ __('site.Whoops')])->withInput();
        }
    }


       public function changePassword()
    {
         return view('website.user.change_password',[
            ]);
    }


     public function updatePassword(Request $request)
    {
        $rules = [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 400,
                'validator' =>implode("\n",$validator-> messages()-> all())]);
        }
        $user = auth()->user();

        if (!Hash::check($request->get('old_password'), $user->password)) {
            $message = __('api.wrong_old_password'); //wrong old
            return response()->json(['status' => false, 'code' => 300,'message' => $message ]);
        }

        $user->password = bcrypt($request->get('password'));

        if ($user->save()) {
            $user->refresh();
            $message = __('api.ok');
            return response()->json(['status' => true, 'code' => 200,'message' => $message ]);
        }
        $message = __('api.whoops');
        return response()->json(['status' => false, 'code' => 500,'message' => $message ]);
    }



       public function myProfile()
    {
         return view('website.profile',[
            ]);
    }


    public function editMyProfile(){
     return view('website.edit_profile');
    }

        public function updateMyProfile(Request $request)
    {
//        return $request;
        $user_id = auth('web')->id();
        $user = User::query()->where('id',$user_id)->first();
        $roles = [
//            'image' => 'image|mimes:jpeg,jpg,png,gif',
            'name' => 'required',
            'email' => 'email|unique:users,email,' . $user->id,
            'mobile' => 'nullable|digits_between:8,12|unique:users,mobile,'.$user->id,
        ];

        $this->validate($request, $roles);

        $name = ($request->has('name')) ? $request->get('name') : $user->name;
        $email = ($request->has('email')) ? $request->get('email') : $user->email;
        $mobile = (convertAr2En($request->get('mobile'))) ? $request->get('mobile') : $user->mobile;

        $user->name = $name;
        $user->email = $email;
        $user->mobile = $mobile;
//        if ($request->hasFile('image')) {
//            $image = $request->file('image');
//            $extention = $image->getClientOriginalExtension();
//
//            $name = Str::random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) .'.' . $extention;
//
//            Image::make($image)->resize(800, null, function ($constraint) {
//                $constraint->aspectRatio();
//            })->save("uploads/images/users/$name");
//            $user->image=$name;
//        }
        $user->save();
        if ($user) {
//            $user = User::query()->findOrFail($user_id);
//            $user['access_token'] = $user->createToken('mobile')->accessToken;
            return redirect(route('profile'));

        } else {
            return redirect()->back()->withErrors([ __('site.Whoops')])->withInput();
        }
    }


    public function favorite(Request $request)
    {
        $items = Favorite::where(function ($q){
            $q->where('user_key', \Illuminate\Support\Facades\Session::get('cart.ids'))->orWhere('user_id', auth('web')->id());
        })->get();
        return view('website.favorite', [
            'items' =>$items,
        ]);
    }

}

