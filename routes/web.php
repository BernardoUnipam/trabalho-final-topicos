<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie; // <<< Adicionado para Cookie
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController; // <<< Adicionado para Login

// --- ROTA DE COOKIE (Trocar Tema Claro/Escuro) ---
// Essa rota cria/atualiza o cookie 'theme' e recarrega a página
Route::get('/toggle-theme', function () {
    // Verifica o cookie atual e inverte o tema
    $theme = Cookie::get('theme') === 'dark' ? 'light' : 'dark';
    // Salva o cookie por 30 dias (43200 minutos)
    Cookie::queue('theme', $theme, 43200);
    return back(); // Volta para a página anterior
})->name('toggle.theme');

// --- ROTAS DE AUTENTICAÇÃO (Públicas) ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- GRUPO PROTEGIDO (Só acessa se estiver logado) ---
Route::middleware(['auth'])->group(function () {

    // Se acessar a raiz, joga para produtos
    Route::get('/', function () {
        return redirect()->route('produtos.index');
    });

    // CRUD DE PRODUTOS
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::get('/produtos/{id}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit');
    Route::put('/produtos/{id}', [ProdutoController::class, 'update'])->name('produtos.update');
    Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');

    // CRUD DE CATEGORIAS (Falta implementar os métodos no Controller, mas a rota está pronta)
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');

});