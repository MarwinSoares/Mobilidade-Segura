<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($nome) || empty($email) || empty($senha)) {
        die("Todos os campos são obrigatórios.");
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $conn = new mysqli("localhost", "root", "", "mobilidade_segura");

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO moderadores (nome_adm, email_adm, senha_adm) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senhaHash);

    if ($stmt->execute()) {
        echo "<script>alert('Moderador cadastrado com sucesso!'); window.location.href = 'adm.php';</script>";
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
