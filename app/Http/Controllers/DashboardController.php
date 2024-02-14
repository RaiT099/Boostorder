<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Models\Products;
use App\Models\CartItem;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request )
    {
        $keyword = $request->input('search');
        $query = Products::query();
        
        if ($keyword) {
            
            $products = $query->where('title', 'like', "%$keyword%")->paginate(10);
        } else {
            
            $products = $query->orderBy('id','desc')->limit(8)->get();
        }
        //dd($keyword);
        $cartItemsCount = 0;
            if (auth()->check()) {
                $cartItemsCount = CartItem::whereUserId(auth()->user()->id)->sum('qty');
            }
        //dd($products);
        return Inertia::render('Dashboard', ['products' => $products,
        'cartItemsCount' => $cartItemsCount, ]);
    }


}
