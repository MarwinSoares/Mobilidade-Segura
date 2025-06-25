<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastro de Usuário - Mobilidade Segura</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/jquery.inputmask.min.js"></script>

  <style>
    body {
      background: linear-gradient(to right, #3a7bd5, #00d2ff);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      background-color: #ffffff;
      padding: 2rem;
      width: 100%;
      max-width: 500px;
    }
    .card h2 {
      font-weight: bold;
      margin-bottom: 1.5rem;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>Cadastro de Usuário</h2>
    <form action="processar_cadastro.php" method="POST">
      <div class="mb-3">
        <label for="nome" class="form-label">Nome completo</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
      </div>

      <div class="mb-3">
        <label for="telefone" class="form-label">Telefone</label>
        <input type="tel" class="form-control" id="telefone" name="telefone"
          placeholder="+55 (11) 99999-9999" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>

      <div class="mb-3">
        <label for="senha" class="form-label">Senha</label>
        <input type="password" class="form-control" id="senha" name="senha" required>
      </div>

      <span id="senha-feedback" style="color: red; font-size: 0.9em;"></span>

      <div class="mb-3">
        <label for="confirmar_senha" class="form-label">Confirmar Senha</label>
        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Cadastrar</button>
      </div>

      <div class="text-center mt-3">
        <a href="entrar.php">Já tem uma conta? Entre aqui</a>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function(){
      $('#telefone').inputmask({
        mask: "+55 (99) 99999-9999",
        placeholder: "_",
        showMaskOnHover: false,
        showMaskOnFocus: true
      });
    });

    document.getElementById("confirmar_senha").addEventListener("input", function () {
      const senha = document.getElementById("senha").value;
      const confirmar = this.value;
      const feedback = document.getElementById("senha-feedback");

      if (senha !== confirmar) {
        feedback.textContent = "As senhas não coincidem.";
      } else {
        feedback.textContent = "";
      }
    });
  </script>
</body>
</html>
