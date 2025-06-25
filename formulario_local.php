
<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: entrar.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastro de Local - Mobilidade Segura</title>
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
      max-width: 500px;
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
    <form action="processar_locais.php" method="POST">
      <div class="mb-3">
        <label for="nome" class="form-label">Nome do estabelecimento</label>
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome" required>
      </div>

      <div class="mb-3">
        <label for="link_maps" class="form-label">Link do Google Maps</label>
        <input type="url" class="form-control" id="link_maps" name="link_maps" placeholder="Cole o link do local" required>
      </div>

      <div class="mb-3">
        <label for="categoria" class="form-label">Tipo de local</label>
        <select class="form-select" id="categoria" name="categoria" required>
          <option value="">Selecione...</option>
          <option value="restaurante">Restaurante</option>
          <option value="museu">Museu</option>
          <option value="bar">Bar</option>
          <option value="parque">Parque</option>
          <option value="mercado">Mercado</option>
          <option value="farmacia">Farmácia</option>
          <option value="hospital">Hospital</option>
          <option value="outro">Outro</option>
        </select>
      </div>

      <div class="mb-3">
  <label class="form-label">Tipo de acessibilidade</label><br>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="acessibilidade[]" value="deficiencia_fisica" id="acessibilidade_fisica">
    <label class="form-check-label" for="acessibilidade_fisica">
      Pessoa com Deficiência Física
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="acessibilidade[]" value="deficiencia_visual" id="acessibilidade_visual">
    <label class="form-check-label" for="acessibilidade_visual">
      Pessoa com Deficiência Visual
    </label>
  </div>
</div>


      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Enviar</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
