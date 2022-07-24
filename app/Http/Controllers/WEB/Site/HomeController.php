<?php

namespace App\Http\Controllers\WEB\Site;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\File;
use App\Models\LandingPage;
use App\Models\Partner;
use App\Models\Setting;
use App\Models\Language;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Page;
use App\Models\ScreensSlider;
use App\Models\Banner;
use App\Models\Favorite;
use App\Models\SubscribeEmail;

use App\Models\Video;
use Carbon\Carbon;
use Doctrine\Inflector\Rules\Pattern;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\User;

use Auth;
use App\Http\Controllers\Controller;

use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\RequestException;

class HomeController extends Controller
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
    public function home()
    {
      $items=Faculty::where('status','active')->get();
      $partners = Partner::where('status','active')->orderByDesc('id')->get();
        return view('website.home',[
            'items'=> $items,
            'partners'=> $partners,
            ]);
    }

    public function departments($id)
    {
      $faculty = Faculty::where('id',$id)->first();
      $items=Department::where('faculty_id',$id)->where('status','active')->get();
        return view('website.departments',[
            'faculty'=> $faculty,
            'items'=> $items,
            ]);
    }



    public function courses($id,$year_id)
    {
        $department = Department::where('id',$id)->first();
        $faculty = Faculty::where('id',$department->faculty_id)->first();
        $items=Course::where('department_id',$id)->where('year_id',$year_id)->where('status','active')->get();
        return view('website.courses',[
            'items'=> $items,
            'department'=> $department,
            'faculty'=> $faculty,
            ]);
    }

    public function videos($id,$main_video)
    {
        $course = Course::where('id',$id)->first();
        $items=Video::where('course_id',$id)->where('status','active')->get();
        $main_video_content = Video::where('id',$main_video)->where('status','active')->first();

        $comments = Comment::where('video_id',$main_video_content->id)->orderByDesc('id')->get();
        return view('website.videos',[
            'items'=> $items,
            'course'=> $course,
            'main_video'=> $main_video_content,
            'comments'=> $comments,
            ]);
    }

    public function files($id)
    {
        $course = Course::where('id',$id)->first();
        $items=File::where('course_id',$id)->where('status','active')->get();
        return view('website.files',[
            'items'=> $items,
            'course'=> $course,
            ]);
    }



    public function addFavorite($id){
        $item = new Favorite();
        $item->video_id = $id;
        if (auth()->check()) {
            $item->user_id = auth('web')->id();
        }
        if (Session::get('cart.ids') != null) {
            $item->user_key = Session::get('cart.ids');
        } else {
            $item->user_key = uniqid() . $id. str_random(10);
        }
        $item->save();

        $cart = [
            "ids" => $item->user_key,
        ];

        Session::put('cart', $cart);


        return response()->json([
            'status' => 'success',
        ]);
    }

    public function removeFavorite($id){
        if (Favorite::where(function ($q){
            $q->where('user_key', Session::get('cart.ids'))->orWhere('user_id', auth('web')->id());
        })->where('video_id', $id)->first()){
            Favorite::where(function ($q){
                $q->where('user_key', Session::get('cart.ids'))->orWhere('user_id', auth('web')->id());
            })->where('video_id', $id)->delete();
        }

        return response()->json([
            'status' => 'success',
        ]);

    }

    public function comment(Request $request , $id){

        $roles = [
            'comment'=>'required',
        ];

        $this->validate($request, $roles);

        $item = new Comment();
        $item->comment = $request->comment;
        $item->user_id = 1;
//        $item->user_id = auth('web')->id();
        $item->video_id = $id;
        $item->save();
        $comments = Comment::where('video_id',$id)->orderByDesc('id')->get();
        $view = view('includes.comments')->with(compact('comments'))->render();

        return response()->json([
            'status' => 'success','html' => $view,
        ]);
    }

    public function requirements(){
        $items = Course::query()->where('is_requirement','1')->where('status','active')->orderByDesc('id')->get();
        return view('website.requirements')->with(compact('items'));
    }



    public function requirementVideos($id,$main_video)
    {
        $course = Course::where('id',$id)->first();
        $items=Video::where('course_id',$id)->where('status','active')->get();
        $main_video = Video::where('id',$main_video)->where('status','active')->first();
        $comments = Comment::where('video_id',$main_video->id)->orderByDesc('id')->get();
        return view('website.requirement_videos',[
            'items'=> $items,
            'course'=> $course,
            'main_video'=> $main_video,
            'comments'=> $comments,
        ]);
    }


    public function requirementFiles ($id,$main_video)
    {
        $course = Course::where('id',$id)->first();
        $items=File::where('course_id',$id)->where('status','active')->get();
        return view('website.requirements_files',[
            'items'=> $items,
            'course'=> $course,
        ]);
    }



    public function about(){
     return view('website.about');
    }


}

