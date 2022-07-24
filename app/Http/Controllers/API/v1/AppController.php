<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Resources\ProductResource;
use App\Models\Ad;
use App\Models\Age;
use App\Models\Faq;
use App\Models\Section;

use App\Models\Company;
use App\Models\Product;
use App\Models\Question;
use App\Models\VehicleCategory;
use App\Models\City;
use App\Models\Cart;
use App\Models\Service;
use App\Models\VehicleType;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Workrequest;
use App\Models\Banner;
use App\Models\Area;
use App\Models\CarOption;
use App\Models\Brand;
use App\Models\Token;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\FuelType;
use App\Models\BodyType;
use App\Models\RegionalSpecs;
use App\Models\Mileage;
use App\Models\KeyFactorQustion;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use Illuminate\Support\Facades\Validator;


class AppController extends Controller
{
    public function __construct()
    {
        $this->paginate = 15;

    }

    public function getVehicleCategories()
    {
        $data = VehicleCategory::query()->where('status', 'active')->get();
        $message = __('api.ok');
        return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'items' => $data]);

    }
    public function getVehicleTypes($id)
    {
        $data = VehicleType::query()->where('vehicle_category_id',$id)->where('status', 'active')->get();
        $message = __('api.ok');
        return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'items' => $data]);

    }

    public function getAges()
    {
        $data = Age::query()->where('status', 'active')->get();
        $message = __('api.ok');
        return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'items' => $data]);

    }

    public function getAreas()
    {
        $data = Area::query()->where('status', 'active')->get();
        $message = __('api.ok');
        return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'items' => $data]);

    }

    public function getFaqs()
    {
        $questions = Faq::query()->where('status', 'active')->get();
        $message = __('api.ok');
        return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'items' => $questions]);
    }

    public function getProducts(Request $request)
    {
        if ($request->category_id == null) {
            $data = Category::query()->where('status', 'active')->has('products')->get();
            foreach ($data as $one ){
                $one['products'] = Product::where('status' , 'active')->where('category_id' , $one->id)->orderByDesc('id')->take(10)->get();
            }
            $message = __('api.ok');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'items' => $data]);
        } elseif (isset($request->category_id) && $request->category_id != null) {
            $data = Product::query()->where('status', 'active')->where('category_id', $request->category_id)
                ->paginate($this->paginate)->items();
            $check = ($this->paginate > count($data)) ? false : true;
            $message = __('api.ok');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'items' => $data, 'is_more' => $check]);
        }

    }

    public function getProductDetails($id)
    {
        $product = Product::query()->findOrFail($id);
        $message = __('api.ok');
        return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'item' => $product]);
    }

    public function getSetting()
    {

        $settings = Setting::query()->first();
        $settings['pages'] = Page::get();
        $message = __('api.ok');
        return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'settings' => $settings]);

    }

    public function updateMyLanguage(Request $request)
    {

        Token::updateOrCreate(['fcm_token' => $request->get('fcmToken'), 'device_type' => $request->get('type_mobile'),
            'lang' => $request->get('lang')]);

        $message = __('api.ok');
        return response()->json(['status' => true, 'code' => 200, 'message' => $message]);
    }

    public function pages($id)
    {
        $page = Page::where('id', $id)->first();
        $message = __('api.ok');
        return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'page' => $page]);
    }

    public function contactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
//            'mobile' => 'required|digits_between:8,13',
            'name' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200, 'validator' => implode("\n", $validator->messages()->all())]);
        }

        $contact = new  Contact();
        $contact->email = $request->get('email');
        $contact->name = $request->get('name');
//        $contact->mobile = $request->get('mobile');
        $contact->message = $request->get('message');
        $contact->read = 0;
        $contact->save();

        $message = __('api.ok');

        return response()->json(['status' => true, 'code' => 200, 'message' => $message]);

    }

    public function filter(Request $request)
    {
        if($request->age == null   && $request->category == null  && $request->gender == null && $request->search == null){
             $message = __('api.ok');
             return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'items' => [] , 'is_more' => false]);
        }else{
        $products = Product::query();
        if ($request->has('age') && $request->age != null) {
            $products->where('age_id', $request->age);
        }
        if ($request->has('category') && $request->category != null) {
            $products->where('category_id', $request->category);
        }
        if ($request->has('gender') && $request->gender != null) {
            $products->where('gender', $request->gender);
        }
         if ($request->has('search') && $request->search != null) {
            $products->where(function ($q) {
                $q->whereTranslationLike('name', '%' . request()->get('search') . '%')
                    ->orWhereTranslationLike('description', '%' . request()->get('search') . '%');
            });
        }
        $products = $products->where('status', 'active')->paginate($this->paginate)->items();
        $check = ($this->paginate > count($products)) ? false : true;
        $message = __('api.ok');
        return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'items' => $products, 'is_more' => $check]);
    }
}
  
}
