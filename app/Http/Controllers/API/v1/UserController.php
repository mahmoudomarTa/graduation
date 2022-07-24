<?php

namespace App\Http\Controllers\API\v1;
use App\Admin;
use App\Models\UserService;

use App\Notifications\ResetPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Token;
use App\Models\Setting;
use App\Models\Language;
use App\Models\Notify;
use Illuminate\Support\Facades\Mail;
use App\Models\Following;
use App\Models\VerificationCode;
use App\Models\Notifiy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Image;
use DB;


class UserController extends Controller
{
    use SendsPasswordResetEmails;

    protected $paginateTotal = '';
    protected $settings = '';
    public function __construct(){
        $this->settings = Setting::orderBy('id', 'desc')->first();
        $this->paginateTotal = $this->settings->paginateTotal;
    }

    
    public function broker()
    {
        return Password::broker('users');
    }
    public function image_extensions()
    {
       
        return array('jpg', 'png', 'jpeg', 'gif', 'bmp');
    } 

    public function signUp(Request $request)
    {
        $setting=Setting::query()->first();

        $validator = Validator::make($request->all(), [

           'name' => 'required',
           'mobile' => 'digits_between:8,12|unique:users',
           'password' => 'required|min:6',
           'type' => 'required|in:1,2,3',
           'city_name' => 'required',
        //    'latitude' => 'required_if:type,==,2',
        //    'longitude' => 'required_if:type,==,2',
        ]);
     
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' =>implode("\n",$validator-> messages()-> all()) ]);
        }
 
        $newUser = new User();
        $newUser->name = $request->get('name');;
        // $newUser->email = $request->get('email');
        $newUser->city_name = $request->get('city_name');
        $newUser->type = $request->get('type');
        $newUser->mobile = convertAr2En($request->get('mobile')) ;
        $newUser->password = bcrypt($request->get('password'));
        $newUser->save();

