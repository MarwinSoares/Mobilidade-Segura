<?php
session_start();

// Verificar se o moderador está logado
if (!isset($_SESSION['id_adm'])) {
    header("Location: login_adm.php"); // Redireciona para a tela de login
    exit();
}

$conn = new mysqli("localhost", "root", "", "mobilidade_segura");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verificar se o ID do moderador na sessão existe na tabela de moderadores
$stmt = $conn->prepare("SELECT id_adm FROM moderadores WHERE id_adm = ?");
$stmt->bind_param("i", $_SESSION['id_adm']);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    // Moderador não encontrado na tabela
    session_destroy(); // Limpa a sessão
    header("Location: login_adm.php");
    exit();
}
$stmt->close();

// Consulta para obter locais pendentes
$sql = "SELECT l.*, u.nome AS nome_usuario 
        FROM locais l 
        JOIN usuarios u ON l.id_usuario = u.id_usuario
        WHERE l.status_locais = 'pendente'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<!-- O resto do seu HTML permanece exatamente igual -->

<!DOCTYPE html>
<html lang="pt-br">
<head>  
    <meta charset="UTF-8">
    <title>Painel do Moderador | Mobilidade Segura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background: linear-gradient(to right, #207ce5, #3baeff);
        }
        .btn-acao {
            margin: 0 2px;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-custom text-white px-4">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-wheelchair" viewBox="0 0 16 16">
  <path d="M12 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m-.663 2.146a1.5 1.5 0 0 0-.47-2.115l-2.5-1.508a1.5 1.5 0 0 0-1.676.086l-2.329 1.75a.866.866 0 0 0 1.051 1.375L7.361 3.37l.922.71-2.038 2.445A4.73 4.73 0 0 0 2.628 7.67l1.064 1.065a3.25 3.25 0 0 1 4.574 4.574l1.064 1.063a4.73 4.73 0 0 0 1.09-3.998l1.043-.292-.187 2.991a.872.872 0 1 0 1.741.098l.206-4.121A1 1 0 0 0 12.224 8h-2.79zM3.023 9.48a3.25 3.25 0 0 0 4.496 4.496l1.077 1.077a4.75 4.75 0 0 1-6.65-6.65z"/>
</svg> Mobilidade Segura</a>
        <div class="d-flex">
            <a class="btn btn-light me-2" href="adm.php">Início</a>
            <a class="btn btn-light me-2" href="sair.php">Sair</a>
            <a class="btn btn-light me-2" href="usuarios.php">Usuarios</a>
            <a class="btn btn-light me-2" href="moderadores.php">Moderadores</a>
            <a class="btn btn-light me-2" href="historico_acoes.php">Historico</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Moderação de Locais Cadastrados</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle bg-white">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Estabelecimento</th>
                        <th>Categoria</th>
                        <th>Acessibilidade</th>
                        <th>Link</th>
                        <th>Usuário</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nome_locais']) ?></td>
                            <td><?= htmlspecialchars($row['categoria']) ?></td>
                            <td><?= htmlspecialchars($row['acessibilidade']) ?></td>
                            <td><a href="<?= htmlspecialchars($row['link_maps']) ?>" target="_blank">Ver no mapa</a></td>
                            <td><?= htmlspecialchars($row['nome_usuario']) ?></td>
                            <td>
                                <form method="POST" action="processar_validacao.php" class="d-inline">
                                    <input type="hidden" name="id_locais" value="<?= $row['id_locais'] ?>">
                                    <input type="hidden" name="acao" value="aprovar">
                                    <button type="submit" class="btn btn-success btn-sm btn-acao">Aprovar</button>
                                </form>
                                <form method="POST" action="processar_validacao.php" class="d-inline">
                                    <input type="hidden" name="id_locais" value="<?= $row['id_locais'] ?>">
                                    <input type="hidden" name="acao" value="rejeitar">
                                    <button type="submit" class="btn btn-danger btn-sm btn-acao">Rejeitar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            Nenhum local pendente para revisão no momento.
        </div>
    <?php endif ?>
</div>

<footer class="text-center mt-5 mb-3 text-muted">
    © 2025 Mobilidade Segura. Todos os direitos reservados.
</footer>

</body>
</html>

<?php $conn->close(); ?>
