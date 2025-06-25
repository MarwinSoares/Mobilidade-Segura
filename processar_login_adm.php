<?php
session_start();

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$conn = new mysqli("localhost", "root", "", "mobilidade_segura");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Atualizado para os nomes corretos da tabela
$stmt = $conn->prepare("SELECT id_adm, senha_adm FROM moderadores WHERE email_adm = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $moderador = $result->fetch_assoc();

    if (password_verify($senha, $moderador['senha_adm'])) {
        $_SESSION['id_adm'] = $moderador['id_adm'];
        header('Location: adm.php');
        exit;
    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "Moderador não encontrado.";
}

$stmt->close();
$conn->close();
?>
