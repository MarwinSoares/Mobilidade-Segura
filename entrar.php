<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Mobilidade Segura</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #3a7bd5, #00d2ff);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-card {
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      background-color: #ffffff;
      padding: 2rem;
      width: 100%;
      max-width: 400px;
    }
    .login-card h2 {
      font-weight: bold;
      margin-bottom: 1.5rem;
      text-align: center;
    }
    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(58, 123, 213, 0.25);
    }
    .btn-primary {
      background-color: #3a7bd5;
      border: none;
    }
    .btn-primary:hover {
      background-color: #2e62ab;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h2>Mobilidade Segura</h2>

    <?php if (isset($_GET['erro'])): ?>
      <div class="alert alert-danger text-center" role="alert">
        E-mail ou senha incorretos.
      </div>
    <?php endif; ?>

    <form action="validar_login.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
      </div>
      <div class="mb-3">
        <label for="senha" class="form-label">Senha</label>
        <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Entrar</button>
      </div>
      <div class="text-center mt-3">
        <a href="#">Esqueceu a senha?</a><br>
        <a href="cadastro.php">Criar nova conta</a>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
