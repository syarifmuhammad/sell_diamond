<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class HomePageController extends Controller
{
    public function index(){
        $products = Category::get();
        $param = [
            "products" => $products
        ];
        return view('pages.home', $param);
    }
}
