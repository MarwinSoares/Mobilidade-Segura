<?php
session_start();
include 'conexao.php'; 

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT id_usuario, nome, senha FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    if (password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id_usuario'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header("Location: home.php");
        exit;
    }
}

header("Location: entrar.php?erro=1");
exit;
