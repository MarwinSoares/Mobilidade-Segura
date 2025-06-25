<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "mobilidade_segura"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$telefone = trim($_POST['telefone']); // <- Novo campo
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];

if ($senha !== $confirmar_senha) {
    echo "Erro: As senhas não coincidem.";
    exit;
}

// Verifica se o e-mail já está cadastrado
$sql_verifica = "SELECT id_usuario FROM usuarios WHERE email = ?";
$stmt_verifica = $conn->prepare($sql_verifica);
$stmt_verifica->bind_param("s", $email);
$stmt_verifica->execute();
$stmt_verifica->store_result();

if ($stmt_verifica->num_rows > 0) {
    echo "Erro: Este e-mail já está cadastrado.";
    exit;
}
$stmt_verifica->close();

$senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

// Insere o novo usuário com telefone
$sql = "INSERT INTO usuarios (nome, email, telefone, senha) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nome, $email, $telefone, $senha_criptografada);

if ($stmt->execute()) {
    header("Location: entrar.php");
    exit;
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
