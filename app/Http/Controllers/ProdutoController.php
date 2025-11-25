<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Necessário para apagar imagens
use Illuminate\Support\Facades\Cookie;  // Necessário para o Requisito 5

class ProdutoController extends Controller
{
    // LISTAR (Read)
    public function index()
    {
        // Requisito 5: Uso de Cookies
        // Vamos criar um cookie que dura 60 minutos guardando a data do último acesso
        Cookie::queue('ultimo_acesso_produtos', now()->format('d/m/Y H:i'), 60);

        // Busca produtos ordenados pelo mais recente
        $produtos = Produto::orderBy('created_at', 'desc')->get();
        
        return view('produtos.index', compact('produtos'));
    }

    // MOSTRAR FORMULÁRIO DE CRIAÇÃO (Create - View)
    // Se você não tiver uma view separada 'create', pode usar a index se for modal.
    // Mas para o CRUD completo, geralmente criamos uma rota create.
    public function create()
    {
        return view('produtos.create'); 
    }

    // SALVAR NOVO (Create - Action)
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

    // MOSTRAR FORMULÁRIO DE EDIÇÃO (Update - View)
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

            // 2. Salva a nova
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