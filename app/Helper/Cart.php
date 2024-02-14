<?php

namespace App\Helper;

use App\Http\Controllers\ProductController;
use App\Models\CartItem;
use Illuminate\Support\Facades\Cookie;

class Cart {
    public static function getCount() {
        if($user = auth()->user()){
            return CartItem::whereUserId($user->id)->sum('qty');
        }
    }

    public static function getCartItem() {
        if($user = auth()->user()) {
            return CartItem::hereUserId($user->id)->get()->map(fn (CartItem $item)=> ['product_id' => $item->product_id, 'qty' => $item->qty]);
        }
    }

    public static function getCookieCartItems() {
        return json_decode(request()->cookie('cart_item', '[]'), true);
    }

    public static function setCookieCartItems() {
        Cookie::queue('cart_items', fn(int $carry, array $item)=>$carry + $item['qty'],0);
    }

    public static function saveCookieCartItems() {
        $user =auth()->user();
        $userCartItems = CartItem::where(['user_id' => $user->id])->get()->keyby('product_id');
        $saveCartItems = [];

        foreach (self::getCookieCartItems() as $cartItem)
        {
            if(isset($userCartitems[$cartItem['product_id']])){
                $userCartitems[$cartItem['product_id']]->update(['qty' => $cartItem['qty']]);
                continue;
            }
            $saveCartItems[] = [
                'user_id' => $user->id,
                'product_id'=> $cartItem['product_id'],
                'qty' => $cartItem['qty'],
            ];
        }

        if(!empty($saveCartItems)) {
            CartItem::insert($saveCartItems);
        }
    }

    public static function moveCartItemsIntoDb()
    {
        $request = request();
        $cartItems = self::getCookieCartItems();
        $newCartItems = [];
        foreach ($cartItems as $cartItem) {
            // Check if the record already exists in the database
            $existingCartItem = Cart_items::where([
                'user_id' => $request->user()->id,
                'product_id' => $cartItem['product_id'],
            ])->first();

            if (!$existingCartItem) {
                // Only insert if it doesn't already exist
                $newCartItems[] = [
                    'user_id' => $request->user()->id,
                    'product_id' => $cartItem['product_id'],
                    'qty' => $cartItem['quantity'],
                ];
            }
        }


        if (!empty($newCartItems)) {
            // Insert the new cart items into the database
            CartItem::insert($newCartItems);
        }
    }


    public static function getProductsAndCartItems()
    {
        $cartItems = self::getCartItems();

        $ids = Arr::pluck($cartItems, 'product_id');
        $products = Products::whereIn('id', $ids)->with('image')->get();
        $cartItems = Arr::keyBy($cartItems, 'product_id');
        return [$products, $cartItems];
    }
}