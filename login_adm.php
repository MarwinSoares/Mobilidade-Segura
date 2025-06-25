<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = $_POST['senha'];
    
    // Consulta o ADM no banco de dados
    $sql = "SELECT id_adm, nome_adm FROM moderadores WHERE email_adm = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $adm = mysqli_fetch_assoc($result);
        
        // Configura a sessão do ADM
        $_SESSION['adm_logado'] = true;
        $_SESSION['adm_id'] = $adm['id_adm'];
        $_SESSION['adm_nome'] = $adm['nome_adm'];
        
        header("Location: adm.php");
        exit();
    } else {
        $erro = "Credenciais inválidas!";
    }
}
?>

<!-- Seu formulário de login aqui -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login do Moderador - Mobilidade Segura</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
      color: #3a7bd5;
    }
    .alert-info {
      text-align: center;
      font-size: 0.9rem;
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
    <h2>Área do Moderador</h2>
    <div class="alert alert-info">Acesso exclusivo para moderadores</div>

    <form action="processar_login_adm.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" name="email" required>
      </div>

      <div class="mb-3">
        <label for="senha" class="form-label">Senha</label>
        <input type="password" class="form-control" name="senha" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Entrar</button>
      </div>
    </form>
  </div>
</body>
</html>
