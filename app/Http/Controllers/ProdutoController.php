<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Cookie;  

class ProdutoController extends Controller
{
    // LISTAR (Read)
    public function index()
    {
        Cookie::queue('ultimo_acesso_produtos', now()->format('d/m/Y H:i'), 60);

        // Busca produtos ordenados pelo mais recente
        $produtos = Produto::orderBy('created_at', 'desc')->get();
        
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create'); 
    }

    public function store(Request $request)
    {
        // Validação
        $validated = $request->validate([
            'nome' => 'required|string|max:150',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            // Requisito 4: Upload apenas PNG ou JPG
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // Lógica de Upload da Imagem
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            // Salva na pasta 'public/produtos' e retorna o caminho (ex: produtos/nomefoto.jpg)
            $caminhoImagem = $request->file('imagem')->store('produtos', 'public');
            $validated['imagem'] = $caminhoImagem;
        }

        Produto::create($validated);

        return redirect()->route('produtos.index')
                         ->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produtos.edit', compact('produto'));
    }

    // ATUALIZAR REGISTRO (Update - Action)
    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:150',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Se enviou uma NOVA imagem
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            // 1. Apaga a imagem antiga se existir
            if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
                Storage::disk('public')->delete($produto->imagem);
            }

            $caminhoImagem = $request->file('imagem')->store('produtos', 'public');
            $validated['imagem'] = $caminhoImagem;
        }

        $produto->update($validated);

        return redirect()->route('produtos.index')
                         ->with('success', 'Produto atualizado com sucesso!');
    }

    // EXCLUIR (Delete)
    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);

        // Apaga a imagem do servidor antes de apagar o registro
        if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
            Storage::disk('public')->delete($produto->imagem);
        }

        $produto->delete();

        return redirect()->route('produtos.index')
                         ->with('success', 'Produto excluído com sucesso!');
    }
}