<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">✏️ Editar Produto</h4>
                </div>
                <div class="card-body">
                    <!-- Rota de Update usa PUT -->
                    <form action="{{ route('produtos.update', $produto->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nome do Produto</label>
                            <input type="text" name="nome" class="form-control" value="{{ $produto->nome }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Preço (R$)</label>
                            <input type="number" step="0.01" name="preco" class="form-control" value="{{ $produto->preco }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" class="form-control" rows="3">{{ $produto->descricao }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Imagem Atual</label>
                            <div class="mb-2">
                                @if($produto->imagem)
                                    <img src="{{ asset('storage/' . $produto->imagem) }}" class="img-thumbnail" width="100">
                                @else
                                    <span class="text-muted">Sem imagem</span>
                                @endif
                            </div>
                            <label class="form-label text-muted small">Trocar Imagem (Opcional)</label>
                            <input type="file" name="imagem" class="form-control" accept="image/png, image/jpeg">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>