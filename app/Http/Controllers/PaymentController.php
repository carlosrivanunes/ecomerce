<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout()
    {
        return view('checkout.index');
    }

    public function processPayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));    $charge = Charge::create([
            'amount' => Cart::total() * 100,
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Order Payment',
        ]);    Cart::destroy();
        // após validar/confirmar o pagamento e salvar o pedido:
        // $order = ...; // seu objeto de pedido criado/atualizado

        return redirect()->route('checkout.success')->with('order_id', $order->id);
    }
}

// $cart = items processados no checkout (pode ser subset do session('cart'))
$globalCart = session('cart', []);

// extrai ids aceitando 'product_id' ou 'id'
$purchasedIds = array_map(fn($i) => $i['product_id'] ?? $i['id'] ?? null, $cart);
$purchasedIds = array_filter($purchasedIds); // remove nulos

$remaining = array_filter($globalCart, function($item) use ($purchasedIds) {
    $id = $item['product_id'] ?? $item['id'] ?? null;
    return $id === null ? true : !in_array($id, $purchasedIds);
});

session(['cart' => array_values($remaining)]);

