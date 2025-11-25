<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center py-4 bg-body-tertiary" style="height: 100vh;">

<main class="form-signin w-100 m-auto" style="max-width: 330px; padding: 15px;">
    <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <h1 class="h3 mb-3 fw-normal text-center">🔐 Login</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-floating mb-2">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="nome@exemplo.com" required>
            <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Senha" required>
            <label for="floatingPassword">Senha</label>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Entrar</button>
        
        <div class="mt-3 text-center">
            <a href="{{ route('register') }}">Não tem conta? Cadastre-se</a>
        </div>
    </form>
</main>

</body>
</html>