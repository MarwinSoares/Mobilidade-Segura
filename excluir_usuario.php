<?php
session_start();
include 'conexao.php';

// Verifica se o moderador está logado
if (!isset($_SESSION['id_adm'])) {
    header("Location: login.php");
    exit();
}

// Processa a exclusão quando o ID é fornecido
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Verifica se o usuário existe
    $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Exclui o usuário
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['mensagem'] = "Usuário excluído com sucesso!";
            $_SESSION['tipo_mensagem'] = "success";
        } else {
            $_SESSION['mensagem'] = "Erro ao excluir usuário: " . $conn->error;
            $_SESSION['tipo_mensagem'] = "danger";
        }
    } else {
        $_SESSION['mensagem'] = "Usuário não encontrado!";
        $_SESSION['tipo_mensagem'] = "danger";
    }
    
    $stmt->close();
} else {
    $_SESSION['mensagem'] = "ID do usuário não fornecido!";
    $_SESSION['tipo_mensagem'] = "danger";
}

header("Location: usuarios.php");
exit();
?>