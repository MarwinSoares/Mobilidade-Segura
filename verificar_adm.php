<?php
session_start();
include 'conexao.php';

// Verifica se o moderador está logado
if (!isset($_SESSION['id_adm'])) {
    header("Location: login_adm.php"); // Redireciona para o login de ADMs
    exit();
}

// Verifica se o moderador existe no banco de dados
$id_adm = $_SESSION['id_adm'];
$sql = "SELECT * FROM moderadores WHERE id_adm = '$id_adm'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    // Não encontrou o ADM no banco, redireciona
    header("Location: acesso_negado.php");
    exit();
}

// Você pode adicionar verificação de nível de acesso se necessário
// Exemplo: if ($row['nivel_acesso'] != 'admin') { ... }
?>