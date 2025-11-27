<!DOCTYPE html>
@php
    $theme = \Illuminate\Support\Facades\Cookie::get('theme') ?? 'light';
    $isDark = $theme === 'dark';
@endphp
<html lang="pt-BR" data-bs-theme="{{ $theme }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="{{ $isDark ? 'bg-dark text-white' : 'bg-light' }}">

<!-- NAVBAR (Barra Superior com Logout e Tema) -->
<nav class="navbar navbar-expand-lg {{ $isDark ? 'navbar-dark bg-secondary' : 'navbar-light bg-white shadow-sm' }} mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Sistema Topicos</a>
        
        <div class="d-flex align-items-center gap-3">
            <!-- Nome do Usuário Logado -->
            <span class="fw-bold">Olá, {{ Auth::user()->name }}</span>

            <!-- Botão de Alternar Tema (Cookie) -->
            <a href="{{ route('toggle.theme') }}" class="btn btn-sm {{ $isDark ? 'btn-light' : 'btn-dark' }}">
                {{ $isDark ? '☀️ Claro' : '🌙 Escuro' }}
            </a>

            <!-- Botão de Logout -->
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">Sair</button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-6">📦 Gerenciamento de Produtos</h1>
            <small class="{{ $isDark ? 'text-light opacity-75' : 'text-muted' }}">
                Último acesso: {{ \Illuminate\Support\Facades\Cookie::get('ultimo_acesso_produtos') ?? 'Agora' }}
            </small>
        </div>
        <div class="col-md-4 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
                + Novo Produto
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabela de Produtos -->
    <div class="card shadow-sm {{ $isDark ? 'bg-secondary text-white border-0' : '' }}">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 {{ $isDark ? 'table-dark' : '' }}">
                <thead class="{{ $isDark ? '' : 'table-light' }}">
                    <tr>
                        <th width="100">Imagem</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Descrição</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produtos as $produto)
                        <tr>
                            <td>
                                @if($produto->imagem)
                                    <img src="{{ asset('storage/' . $produto->imagem) }}" alt="Foto" width="50" height="50" class="rounded object-fit-cover">
                                @else
                                    <span class="small opacity-50">Sem foto</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $produto->nome }}</td>
                            <td class="align-middle">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                            <td class="align-middle small opacity-75">{{ Str::limit($produto->descricao, 50) }}</td>
                            <td class="align-middle text-end">
                                <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-sm btn-outline-warning me-1">Editar</a>
                                <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 opacity-50">Nenhum produto cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL DE CADASTRO -->
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content {{ $isDark ? 'bg-dark text-white' : '' }}">
            <div class="modal-header">
                <h5 class="modal-title">Novo Produto</h5>
                <button type="button" class="btn-close {{ $isDark ? 'btn-close-white' : '' }}" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Preço</label>
                        <input type="number" step="0.01" name="preco" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagem</label>
                        <input type="file" name="imagem" class="form-control" accept="image/png, image/jpeg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>