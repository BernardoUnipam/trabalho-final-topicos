@extends('layouts.app')

@section('title','Categorias')

@section('content')
  <h1>Categorias</h1>

  <div class="row">
    <div class="col-md-5">
      <h4>Cadastrar Categoria</h4>
      <form action="{{ route('categorias.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nome</label>
          <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Descrição</label>
          <textarea name="descricao" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary" type="submit">Salvar</button>
      </form>
    </div>

    <div class="col-md-7">
      <h4>Lista de Categorias ({{ $categorias->count() }})</h4>
      <ul class="list-group">
        @forelse($categorias as $c)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $c->nome }}
            <span class="text-muted small">{{ $c->created_at->format('d/m/Y') }}</span>
          </li>
        @empty
          <li class="list-group-item">Nenhuma categoria cadastrada.</li>
        @endforelse
      </ul>
    </div>
  </div>
@endsection
