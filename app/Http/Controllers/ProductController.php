<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public static function index()
    {
        $products = DB::table('products')
            ->select('id', 'name', 'price')
            ->get();

        return view('catalog.list', ['products' => $products]);
    }
}
