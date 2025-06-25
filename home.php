<?php
session_start();
$conn = new mysqli("localhost", "root", "", "mobilidade_segura");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$sql = "SELECT nome_locais, link_maps, acessibilidade, categoria FROM locais WHERE status_locais = 'Aprovado'";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobilidade Segura | home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="pagina2.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-wheelchair" viewBox="0 0 16 16">
  <path d="M12 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m-.663 2.146a1.5 1.5 0 0 0-.47-2.115l-2.5-1.508a1.5 1.5 0 0 0-1.676.086l-2.329 1.75a.866.866 0 0 0 1.051 1.375L7.361 3.37l.922.71-2.038 2.445A4.73 4.73 0 0 0 2.628 7.67l1.064 1.065a3.25 3.25 0 0 1 4.574 4.574l1.064 1.063a4.73 4.73 0 0 0 1.09-3.998l1.043-.292-.187 2.991a.872.872 0 1 0 1.741.098l.206-4.121A1 1 0 0 0 12.224 8h-2.79zM3.023 9.48a3.25 3.25 0 0 0 4.496 4.496l1.077 1.077a4.75 4.75 0 0 1-6.65-6.65z"/>
</svg> Mobilidade Segura</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Sobre</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contato</a>
        </li>
       <?php if (isset($_SESSION['usuario_id'])): ?>
  <li class="nav-item">
    <a class="nav-link link" href="dashboard.php">Painel</a>
  </li>
  <li class="nav-item">
    <a class="nav-link link" href="logout.php">Sair</a>
  </li>
<?php else: ?>
  <li class="nav-item">
    <a class="nav-link link" href="cadastro.php">Cadastrar-se</a>
  </li>
  <li class="nav-item">
    <a class="nav-link link" href="entrar.php">Entrar</a>
  </li>
<?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
<div class="container">
    <h2 class="text-center">Encontre locais acessíveis perto de você</h2>
    <p class="text-center">Nosso Site mostra estabelecimentos e espaços públicos com acessibilidade para pessoas com deficiência ou mobilidade reduzida.</p>
    <?php if (isset($_SESSION['usuario_id'])): ?>
  <a href="formulario_local.php" class="text-center btn btn-success d-block mx-auto w-25 my-3">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
      <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
    </svg> Adicionar local
  </a>
<?php else: ?>
  <p class="text-center text-danger mt-4">Faça login para adicionar um local.</p>
<?php endif; ?>
<?php
$sql = "SELECT id_locais, nome_locais, link_maps, acessibilidade, categoria FROM locais WHERE status_locais = 'Aprovado'";
$result = $conn->query($sql);
?>

<h3 class="text-center mt-5">Locais acessíveis próximos</h3>

<div class="row">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 my-3">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($row['nome_locais']); ?></h5>
            <p class="card-text"><strong>Categoria:</strong> <?php echo htmlspecialchars($row['categoria']); ?></p>
            <p class="card-text"><strong>Acessibilidade:</strong> <?php echo htmlspecialchars($row['acessibilidade']); ?></p>
            <a href="<?php echo htmlspecialchars($row['link_maps']); ?>" target="_blank" class="btn btn-primary mb-2">Ver no Google Maps</a><br>
            <!-- Botão de Relatar -->
            <button 
                class="btn btn-outline-danger btn-relatar"
                data-id="<?php echo $row['id_locais']; ?>"
                data-nome="<?php echo htmlspecialchars($row['nome_locais']); ?>">
                Relatar problema
            </button>
        </div>
    </div>
</div>

        <?php endwhile; ?>
    <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="modalRelatar" tabindex="-1" aria-labelledby="modalRelatarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="relatar.php">
        <div class="modal-header">
          <h5 class="modal-title" id="modalRelatarLabel">Relatar problema no local</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_local" id="modal_id_local">
          <p><strong id="modal_nome_local"></strong></p>
          <textarea name="relato" class="form-control" rows="4" placeholder="Descreva o problema..."></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Enviar Relato</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.btn-relatar').forEach(botao => {
  botao.addEventListener('click', () => {
    const id = botao.dataset.id;
    const nome = botao.dataset.nome;

    document.getElementById('modal_id_local').value = id;
    document.getElementById('modal_nome_local').innerText = nome;

    const modal = new bootstrap.Modal(document.getElementById('modalRelatar'));
    modal.show();
  });
});
</script>


    


</div>




<div class="container">
        <p class="text-center">© 2025 Mobilidade Segura. Todos os direitos reservados.</p>
        <a href="login_adm.php">Login de administrador</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>