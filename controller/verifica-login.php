<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia a sessão
session_start();


// Configuração da conexão com o banco de dados
$host = 'localhost';
$db = 'projeto'; 
$user = 'root'; 
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}




?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index</title>
  <link rel="stylesheet" href="/projeto-capacitacao-tecnologia-main/assets/css/reset.css">
  <link rel="stylesheet" href="/projeto-capacitacao-tecnologia-main/assets/css/styles.css">
  <link rel="stylesheet" href="/projeto-capacitacao-tecnologia-main/assets/css/styles2.css">
  <link rel="stylesheet" href="/projeto-capacitacao-tecnologia-main/assets/css/index.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
</head>

<body>
  <header>
  <div class="container">
      <a href="/projeto-capacitacao-tecnologia-main/index.php" class="logo">
        <img src="/projeto-capacitacao-tecnologia-main/assets/images/ho.svg" alt="" />
      </a>
      <div class="blc-user">
        <img src="/projeto-capacitacao-tecnologia-main/assets/images/icon-feather-user.svg" alt="" />
        <span>
          Olá, <br />
          visitante
        </span>
  </div>
  </header>
  <section class="page-cadastro-cliente paddingBottom50">
    <div class="container">
      <div>
        <a href="/projeto-capacitacao-tecnologia-main/index.php" class="link-voltar">
          <img src="/projeto-capacitacao-tecnologia-main/assets/images/arrow.svg" alt="">
          <span>Voltar</span>
        </a>
      </div>
    </div>
    <?php
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
                $_SESSION['user_id'] = $user['id_usuario'];
                $_SESSION['user_name'] = $user['nome'];
                header('Location: /projeto-capacitacao-tecnologia-main/dashboard.php'); // Redireciona para a página de dashboard
                exit;
            } else {
                $error = '<h4>Email ou senha incorretos!</h4>';
                echo $error;
            }
            } else {
                $error = '<h4>Preencha todos os campos!</h4>';
                echo $error;
            }
        }
    ?>
  </section>
</body>

</html>