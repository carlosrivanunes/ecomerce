<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Stripe\Stripe;
use Stripe\StripeClient;
use App\Models\Order;
use App\Models\OrderItem;




class CheckoutController extends Controller
{
    /**
     * Exibe a página de checkout
     */
    public function index()
    {
        $stripeKey = config('services.stripe.key'); // Chave pública para JS
        $stripeSecret = config('services.stripe.secret'); // Chave secreta para API




        if (empty($stripeSecret) || empty($stripeKey)) {
            return redirect()->route('cart.index')
                ->with('error', 'Stripe não está configurado. Defina STRIPE_KEY e STRIPE_SECRET no .env.');
        }

        Stripe::setApiKey($stripeSecret);

        $cart = Cart::getContent();
        $total = Cart::getTotal();

        //echo $cart; // --- IGNORE ---
        //echo $total; // --- IGNORE ---

        if ($total <= 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Seu carrinho está vazio.');
        }

        $paymentIntent = \Stripe\PaymentIntent::create([
            //'amount' => $total * 100, // em centavos
            'amount' => 0.50 * 100, // em centavos
            'currency' => 'brl',
            'payment_method_types' => ['card'],
        ]);

        return view('checkout.index', compact('cart', 'total', 'stripeKey', 'stripeSecret'));
    }

    public function createintent()
    {
        $stripeSecret = config('services.stripe.secret');
        Stripe::setApiKey($stripeSecret);

        $cart = Cart::getContent();
        $total = Cart::getTotal();

        if ($total <= 0) {
            return response()->json(['error' => 'Carrinho vazio'], 400);
        }

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $total * 100, // em centavos
            
            'currency' => 'brl',
            'payment_method_types' => ['card'],
        ]);

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    }


    /**
     * Cria a sessão de pagamento Stripe
     */
    public function createSession(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::getContent();

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Carrinho vazio.');
        }

        // Cria pedido pendente
        $order = Order::create([
            'user_id' => $user ? $user->id : null,
            'total' => Cart::getTotal(),
            'status' => 'pending',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        $stripeSecret = config('services.stripe.secret');
        $stripe = new StripeClient($stripeSecret);

        $line_items = [];
        foreach ($cart as $item) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'brl', // Ajuste para sua moeda
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => (int) round($item->price * 100),
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'metadata' => [
                'order_id' => $order->id,
            ],
        ]);

        return redirect($session->url);
    }

    /**
     * Callback de sucesso
     */
    public function success()
    {
        $user = Auth::user();
        $cart = Cart::getContent();

        // Cria pedido pendente
        $order = Order::create([
            'user_id' => $user ? $user->id : null,
            'total' => Cart::getTotal(),
            'status' => 'pago',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        Cart::clear();
        $orderId = session('order_id');
        return view('checkout.success', compact('orderId'));
    }

    /**
     * Callback de cancelamento
     */
    public function cancel()
    {
        return redirect()->route('cart.index')->with('error', 'Pagamento cancelado.');
    }
}

