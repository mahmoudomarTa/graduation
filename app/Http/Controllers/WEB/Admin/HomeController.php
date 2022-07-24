<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Models\Admin;
use App\Models\Course;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Subscribtion;
use App\Models\User;
use App\Models\Permission;
use App\Models\Setting;
use App\Models\Area;
use App\Models\AreaRequest;
use App\Models\Car;
use App\Models\PromotionCode;
use App\Models\OrderProduct;
use App\Models\Order;


use App\Models\Contact;
use App\Models\Booking;

use App\Models\Video;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class HomeController extends Controller
{

    public function index()
    {

        $count_faculties = Faculty::count();
        $count_departments = Department::count();
        $count_courses = Course::count();
        $count_videos = Video::count();
        $count_users = User::count();

        return view('admin.home.dashboard', [
            'count_users' => $count_users,
            'count_videos' => $count_videos,
            'count_courses' => $count_courses,
            'count_departments' => $count_departments,
            'count_faculties' => $count_faculties,
        ]);
    }


    public function changeStatus($model, Request $request)
    {
        $role = "";
        if ($model == "admins") $role = 'App\Models\Admin';
        if ($model == "users") $role = 'App\Models\User';
        if ($model == "faculties") $role = 'App\Models\Faculty';
        if ($model == "departments") $role = 'App\Models\Department';
        if ($model == "courses") $role = 'App\Models\Course';
        if ($model == "requirements") $role = 'App\Models\Course';
        if ($model == "videos") $role = 'App\Models\Video';
        if ($model == "requirementsVideos") $role = 'App\Models\Video';
        if ($model == "files") $role = 'App\Models\File';
        if ($model == "requirementsFiles") $role = 'App\Models\File';
        if ($model == "roles") $role = 'App\Models\Role';

        if ($role != "") {
            if ($request->action == 'delete') {
                $role::query()->whereIn('id', $request->IDsArray)->delete();
            } else {
                if ($request->action) {
                    $role::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->action]);
                }
            }

            return $request->action;
        }
        return false;


    }


}
