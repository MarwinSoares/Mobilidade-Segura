<?php
session_start();
session_unset(); // Limpa todas as variáveis de sessão
session_destroy(); // Encerra a sessão
header("Location: entrar.php"); // Redireciona para a página de login
exit;
