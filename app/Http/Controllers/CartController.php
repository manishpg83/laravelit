<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Support\Facades\Session;
class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {

        $userId = auth()->id();
        $product = Product::findOrFail($productId);
        $cartDetail = CartDetail::where('user_id', $userId)->where('product_id', $productId)->first();

        if (!$cartDetail) {
            $cart = Cart::create([]);
            $cartDetail = new CartDetail([
                'cart_id' => $cart->id,
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => 1,
                'unit_price' => $product->our_price,
                'total_price' => $product->our_price,
            ]);
            $cartDetail->save();
            $cartCount = Session::get('cart_count', 0);
            $cartCount++;
            Session::put('cart_count', $cartCount);
        } else {
            $cartDetail->quantity += 1;
            $cartDetail->total_price = $cartDetail->quantity * $product->our_price;
            $cartDetail->save();
        }
        return redirect()->route('product.view', $productId)->with('success', 'Product added to cart successfully.');
    }

    public function getCartDetails()
    {
        $cartDetailsWithCart = CartDetail::join('cart', 'cart.id', '=', 'cart_details.cart_id')
            ->select('cart_details.*', 'cart.*')
            ->get();


        foreach ($cartDetailsWithCart as $cartDetail) {
            $quantity = $cartDetail->quantity;
            $unitPrice = $cartDetail->unit_price;
            $default = $cartDetail->default_;
            $canvasEnabled = $cartDetail->canvas_enabled;
        }
        return view('cart_details')->with('cartDetailsWithCart', $cartDetailsWithCart);
    }
    public function showCart()
    {
        $user = auth()->user();
        if ($user) {
            $cartDetails = CartDetail::where('user_id', $user->id)->get();
        } else {
            $cartDetails = [];
        }
        return view('cart.list', compact('cartDetails'));
    }

    public function removeItem(Request $request, $cartDetailId)
    {
        $cartDetail = CartDetail::findOrFail($cartDetailId);
        $cartDetail->delete();

        $cartCount = Session::get('cart_count', 0);
        if ($cartCount > 0) {
            $cartCount--;
            Session::put('cart_count', $cartCount);
        }
        return redirect()->route('cart.list')->with('success', 'Product removed from cart successfully.');
    }


}
