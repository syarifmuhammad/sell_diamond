<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\PaymentMethod;

class ProductController extends Controller
{
    public function index(Request $request) {
        $category = Category::where('slug', $request->category)->first();
        if($category == null) {
            abort(404);
        }
        $products = Product::where('category_id', $category->id)->get();
        $payment_methods = PaymentMethod::get();
        $param = [
            "payment_methods" => $payment_methods,
            "products" => $products,
            "base_url" => url('/')
        ];
        return view('pages.product', $param);
    }

    // public function get_price_product_with_fee($product_id) {
    //     $product = Product::find($product_id);
    //     if($product) {
    //         $payment_methods = PaymentMethod::get();
    //         $payment_methods->each(function ($p) use ($product) {
    //             if($p->is_percent) {
    //                 $p->price = $product->price + ($p->fee/100 * $product->price);
    //             }else {
    //                 $p->price = $product->price + $p->fee;
    //             }
    //         });
    //         return response()->json($payment_methods, 200);
    //     }else {
    //         return response()->json([], 404);
    //     }

        
    // }
}
