<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Moderador | Mobilidade Segura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .moderador-box {
            max-width: 500px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
        }
        .titulo {
            color: #0048ff;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="moderador-box">
            <h3 class="text-center titulo">Cadastro de Moderador</h3>
            <p class="text-center text-muted">Acesso exclusivo para administradores da plataforma</p>
            <form action="processar_cadastro_adm.php" method="POST">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome completo</label>
                    <input type="text" name="nome" id="nome" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail institucional</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha de acesso</label>
                    <input type="password" name="senha" id="senha" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Cadastrar Moderador</button>
                <a href="login_adm.php" class="btn btn-link d-block text-center mt-3">Já tem conta? Faça login</a>
            </form>
        </div>
    </div>

</body>
</html>
