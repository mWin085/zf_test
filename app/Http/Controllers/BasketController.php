<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BasketController extends Controller
{
    public static function index()
    {
        $basketSum = 0;
        $basketItems = DB::table('baskets')
            ->join('products', 'baskets.product_id', '=', 'products.id')
            ->select('baskets.*', 'products.price')
            ->select(DB::raw('baskets.*, products.*, products.price * baskets.quantity as sum'))
            ->get();

        if ($basketItems){
            $basketSum = array_sum(array_column($basketItems->toArray(), 'sum'));
        }

        return view('cart.basket', ['basketItems' => $basketItems, 'sum' => $basketSum]);
    }

    public static function store(Request $request)
    {

        $request->validate([
            'prod_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
        ]);

        $basketData = Basket::where([
            'user_id' => Auth::id(),
            'product_id' => (int)$request->prod_id
            ])
            ->first();

        if ($basketData) {
            $basketData->update(['quantity' => $basketData->quantity + (int)$request->quantity]);
            $basketData->save();
        } else {
            Basket::create([
                'user_id' => Auth::id(),
                'product_id' => (int)$request->prod_id,
                'quantity' => (int)$request->quantity
            ]);
        }

        return redirect()->route('catalog')->with('message', 'Товар успешно добавлен');

    }
}
