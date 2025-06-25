<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id_adm'])) {
    header("Location: login.php");
    exit();
}

// Pega todas as ações com informações do moderador e do local
$sql = "SELECT a.*, m.nome_adm, l.nome_locais
        FROM acoes_moderador a
        JOIN moderadores m ON a.id_adm = m.id_adm
        LEFT JOIN locais l ON a.id_locais = l.id_locais
        ORDER BY a.data_acao DESC";
$result = mysqli_query($conn, $sql);

// Pega o nome do moderador logado
$sql_adm = "SELECT nome_adm FROM moderadores WHERE id_adm = '".$_SESSION['id_adm']."'";
$result_adm = mysqli_query($conn, $sql_adm);
$nome_adm = ($result_adm && mysqli_num_rows($result_adm) > 0) ? mysqli_fetch_assoc($result_adm)['nome_adm'] : 'Administrador';

// Mensagens de feedback
if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    $tipo = $_SESSION['tipo_mensagem'];
    
    echo '<div class="container mt-3">';
    echo '<div class="alert alert-'.$tipo.' alert-dismissible fade show" role="alert">';
    echo $mensagem;
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
    echo '</div>';
    
    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo_mensagem']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Ações | Mobilidade Segura</title>
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
        .badge-acao {
            font-size: 0.9em;
            padding: 5px 8px;
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
            <a class="btn btn-light me-2" href="moderadores.php">Moderadores</a>
            <a class="btn btn-light me-2 active" href="historico_acoes.php">Histórico</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="table-container">
        <h2 class="mb-4">Histórico de Ações dos Moderadores</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Moderador</th>
                            <th>Ação</th>
                            <th>Local</th>
                            <th>Data/Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nome_adm']) ?></td>
                                <td>
                                    <?php 
                                    $acao = htmlspecialchars($row['acao']);
                                    $badge_class = 'bg-secondary';
                                    if (strpos($acao, 'aprovou') !== false) $badge_class = 'bg-success';
                                    elseif (strpos($acao, 'rejeitou') !== false) $badge_class = 'bg-danger';

                                    echo '<span class="badge '.$badge_class.' badge-acao">'.$acao.'</span>';
                                    ?>
                                </td>
                                <td>
                                    <?= $row['nome_locais'] ? htmlspecialchars($row['nome_locais']) : '<em>Local excluído</em>' ?>
                                </td>
                                <td><?= date('d/m/Y H:i:s', strtotime($row['data_acao'])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                Nenhuma ação registrada no histórico.
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
