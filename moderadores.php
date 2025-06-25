<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id_adm'])) {
    header("Location: login.php");
    exit();
}

// Consulta para buscar todos os moderadores
$sql = "SELECT id_adm, nome_adm, email_adm, data_cadastro_adm FROM moderadores ORDER BY data_cadastro_Adm DESC";
$result = mysqli_query($conn, $sql);

// Nome do administrador logado
$sql_adm = "SELECT nome_adm FROM moderadores WHERE id_adm = '".$_SESSION['id_adm']."'";
$result_adm = mysqli_query($conn, $sql_adm);
$nome_adm = ($result_adm && mysqli_num_rows($result_adm) > 0) ? mysqli_fetch_assoc($result_adm)['nome_adm'] : 'Administrador';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Moderadores | Mobilidade Segura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background: linear-gradient(to right, #207ce5, #3baeff);
        }
        .user-info {
            color: white;
            margin-right: 15px;
            align-self: center;
        }
        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-custom text-white px-4">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="#">Mobilidade Segura</a>
        <div class="d-flex align-items-center">
            <span class="user-info">ADM: <?= htmlspecialchars($nome_adm) ?></span>
            <a class="btn btn-light me-2" href="adm.php">Início</a>
            <a class="btn btn-light me-2" href="sair_adm.php">Sair</a>
            <a class="btn btn-light me-2" href="usuarios.php">Usuários</a>
            <a class="btn btn-light me-2 active" href="moderadores.php">Moderadores</a>
            <a class="btn btn-light me-2" href="historico_acoes.php">Histórico</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="table-container">
        <h2 class="mb-4">Moderadores Cadastrados</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Data de Cadastro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['id_adm'] ?></td>
                                <td><?= htmlspecialchars($row['nome_adm']) ?></td>
                                <td><?= htmlspecialchars($row['email_adm']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($row['data_cadastro_adm'])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                Nenhum moderador encontrado.
            </div>
        <?php endif; ?>
    </div>
</div>

<footer class="text-center mt-5 mb-3 text-muted">
    © 2025 Mobilidade Segura. Todos os direitos reservados.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>
