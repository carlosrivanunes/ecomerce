<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Exibe a página com os produtos favoritos do usuário.
     */
    public function index()
    {
        $user = auth()->user();
        // retorna collection de Product (não existe relação 'image' no model)
        $favorites = $user->favorites()->get();

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Adiciona ou remove um produto dos favoritos do usuário.
     */
    public function toggle(Product $product)
    {
        $user = Auth::user();

        // O método toggle faz o trabalho de "attach" (anexar) ou "detach" (desanexar)
        $user->favorites()->toggle($product->id);

        // Redireciona de volta para a página anterior
        return back()->with('success', 'Lista de favoritos atualizada!');
    }
}