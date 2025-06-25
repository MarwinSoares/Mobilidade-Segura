<?php
session_start();

if (!isset($_SESSION['id_adm'])) {
    die("Acesso negado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_local = $_POST['id_locais'] ?? null;
    $acao = $_POST['acao'] ?? null;

    if (!$id_local || !in_array($acao, ['aprovar', 'rejeitar'])) {
        die("Dados inválidos.");
    }

    $status = $acao === 'aprovar' ? 'aprovado' : 'rejeitado';
    $id_moderador = $_SESSION['id_adm'];
    $data_acao = date('Y-m-d H:i:s');

    $conn = new mysqli("localhost", "root", "", "mobilidade_segura");

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Atualiza o status do local
    $stmt = $conn->prepare("UPDATE locais SET status_locais = ? WHERE id_locais = ?");
    $stmt->bind_param("si", $status, $id_local);
    $stmt->execute();
    $stmt->close();

    // Registra a ação do moderador com o ID do local
    $descricao_acao = $acao === 'aprovar' ? "aprovou o local ID $id_local" : "rejeitou o local ID $id_local";
    $stmt2 = $conn->prepare("INSERT INTO acoes_moderador (id_adm, acao, data_acao, id_locais) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("issi", $id_moderador, $descricao_acao, $data_acao, $id_local);
    $stmt2->execute();
    $stmt2->close();

    $conn->close();

    header("Location: adm.php?msg=Local " . $status . " com sucesso");
    exit;
} else {
    echo "Requisição inválida.";
}
?>
