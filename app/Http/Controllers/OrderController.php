<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public static function index()
    {
        $ordersSum = 0;
        $user = Auth::user();
        $orders = $user->orders;

        if ($orders){
            $ordersSum = array_sum(array_column($orders->toArray(), 'price'));
        }

        return view('orders.list', ['orders' => $orders, 'sum' => $ordersSum]);
    }

    public static function store(Request $request)
    {
        $user = Auth::user();
        $baskets = $user->baskets;
        $sum = 0;
        $products = [];
        foreach ($baskets as $basket) {
            $products[] = $basket->product->name;
            $sum += $basket->quantity * $basket->product->price;
        }

        $result = Order::create([
            'user_id' => Auth::id(),
            'product_list' => implode(", ", $products),
            'price' => $sum
        ]);
        $user->baskets()->delete();

        return redirect()->route('orders')->with('message', "Заказ № $result->id создан");
    }

    public static function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('orders');

    }
}