        if ($newUser) {
            if ($request->has('fcm_token')) {
                Token::updateOrCreate(['device_type' => $request->get('device_type'),'fcm_token' => $request->get('fcm_token'),'lang'=>app()->getLocale()],['user_id' => $newUser->id]);
            }
 
        $user=User::findOrFail($newUser->id);
        Auth::login($user);
        $user['access_token'] = $user->createToken('mobile')->accessToken;
                
        $message = __('api.ok');
        return response()->json(['status' => true, 'code' => 200, 'message' => $message,'user'=>$user]);
        }
        $massege =__('api.whoops');
        return response()->json(['status' => false, 'code' => 200, 'message' => $massege ]);
    }

    public function login(Request $request)
    {
        $mobile = $request->get('mobile');
        $password = $request->get('password');

        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' => implode("\n",$validator-> messages()-> all()) ]);
        }

        if (filter_var($request->mobile, FILTER_VALIDATE_EMAIL)) {
            $conditions = ['email' => $request->mobile, 'password' => $request->password];
        }
        else {
            $conditions = ['mobile' => $request->mobile, 'password' => $request->password];
        }
        
        if (Auth::once($conditions)) {

            $user = Auth::user();
            if ($user->status == 'not_active') {
                $message = (app()->getLocale() == "ar") ? 'الحساب غير مفعل' : 'The account is not active';
                return response()->json(['status' => false, 'code' => 210, 'message' =>
                    $message ]);
            }else {
                if ($request->has('fcm_token')) {
                    Token::updateOrCreate(['device_type' => $request->get('device_type'),'fcm_token' => $request->get('fcm_token')],['user_id' => $user->id]);
                }
                $user=User::findOrFail($user->id);
                $user['access_token'] = $user->createToken('mobile')->accessToken;


                return response()->json(['status' => true, 'code' => 200 ,'user' => $user]);
            }
        } else {
                $message = __('api.wrongLoginEmail');
                return response()->json(['status' => false, 'code' => 200 , 'message'=>$message ]);

        }
    }



    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile'=>'required',
        ]);
        //  return redirect()->back()->with('error','The email is required');
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' =>implode("\n",$validator-> messages()-> all()) ]);
        }
        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            $message = 'The mobile not found';
            return response()->json(['status' => false, 'code' => 200,'message' => $message ]);
        }
        // $token = $this->broker()->createToken($user);
        // $url = url('/password/reset/' . $token);
        // $user->notify(new ResetPassword($token));
        $message=__('api.resetPassword');
        return response()->json(['status' => true, 'code' => 200,'message' => $message ]);
    }

    public function editUserProfile(Request $request)
    {
        $user_id = auth('api')->id();
        $user = User::query()->findOrFail($user_id);
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'mobile' => 'email|unique:users,mobile,'.$user->id,
            'city_name' => 'required',
            'id_number' => 'required',
            'birth_date' => 'required',
            ]);
        $name = ($request->has('name')) ? $request->get('name') : $user->name;
        $city_name = ($request->has('city_name')) ? $request->get('city_name') : $user->city_name;
        $id_number = ($request->has('id_number')) ? $request->get('id_number') : $user->id_number;
        $birth_date = ($request->has('birth_date')) ? $request->birth_date : $user->birth_date;
        $mobile = (convertAr2En($request->get('mobile'))) ? $request->get('mobile') : $user->mobile;

        $user->name = $name;
        $user->mobile = $mobile;
        $user->city_name = $city_name;
        $user->id_number = $id_number;
        $user->birth_date = $birth_date;

        if ($request->hasFile('image_profile')) {
            $imageProfile = $request->file('image_profile');
            $extention = $imageProfile->getClientOriginalExtension();
            $file_name = str_random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) . "." . $extention;
            Image::make($imageProfile)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploads/images/users/$file_name");
            $user->image_profile = $file_name;
        }
        
        $user->save();
 
        if ($user) {
    
            if ($request->has('fcm_token')) {
                Token::updateOrCreate(['device_type' => $request->get('device_type'),'fcm_token' => $request->get('fcm_token')],['user_id' => $user->id]);
            }
            $user = User::query()->findOrFail($user_id);
            $user['access_token'] = $user->createToken('mobile')->accessToken;

            $message = __('api.ok');
                return response()->json(['status' => true, 'code' => 200, 'message' => $message,'user'=>$user]);
        } else {
            $message = __('api.not_edit');
            return response()->json(['status' => false, 'code' => 200,
                'message' => $message, 'validator' => $validator ]);
        }
    }

    public function changePassword(Request $request)
    {
        $rules = [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200,
                'message' =>implode("\n",$validator-> messages()-> all())]);
        }
        $user = auth('api')->user();

        if (!Hash::check($request->get('old_password'), $user->password)) {
            $message = __('api.wrong_old_password'); //wrong old
            return response()->json(['status' => false, 'code' => 200,'message' => $message ]);
        }

        $user->password = bcrypt($request->get('password'));

        if ($user->save()) {
            $user->refresh();
            $message = __('api.ok');
            return response()->json(['status' => true, 'code' => 200,'message' => $message ]);
        }
        $message = __('api.whoops');
        return response()->json(['status' => false, 'code' => 200,'message' => $message ]);
    }

    public function logout(Request $request)
    {
        $user_id = auth('api')->id();
        
         if ($request->has('fcm_token')) {
                 
                Token::where('fcm_token' , $request->get('fcm_token'))->delete();
            }
        if (auth('api')->user()->token()->revoke()) {
            $message = 'logged out successfully';
            return response()->json(['status' => true, 'code' => 200,
                'message' => $message ]);
        } else {
            $message = 'logged out successfully';
            return response()->json(['status' => true, 'code' => 202,
                'message' => $message ]);
        }
    }
    
    public function updateMyLanguage(Request $request){

             $user_id= auth('api')->id();
                Token::where('fcm_token',$request->get('fcm_token'))->update(['lang' => $request->get('lang')]);
 
           
                $message = __('api.ok');
                return response()->json(['status' => true, 'code' => 200,'message' => $message]);
      
    }
    public function updateMyServices(Request $request){

             $user_id= auth('api')->id();
  
             if($request->services != null){     
                foreach($request->services as $service_id){
                    $values[] = [
                        'service_id' => $service_id,   
                        'user_id' => auth('api')->id(),  
                    ];       
                }         
                UserService::where('user_id',auth('api')->id())->delete();
                UserService::insert($values);
            }
                $message = __('api.ok');
                return response()->json(['status' => true, 'code' => 200,'message' => $message]);
      
    }
    
    public function updateMyLocation(Request $request){
             $user_id= auth('api')->id();
             $validator = Validator::make($request->all(), [
                'latitude' => 'required',
                'longitude' => 'required',
             ]);
          
             if ($validator->fails()) {
                 return response()->json(['status' => false, 'code' => 200,
                     'message' =>implode("\n",$validator-> messages()-> all()) ]);
             }
             $user=User::findOrFail($user_id);
             $user->latitude =$request->latitude;
             $user->longitude =$request->longitude;
             $user->zip_code =$request->zip_code;
             $user->save();
                $message = __('api.ok');
                return response()->json(['status' => true, 'code' => 200,'message' => $message]);
      
    }
    

    public function notifications(){
        $data = Notifiy::where('user_id',auth('api')->id())->orderBy('id','desc')->paginate($this->paginateTotal)->items();
        $is_there_more = ($this->paginateTotal > count($data) )? 'no':'yes';
        $message = __('api.ok');
        return response()->json(['status' => true, 'code' => 200,'message' => $message,'items'=>$data ,'is_there_more'=>$is_there_more]);
    }

    public function myFollowers(){
        $followers =  Following::where('userTo' ,auth('api')->id())->with('fromuser:id,name,image_profile')->paginate($this->paginateTotal)->items();
        $is_there_more = ($this->paginateTotal > count($followers) )? 'no':'yes';
        return response()->json(['status' => true, 'code' => 200, 'message' => '', 'followers'=>$followers,'is_there_more'=>$is_there_more]);
    }

    public function myFollowings(){
        $followings =  Following::where('userFrom' ,auth('api')->id())->with('touser:id,name,image_profile')->paginate($this->paginateTotal)->items();
        $is_there_more = ($this->paginateTotal > count($followings) )? 'no':'yes';
        return response()->json(['status' => true, 'code' => 200, 'message' => '', 'followings'=>$followings,'is_there_more'=>$is_there_more]);
    }

    public function follow($user_id){
        $user = User::where('id','<>',auth('api')->id())->findOrFail($user_id);

        $check = Following::where(['userFrom'=>auth('api')->id() ,'userTo'=>$user_id])->first();
        if($check){
            return response()->json(['status' => false, 'code' => 200, 'message' => __('api.alreadyFollowing')]);
        }
        $new = new Following();
        $new->userFrom = auth('api')->id();
        $new->userTo = $user_id;
        $done = $new->save();
        if($done) {
            
          dispatch(function () use ($user_id) {
                
             User::where('id',$user_id)->increment('total_followers');
             User::where('id',auth('api')->user()->id)->increment('total_followings');
 
             $en_message = 'Start follw you';
             $ar_message = 'بدا بمتابعتك';
            $action_type = 'follow';
            $object_id = auth('api')->id();
            $tokens = Token::where('user_id',$user_id)->pluck('fcm_token')->toArray();
            $en_tokens = Token::where('user_id',$user_id)->where('lang','en')->pluck('fcm_token')->toArray();
            // $ar_tokens = Token::where('user_id',$user_id)->where('lang','ar')->pluck('fcm_token')->toArray();
             sendNotificationToUsers( $en_tokens, $action_type, $object_id, $en_message );
            //  sendNotificationToUsers( $ar_tokens, $action_type, $object_id, $ar_message );
             
            $notifiy= New Notifiy();
             $notifiy->translateOrNew('en')->message = $en_message;
             $notifiy->translateOrNew('ar')->message = $ar_message;
            $notifiy->user_id = $user_id;
            $notifiy->order_id = $object_id;
           // $notifiy->message = $message;
            $notifiy->save(); 
                         
                 })->afterResponse();
            return response()->json(['status' => true, 'code' => 200, 'message' => __('api.ok')]);
        }
        else{
            return response()->json(['status' => false, 'code' => 200, 'message' => __('api.whoops')]);
        }
    }

    public function unfollow($user_id){
        User::findOrFail($user_id);

       
        $item= Following::where('userFrom',auth('api')->id())->where('userTo',$user_id)->first();
        if($item){
            Following::where(['userFrom'=>auth('api')->id() ,'userTo'=>$user_id])->delete();
            User::where('id',$user_id)->decrement('total_followers');
            User::where('id',auth('api')->user()->id)->decrement('total_followings');
            
           return response()->json(['status' => true, 'code' => 200, 'message' => __('api.ok')]);
        }else{
            return response()->json(['status' => false, 'code' => 200, 'message' => __('api.whoops')]);
        }
        
        
    }


}
