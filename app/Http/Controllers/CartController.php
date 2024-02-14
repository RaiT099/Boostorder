<?php

namespace App\Http\Controllers;
use App\Helper\Cart;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Models\Products;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function view(Request $request, Products $product) {
        $user = $request->user();
        if ($user) {
            $cartItems = CartItem::join('products', 'cart_items.product_id', '=', 'products.id')
            ->where('cart_items.user_id', $user->id)
            ->select('cart_items.*', 'products.*', 'cart_items.qty as itemqty') 
            ->get();
            $CartItems = CartItem::where('user_id', $user->id)->get();
            $product = Products::get();
            //$userAddress = UserAddress::where('user_id', $user->id)->where('isMain', 1)->first();
            if ($cartItems->count() > 0) {
                //dd($cartItems);
                return Inertia::render(
                    'Cartlist',
                    [
                        'cartItems' => $cartItems,
                        'CartItems' => $CartItems,
                        'product' => $product,
                    ]
                );
            } 
        }
    }

    public function store(Request $request, Products $product) {
        $qty = $request->post('qty',1);
        $user = $request->user();
        //dd($product);
        if ($user) {
            $cartItem = CartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->first();

            if($cartItem) {
                $cartItem->increment('qty');

            } else {

                CartItem :: create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'qty' => 1,
            ]);
            }
            
        } else {
            
                $cartItems = Cart::getCookieCartItems();
                $isProductExists = false;
                foreach(cartItems as $item) {
                    if($item['product_id'] === $product->id)
                    {
                        $item['qty'] += $qty;
                        $isProductExists = true;
                        break;
                    }
                }

                if(!$isProductExists)
                {
                    $cartItems[] = [
                        'user_id' => null,
                        'product_id' => $product->id,
                        'qty' => $qty,
                        'price' => $product->price
                    ];
                }
        }
        return redirect()->back()->with('success', 'cart added successfully');
    }

    public function update(Request $request,  Products $product) {
        $qty = $request->input('qty');
        $user = $request->user();

        if($user) {
            $s = CartItem::where(['user_id' => $user->id, 'product_id'=> $product->id])->update(['qty'=>$qty]);

        } else {
            $cartItems = Cart::getCookieCartItems();
            foreach ($cartItems as &$item) {
                if ($item['product_id'] === $product->id) {
                    $item['qty'] = $qty;
                    break;
                }
            }
            Cart::setCookieCartItems($cartItems);
        }

        return redirect()->back();

    }

    public function delete(Request $request, Products $product) {
        $user = $request->user();
//dd($product->id);
        if ($user) {
            CartItem::query()->where(['user_id' => $user->id, 'product_id' => $product->id])->first()?->delete();
            if (CartItem::count() <= 0) {
                return redirect()->route('dashboard')->with('info', 'your cart is empty');
            } else {
                return redirect()->back()->with('success', 'item removed successfully');
            }
        } else {
            $cartItems = Cart::getCookieCartItems();
            foreach ($cartItems as $i => &$item) {
                if ($item['product_id'] === $product->id) {
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            Cart::setCookieCartItems($cartItems);
            if (count($cartItems) <= 0) {
                return redirect()->route('dashboard')->with('info', 'your cart is empty');
            } else {
                return redirect()->back()->with('success', 'item removed successfully');
            }
        }
    }
}
