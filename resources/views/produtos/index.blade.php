@extends('layouts.app')

@section('title','Produtos')

@section('content')
  <h1>Produtos</h1>

  <div class="row">
    <div class="col-md-5">
      <h4>Cadastrar Produto</h4>
      <form action="{{ route('produtos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nome</label>
          <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Descrição</label>
          <textarea name="descricao" class="form-control"></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Preço</label>
          <input type="number" step="0.01" name="preco" class="form-control" required>
        </div>
        <button class="btn btn-primary" type="submit">Salvar</button>
      </form>
    </div>

    <div class="col-md-7">
      <h4>Lista de Produtos ({{ $produtos->count() }})</h4>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Criado em</th>
          </tr>
        </thead>
        <tbody>
          @forelse($produtos as $p)
            <tr>
              <td>{{ $p->nome }}</td>
              <td>R$ {{ number_format($p->preco, 2, ',', '.') }}</td>
              <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
            </tr>
          @empty
            <tr><td colspan="3">Nenhum produto cadastrado.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
