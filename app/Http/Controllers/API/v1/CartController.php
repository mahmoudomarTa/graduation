<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Area;
use App\Models\CartAddition;
use App\Models\City;
use App\Models\Setting;

use App\Models\Order;
use App\Models\OrderProduct;

use App\Models\Cart;
use App\Models\Product;
use App\Models\UserWallet;

use App\Models\Rate;
use App\Models\OrderProductAddition;
use App\Models\AreaDelivaryCharge;
use App\Models\PromotionCode;
use App\Models\Store;
use App\Models\Coupon;
use App\Models\UserAddress;
use App\Models\Addition;
use App\Notifications\ResetPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Token;
use App\Models\NotificationMessage;

use Illuminate\Support\Facades\Validator;
use Image;
use DB;


class CartController extends Controller
{
    public function image_extensions()
    {
        return array('jpg', 'png', 'jpeg', 'gif', 'bmp');
    }


    public function addProductToCart(Request $request)
    {
        // if (auth()->check()) {
        $settings = Setting::first();
        if ($settings->is_alowed_cart == 1) {
            $message = __('api.addToCartStoped');
            return response()->json(['status' => true, 'message' => $message]);
        } else {

            $vat = $settings->tax_amount;
            $myCart = new Cart();
            if (Auth::guard('api')->check()) {
                $myCart->user_id = \auth('api')->user()->id;
            }
            $myCart->product_id = $request->product_id;
            $myCart->quantity = $request->quantity;
            $myCart->fcm_token = $request->fcm_token;
            $myCart->save();

            $myNewCart = Cart::Where('fcm_token', $request->fcm_token)->with('product')->get();
            $count_products = Cart::Where('fcm_token', $request->fcm_token)->count('quantity');

            $total_cart = 0;

            foreach ($myNewCart as $one) {
                if(isset($one->product->discount_price) ){
                    $price_val =  $one->product->discount_price;
                }else{
                   $price_val =  $one->product->price;
                }
                $total_cart += $price_val * $one->quantity;

            }

            $total_cart = $total_cart + $vat;
            // }


            // $count_products = Cart::Where('fcm_token', $request->fcmToken)->count();

            $message = __('api.addedToCart');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'count_products' => $count_products,
                'total_cart' => $total_cart]);
//            return ['status' => true, 'count_products'=>$count_products];
        }


    }

    public function deleteProductCart(Request $request, $id)
    {
        if(auth('api')->check()){
              $myCart = Cart::Where('user_id', auth('api')->id())
            ->where('product_id', $id)->forceDelete();
        }else{
         $myCart = Cart::Where('fcm_token', $request->header('fcmToken'))
            ->where('product_id', $id)->get();
              $myCart = Cart::Where('fcm_token', $request->header('fcmToken'))
            ->where('product_id', $id)->forceDelete();
        }

      
        $settings = Setting::first();
        if ($myCart) {
          if(auth('api')->check()){
                  $myCart = Cart::Where('user_id', auth('api')->id())->get();
            }else{
                $myNewCart = Cart::Where('fcm_token', $request->header('fcmToken'))->with('product')->get();

            }

            $count_products = count($myNewCart);

            $total_cart = 0;
            $vat = $settings->tax_amount;

            foreach ($myNewCart as $one) {
             if(isset($one->product->discount_price) ){
                    $price_val =  $one->product->discount_price;
                }else{
                   $price_val =  $one->product->price;
                }
                $total_cart += $price_val * $one->quantity;

            }

//            if ($total_cart == 0) {
//                $total_cart = 0;
//            } else {
//                $total_cart = $total_cart + $vat;
//            }

            $message = __('api.ok');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'total_cart' => $total_cart]);
        } else {
            $message = __('api.not_found');
            return response()->json(['status' => false, 'code' => 201, 'message' => $message]);
        }

    }

    public function getMyCart(Request $request)
    {
        $settings = Setting::first();
          if(auth('api')->check()){
          $myCart = Cart::Where('user_id', auth('api')->id())->with('product')->get();
        }else{
            $myCart = Cart::Where('fcm_token', $request->fcm_token)->with('product')->get();
        }

        if ($myCart && count($myCart) != 0) {

            $count_products = count($myCart);
            $total_cart = 0;
            $discount = 0;
            $delivery_charge = 0;
            $final_total = 0;
            $vat = $settings->tax_amount;

            foreach ($myCart as $one) {
                if(isset($one->product->discount_price) ){
                    $price_val =  $one->product->discount_price;
                }else{
                   $price_val =  $one->product->price;
                }
                $total_cart += $price_val * $one->quantity;

            }
            $vat_amount = ($total_cart * $vat) / 100;

            if ($request->has('address_id') && $request->address_id != '') {
                $address = UserAddress::where('id', $request->address_id)->first();
                $area_cost = Area::query()->findOrFail($address->area_id);
                $delivery_charge = $area_cost->delivery_charges;
            } elseif ($request->has('area_id') && $request->area_id != '') {
                $area_cost = Area::query()->findOrFail($request->area_id);
                $delivery_charge = $area_cost->delivery_charges;
            } else {
                $delivery_charge = 0;
            }

            $promo = Coupon::where('code', $request->get('code'))->whereDate('end_date', '>=', date('Y-m-d'))
                ->whereDate('start_date', '<=', date('Y-m-d'))->where('status', 'active')->first();

            if ($promo) {
                $discount = ($total_cart * $promo->percent) / 100;
                $total_discount = round($total_cart - $discount, 2);
            }
            $final_total = $total_cart + $vat_amount + $delivery_charge - $discount;
            $data['final_total'] =$final_total;
            $data['count_products'] =$count_products;
            $data['discount'] =$discount;
            $data['Tax'] =$vat_amount;
            $data['delivery_charge'] =$delivery_charge;
            $data['total'] =$total_cart;
            $data['MyCart'] =$myCart;
            $message = __('api.ok');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'data' => $data,
               ]);
        }else{
             $count_products = 0;
            $total_cart = 0;
            $discount = 0;
            $delivery_charge = 0;
            $final_total = 0;
            $vat_amount = 0;
            $vat = $settings->tax_amount;
            $data['final_total'] =$final_total;
            $data['count_products'] =$count_products;
            $data['discount'] =$discount;
            $data['Tax'] =$vat_amount;
            $data['delivery_charge'] =$delivery_charge;
            $data['total'] =$total_cart;
            $data['MyCart'] =$myCart;
             $message = __('api.cartEmpty');
        return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'data' => $data]);
        }
      

    }

    public function changeQuantity(Request $request, $id)
    {
        $settings = Setting::first();
            if(auth('api')->check()){
             $myCart = Cart::Where('user_id',auth('api')->id())->where('product_id', $id)->first();

        }else{
        $myCart = Cart::Where('fcm_token', $request->header('fcmToken'))->where('product_id', $id)->first();
        }


        if ($myCart) {
            if ($request->type == 1) {
                $newValue = $myCart->quantity + 1;
            } else {
                if ($myCart->quantity != 0) {
                    $newValue = $myCart->quantity - 1;
                } else {
                    $newValue = $myCart->delete();
                }

            }
            $myCart->update(['quantity' => $newValue]);
             if(auth('api')->check()){
                $myNewCart = Cart::Where('user_id',auth('api')->id())->with('product')->get();
            }else{
                $myNewCart = Cart::Where('fcm_token', $request->header('fcmToken'))->with('product')->get();
            }
            $total_cart = 0;
//            $vat = $settings->tax_amount;
            foreach ($myNewCart as $one) {
               if(isset($one->product->discount_price) ){
                    $price_val =  $one->product->discount_price;
                }else{
                   $price_val =  $one->product->price;
                }
                $total_cart += $price_val * $one->quantity;

            }
//            $total_cart = $total_cart + $vat;

            $message = __('api.ok');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'Quantity' => $newValue, 'total_cart' => $total_cart]);

        } else {
            $message = __('api.not_found');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message]);
        }
    }

    public function checkCode(Request $request)
    {
        $settings = Setting::first();
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 200, 'validator' => implode("\n", $validator->messages()->all())]);
        }

        $promo = Coupon::where('code', $request->get('code'))->whereDate('end_date', '>=', date('Y-m-d'))->whereDate('start_date', '<=', date('Y-m-d'))->where('status', 'active')->first();

        $myCart = Cart::Where('fcm_token', $request->header('fcmToken'))->with('product')->get();
        $total_cart = 0;
        $vat = $settings->tax_amount;
        foreach ($myCart as $one) {
           if(isset($one->product->discount_price) ){
                $price_val =  $one->product->discount_price;
            }else{
               $price_val =  $one->product->price;
            }
            $total_cart += $price_val * $one->quantity;

            }
        $discount = 0;
        if ($promo) {
            $discount = ($total_cart * $promo->percent) / 100;
            $total_discount = round($total_cart - $discount, 2);

            $message = __('api.ok');
            return response()->json(['status' => true, 'code' => 300, 'message' => $message]);
        } else {
            $message = __('api.wrongPromo');
            return response()->json(['status' => false, 'code' => 400, 'message' => $message]);

        }

    }

    public function checkOut(Request $request)
    {
        $settings = Setting::first();
        if ($settings->is_alowed_buying == 1) {
            $message = __('api.Purchase_is_suspended');
            return response()->json(['status' => true, 'message' => $message]);
        } else {
            if (Auth::guard('api')->check()) {
                $user_id = auth('api')->user()->id;
                $validator = Validator::make($request->all(), [
                    'address_id' => 'required',
                    'payment_method' => 'required|min:0|max:1',
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => false, 'code' => 201,
                        'message' => implode("\n", $validator->messages()->all())]);
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'payment_method' => 'required|min:0|max:1',
                    'area_id' => 'required',
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'street' => 'required',
                    'password' => 'required',
                    'address_name' => 'required',
                    'latitude' => 'required',
                    'longitude' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => false, 'code' => 200,
                        'message' => implode("\n", $validator->messages()->all())]);
                }
            }
            if (Auth::guard('api')->check()) {
                $myNewCart = Cart::where('user_id', $user_id)->with('product')->get();
            } else {
                $myNewCart = Cart::where('fcm_token', $request->fcm_token)->with('product')->get();
            }
            if ($myNewCart) {
                if ($myNewCart->isEmpty()) {
                    $message = __('api.cartEmpty');
                    return response()->json(['status' => false, 'code' => 200, 'message' => $message]);
                }

                $count_products = count($myNewCart);
                $total_cart = 0;
                $total = 0;
                $vat = $settings->tax_amount;
                $vat_amount = 0;
                $total_cart = 0;
                $discount = 0;
                $delivery_charge = 0;
                $final_total = 0;

                foreach ($myNewCart as $one) {
                    $price_val = ($one->product->discount_price) ? $one->product->discount_price : $one->product->price;
                    $total_cart += $price_val * $one->quantity;
                }
                if ($request->has('address_id') && $request->address_id != '') {
                    // $address = UserAddress::where('id', $request->address_id)->first();
                    $address = UserAddress::query()->findOrFail($request->address_id);
                        if(!isset($address)){
                             $message = __('api.not_found');
                             return response()->json(['status' => false, 'code' => 201, 'message' => $message]);
                        }
                    $area_cost = Area::query()->findOrFail($address->area_id);
                    $delivery_charge = $area_cost->delivery_charges;
                } elseif ($request->has('area_id') && $request->area_id != '') {
                    $area_cost = Area::query()->findOrFail($request->area_id);
                    $delivery_charge = $area_cost->delivery_charges;
                } else {
                    $delivery_charge = 0;
                }
                $promo = Coupon::where('code', $request->get('code'))->whereDate('end_date', '>=', date('Y-m-d'))->whereDate('start_date', '<=', date('Y-m-d'))->where('status', 'active')->first();

                if ($promo) {
                    if ($promo->percent > 0) {
                        $discount = ($total_cart * $promo->percent) / 100;
                        $total_cart = round($total_cart - $discount, 2);
                    }
                }
                $vat_amount = $vat_amount * $vat/100;

                $final_total = $total_cart + $vat_amount + $delivery_charge;


               if (!auth('api')->check()){
                    $newUser = new User();
                    $newUser->password = bcrypt($request->get('password'));;
                    $newUser->email = $request->email;
                    $newUser->name = $request->name;
                    $newUser->type_mobile = $request->type_mobile;
                    $newUser->save();
                    
                    $address = UserAddress::query()->create([
                        'address_name' => $request->address_name,
                        'area_id' => $request->area_id,
                        'street' => $request->street,
                        'longitude' => $request->longitude,
                        'latitude' => $request->latitude,
                        'user_id' => $newUser->id,
                      ]);
                    
                    $user_id =$newUser->id;
                    
                 }
                 
                $order = new Order();
                $order->total = $final_total ;
                $order->sub_total = $total_cart;
                $order->count_items = $count_products;
                $order->vat_percent = $vat;
                $order->vat_amount = $vat_amount;
                $order->delivery_cost = $delivery_charge;
                $order->discount = $discount;
                $order->discount_code = $promo->code ?? '';
                $order->user_id = $user_id;
                // if (Auth::guard('api')->check()) {
                    $order->address_id = $address->id;
                // }else {
                    $order->fcm_token = $request->fcm_token;
                    $order->payment_method = $request->payment_method; ///0->knet , 1->credit cart
                    $order->name = (isset($newUser))? $newUser->name:auth('api')->user()->name;
                    $order->email =(isset($newUser))? $newUser->name:auth('api')->user()->email;
                    $order->area_id = $address->area_id;
                    $order->street = $address->street;
                    $order->address_name = $address->address_name;
                // }
                $order->availabile_date = $request->availabile_date;
                $order->availabile_time = $request->availabile_time;
                $order->save();


                if ($order) {
                    foreach ($myNewCart as $one) {
                        if ($one->product->discount_price != 0) {
                            $price = $one->product->discount_price;
                        } else {
                            $price = 0;
                        }

                        $ProductOrder = new OrderProduct();
                        $ProductOrder->order_id = $order->id;
                        $ProductOrder->product_id = $one->product_id;
                        $ProductOrder->quantity = $one->quantity;
                        $ProductOrder->offer_price = $price;
                        $ProductOrder->price = $one->product->price;
                        $ProductOrder->save();

                        Cart::where('user_id', auth('api')->id())->delete();
                    }
    
                } else {
                    $message = __('api.not_found');
                    return response()->json(['status' => true, 'code' => 200, 'message' => $message]);
                }
                
                $user='';
                if(isset($newUser)){
                    if($newUser){
                        if ($request->has('fcmToken')) {
                            Token::updateOrCreate(['device_type' => $request->get('type_mobile'), 'fcm_token' => $request->get('fcmToken'),
                                    'lang' => app()->getLocale()]
                                , ['user_id' => $newUser->id]);
                        }
        
                        $user = User::findOrFail($newUser->id);
                        $user['access_token'] = $newUser->createToken('mobile')->accessToken;
                    }
                }
                $url = route('payment') ;
                $message = __('api.ok');
                return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'order' => $order 
                ,'user'=>$user ,'url' => $url]);
            } else {
                $message = __('api.not_found');
                return response()->json(['status' => true, 'code' => 200, 'message' => $message]);
            }


        }

    }

    public function reOrder(Request $request, $id)
    {

        $order = Order::findOrFail($id);
        if ($order->status == 2) {
            $new_order = $order->replicate();
            $new_order->status = -1;
            $new_order->save();

            $products = OrderProduct::where('order_id', $order->id)->get();
            foreach ($products as $new_prod) {
                $ProductOrder = new OrderProduct();
                $ProductOrder->order_id = $new_order->id;
                $ProductOrder->product_id = $new_prod->product_id;
                $ProductOrder->quantity = $new_prod->quantity;
                $ProductOrder->color_id = $new_prod->color_id;
                $ProductOrder->size_id = $new_prod->size_id;
                $ProductOrder->discount = $new_prod->discount;
                $ProductOrder->price = $new_prod->product->price;
                $ProductOrder->offer_price = $new_prod->offer_price;
                $ProductOrder->save();

            }
            $message = __('api.ok');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message, 'order' => $order]);
            //     //  $url=url(getLocal().'/payment');
            // $message = __('api.ok');
            // return response()->json(['status' => true, 'code' => 200, 'message' => $message,
            //       'checkOut'=> ['phoneNumber'=>$request->mobile ,'totalProduct'=>$new_order->total_price ,'order'=>$new_order ]]);

        } else {
            $message = __('api.CanNotReorder');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message]);
        }


    }

    public function deleteCartItems(Request $request)
    {
        $myCart = Cart::where('fcm_token', '=', $request->header('fcmToken'))->delete();

        if ($myCart) {
            $message = __('api.ok');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message]);
        } else {
            $message = __('api.not_found');
            return response()->json(['status' => true, 'code' => 200, 'message' => $message]);
        }

    }


}
