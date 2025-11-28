<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mostra a lista de produtos.
     */
    public function index()
    {
        // $products = Product::all(); // Pega todos
        $products = Product::latest()->paginate(9); // Pega 9 por página, ordenados pelos mais recentes
        
        // *** BLOCO DE CORREÇÃO INICIADO ***
        // A lógica dos favoritos foi movida para ANTES do return.
        $userFavorites = [];
        // Verifica se o usuário está logado
        if (auth()->check()) {
            // Pega os IDs dos produtos favoritos e usa flip() para checagem rápida
            $userFavorites = auth()->user()->favorites()->pluck('product_id')->flip();
        }
        // *** FIM DO BLOCO DE CORREÇÃO ***

        // *** MUDANÇA: Este é agora o único return, passando ambas as variáveis ***
        return view('products.index', compact('products', 'userFavorites'));
    }

    /**
     * Show the form for creating a new resource.
     * Mostra o formulário para criar um novo produto.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     * Guarda um novo produto no banco de dados.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            // Ajustado o nome da pasta para 'product_images' e validação
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Guarda na pasta 'product_images' dentro de 'storage/app/public'
            $validated['image'] = $request->file('image')->store('product_images', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     * Mostra os detalhes de um produto específico.
     */
    public function show($id) // Pode usar Route Model Binding: public function show(Product $product)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
        // Se usar Route Model Binding: return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     * *** MÉTODO EDIT ADICIONADO ***
     * Mostra o formulário para editar um produto.
     */
    public function edit(Product $product) // Usando Route Model Binding
    {
        // Retorna a view de edição, passando o produto encontrado
        return view('products.edit', compact('product')); // Certifique-se que a view 'products.edit' existe
    }

    /**
     * Update the specified resource in storage.
     * *** MÉTODO UPDATE ADICIONADO ***
     * Atualiza um produto existente no banco de dados.
     */
    public function update(Request $request, Product $product) // Usando Route Model Binding
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // apaga imagem antiga se existir
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            // salva nova imagem em storage/app/public/product_images
            $data['image'] = $request->file('image')->store('product_images', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     * *** MÉTODO DESTROY ADICIONADO ***
     * Remove (exclui) um produto do banco de dados e a sua imagem.
     */
    public function destroy(Product $product)
    {
        // Deletar imagem se existir
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }
        
        // Deletar produto
        $product->delete();
        
        return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso!');
    }
}