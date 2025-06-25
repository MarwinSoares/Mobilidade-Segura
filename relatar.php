<?php
$conn = new mysqli("localhost", "root", "", "mobilidade_segura");
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_local = $_POST['id_local'];
    $relato = $_POST['relato'];

    $sql = "INSERT INTO reportes (id_locais, mensagem) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id_local, $relato);

    if ($stmt->execute()) {
       header("Location: home.php?msg=Relato enviado com sucesso");
       exit;
    } else {
        echo "Erro ao enviar relato.";
    }
}
?>
