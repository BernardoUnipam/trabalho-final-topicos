# Trabalho Final – Tópicos Especiais I

## 👨‍💻 Autor
- Nome: Bernardo Willian da Cunha  
- Curso: Sistemas de Informação  
- Disciplina: Tópicos Especiais I  

## 📄 Descrição da Atividade
Esta aplicação é o Trabalho Final da disciplina, desenvolvido como uma evolução direta da APS 3 (MVC Laravel).  
O objetivo foi transformar a estrutura inicial em um sistema web completo e funcional, migrando do banco de dados SQLite para MySQL e implementando requisitos avançados de desenvolvimento web.

## 📋 Checklist de Requisitos Obrigatórios Cumpridos
Todos os requisitos propostos foram implementados com sucesso:

- ✅ CRUD Completo: Implementado no gerenciamento de Produtos (Criar, Ler, Atualizar e Excluir).
- ✅ Banco de Dados Relacional: Migração realizada de SQLite para MySQL (rodando via Docker).
- ✅ Gerenciamento de Sessão: Implementação de sistema de Login e Registro (AuthController). As rotas principais são protegidas e exigem autenticação.
- ✅ Upload de Arquivos: Cadastro de produtos permite envio de imagens (JPG/PNG), salvas no `storage/app/public`.
- ✅ Uso de Cookies: Funcionalidade de "Modo Escuro / Modo Claro" e registro de "Último Acesso", persistindo a preferência do usuário via cookies.
- ✅ Organização e Boas Práticas: Manutenção estrita do padrão MVC, validação de formulários (`request->validate`) e feedback visual (mensagens de sucesso/erro).

> Nota sobre o Escopo:  
> O projeto original (APS 3) possuía uma estrutura para Categorias. Neste trabalho final, optou-se por focar a implementação completa dos novos requisitos (Upload, Edição, Exclusão) no módulo de Produtos. A estrutura de Categorias foi mantida no código para garantir a escalabilidade do sistema, permitindo que funcionalidades similares sejam estendidas a ela no futuro.

## ⚙️ Estrutura Tecnológica

### 🐳 Ambiente (Docker)
Diferente da versão anterior, este projeto utiliza Docker (via Laravel Sail) para containerização, garantindo que o PHP 8.x e o MySQL 8.0 rodem de forma isolada e consistente.

### 🧩 Controllers
- `ProdutoController`: Responsável pelo CRUD completo, tratamento de upload de imagens e gerenciamento de cookies de acesso.
- `AuthController`: Responsável pelas regras de negócio de Login, Registro de usuários e Logout.
- `CategoriaController`: Mantido da versão anterior para fins de escalabilidade.

### 💾 Banco de Dados (MySQL)
- Configurado no arquivo `.env` para conexão via container Docker.
- Tabela `users`: Gerenciamento de acesso.
- Tabela `produtos`: Campos `id`, `nome`, `descricao`, `preco`, `imagem` (novo), `timestamps`.

### 🍪 Cookies e Sessão
- Cookie `theme`: Armazena a preferência visual (Dark/Light) por 30 dias.
- Cookie `ultimo_acesso_produtos`: Armazena o timestamp da última visita à lista.
- Middleware `auth`: Protege as rotas de manipulação de dados.

### 🌐 Views (Blade + Bootstrap)
- Interface responsiva utilizando Bootstrap 5.
- Layout Dinâmico: A cor do site muda baseada no Cookie (classes `bg-dark` vs `bg-light`).
- Navbar: Exibe o usuário logado e botões de ação.
- Modais: Formulários de cadastro utilizam modais para melhor UX.

## 🚀 Como Rodar o Projeto

Como o projeto utiliza Docker, o processo de instalação é padronizado.

### ✅ Pré-requisitos
- Docker Desktop instalado e rodando.
- Git.
- Composer.

### 🧭 Passo a Passo

### 1. Clone o repositório
```bash
git clone https://github.com/BernardoUnipam/trabalho-final-topicos.git
cd trabalho-final-topicos
```

### 2. Instale as dependências do PHP
```bash
composer install
```

### 3. Configure o ambiente
Copie o arquivo de exemplo e gere a chave da aplicação:
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure o banco de dados
Certifique-se de que o `.env` está configurado com:
```env
DB_CONNECTION=mysql
DB_HOST=mysql
```

### 5. Suba os containers (Docker)
```bash
./vendor/bin/sail up -d
```

Ou se preferir usar o Docker diretamente:
```bash
docker compose up -d
```

### 6. Execute as migrações e o link de storage (cria tabelas no MySQL e libera acesso às imagens):

- Via Sail:
  ```
  ./vendor/bin/sail artisan migrate
  ./vendor/bin/sail artisan storage:link
  ```

- Ou via Docker direto:
  ```
  docker compose exec laravel.test php artisan migrate
  docker compose exec laravel.test php artisan storage:link
  ```

### 7. Acesse a aplicação no navegador:
- http://localhost

## 🏁 Conclusão
O projeto evoluiu de um sistema simples de listagem para uma aplicação web robusta, segura e persistente.  
A adoção de Docker facilitou o gerenciamento do banco de dados MySQL, e a implementação de Autenticação e Cookies trouxe características profissionais ao sistema.

**Status:** ✅ Trabalho Concluído com Sucesso