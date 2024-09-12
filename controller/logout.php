<?php

// Inicia a sessão
session_start();

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Se desejar destruir o cookie da sessão também
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão
session_destroy();

// Redireciona o usuário para a página de login ou outra página
header("Location: /projeto-capacitacao-tecnologia-main/index.php");
exit();


?>