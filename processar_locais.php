<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['usuario_id'])) {
        die("Usuário não está logado.");
    }

    $id_usuario = $_SESSION['usuario_id'];
    $nome = $_POST['nome'] ?? '';
    $link_maps = $_POST['link_maps'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $acessibilidade = $_POST['acessibilidade'] ?? [];

    $acessibilidade_str = implode(',', $acessibilidade);

    $conn = new mysqli("localhost", "root", "", "mobilidade_segura");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO locais (nome_locais, link_maps, categoria, acessibilidade, id_usuario) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nome, $link_maps, $categoria, $acessibilidade_str, $id_usuario);

    if ($stmt->execute()) {
        header("Location: home.php");
        exit;
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
