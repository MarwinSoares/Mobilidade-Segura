<?php
session_start();
include 'conexao.php';

// Verifica se o moderador está logado
if (!isset($_SESSION['id_adm'])) {
    header("Location: login.php");
    exit();
}

// Processa o formulário de edição quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Atualiza os dados do usuário
    $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ?, telefone = ? WHERE id_usuario = ?");
    $stmt->bind_param("sssi", $nome, $email, $telefone, $id);
    
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Usuário atualizado com sucesso!";
        $_SESSION['tipo_mensagem'] = "success";
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar usuário: " . $conn->error;
        $_SESSION['tipo_mensagem'] = "danger";
    }
    
    header("Location: usuarios.php");
    exit();
}

// Obtém os dados do usuário para edição
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
    
    if (!$usuario) {
        $_SESSION['mensagem'] = "Usuário não encontrado!";
        $_SESSION['tipo_mensagem'] = "danger";
        header("Location: usuarios.php");
        exit();
    }
} else {
    header("Location: usuarios.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário | Mobilidade Segura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Editar Usuário</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">
                            
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($usuario['telefone']) ?>">
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>