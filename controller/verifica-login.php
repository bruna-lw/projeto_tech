<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia a sessão
session_start();


// Configuração da conexão com o banco de dados
$host = 'localhost';
$db = 'projeto'; // Substitua pelo nome do seu banco de dados
$user = 'root'; // Substitua pelo seu usuário do banco de dados
$pass = ''; // Substitua pela senha do seu banco de dados

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}


// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = sha1($_POST['senha']); // Criptografa a senha com SHA1


    if ($email && $senha) {
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = ? AND senha = ?");
        $stmt->execute([$email, $senha]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nome'];
            header('Location: /projeto-capacitacao-tecnologia-main/dashboard.php'); // Redireciona para a página de dashboard
            exit;
        } else {
            $error = 'Email ou senha incorretos!';
            echo $error;
        }
    } else {
        $error = 'Preencha todos os campos corretamente!';
        echo $error;
    }
}


?>