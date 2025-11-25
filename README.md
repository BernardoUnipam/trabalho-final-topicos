# APS 3 – Laravel

## 👨‍💻 Autor

**Nome:** Bernardo Willian da Cunha  
**Curso:** Sistemas de Informação  
**Disciplina:** Tópicos Especiais I

---

## 📄 Descrição da Atividade

Esta aplicação foi desenvolvida como parte da **APS 3** da disciplina **Tópicos Especiais I**, com o objetivo de aplicar os conceitos de estruturação básica em Laravel, utilizando o padrão **MVC (Model-View-Controller)**.

A proposta da atividade consistiu em:

* Criar controllers, views e rotas GET;
* Posteriormente, expandir a aplicação para incluir:
  * Models e migrations;
  * Formulários para cadastro de dados;
  * Listagem de registros salvos no banco de dados;
  * Validação e mensagens de sucesso/erro.

---

## ⚙️ Estrutura Implementada

### 🧩 Controllers

Foram criados dois controllers, cada um responsável por uma funcionalidade distinta:

* `ProdutoController`
* `CategoriaController`

Cada controller contém:

* O método `index()`, responsável por exibir a view correspondente;
* O método `store()`, responsável por receber dados via formulário e salvar no banco de dados.

### 💾 Models e Migrations

Foram criados dois models com suas migrations correspondentes:

* **Produto** – campos: `id`, `nome`, `descricao`, `preco`, `created_at`, `updated_at`;
* **Categoria** – campos: `id`, `nome`, `descricao`, `created_at`, `updated_at`.

As migrations foram executadas com sucesso, criando as tabelas no banco de dados SQLite.

### 🧱 Banco de Dados

O projeto utiliza **SQLite**, configurado no arquivo `.env` da seguinte forma:
```env
DB_CONNECTION=sqlite
DB_DATABASE=F:\unipam\periodo-4\topicos-especiais-i\atividades\resolucoes\aps-3\database\database.sqlite
DB_FOREIGN_KEYS=true
```

### 🖥️ Views (Blade)

Foram criadas duas views:

* `resources/views/produtos/index.blade.php`
* `resources/views/categorias/index.blade.php`

Cada view contém:

* Um formulário para cadastrar novos registros;
* Uma listagem dos registros já salvos no banco;
* Mensagens de validação, sucesso e erro.

### 🌐 Rotas

As rotas foram definidas no arquivo `routes/web.php`:
```php
// Produtos
Route::get('/produtos', [ProdutoController::class, 'index']);
Route::post('/produtos', [ProdutoController::class, 'store']);

// Categorias
Route::get('/categorias', [CategoriaController::class, 'index']);
Route::post('/categorias', [CategoriaController::class, 'store']);
```

---

## ✅ Funcionalidades Testadas

* A aplicação está rodando com o comando:
```bash
php artisan serve
```

* As páginas `/produtos` e `/categorias` estão acessíveis e funcionais;
* É possível cadastrar e listar produtos e categorias;
* Todos os registros são armazenados corretamente no banco SQLite;
* Mensagens de validação e sucesso aparecem conforme o esperado.

---

## 🏁 Conclusão

Todos os requisitos da **APS 3 – Laravel** foram implementados com sucesso:

* Estrutura MVC completa;
* Rotas GET e POST configuradas;
* Banco de dados funcional (SQLite);
* Formulários e listagem integrados;
* Código organizado e reutilizável conforme boas práticas do Laravel.

**Status:** ✅ Atividade Concluída com Sucesso