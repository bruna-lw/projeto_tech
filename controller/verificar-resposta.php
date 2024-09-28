<?php
session_start(); // Iniciar a sessão
require 'conecta-servidor.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar senha</title>
  <link rel="stylesheet" href="/projeto-capacitacao-tecnologia-main/assets/css/reset.css">
  <link rel="stylesheet" href="/projeto-capacitacao-tecnologia-main/assets/css/styles.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
</head>

<body>
  <header>
    <div class="container">
      <a href="index.php" class="logo">
        <img src="/projeto-capacitacao-tecnologia-main/assets/images/ho.svg" alt="" />
      </a>
    </div>
  </header>
  <section class="page-login">
    <div class="container-login">
      <div>
        <p class="login-title">
          Pergunta de segurança
        </p>
        <p class="login-text">
        </p>
      </div>
      <div class="login-container-small">
        <?php
          if (isset($_POST['email']) && isset($_POST['resposta'])) {
            $email = $_POST['email'];
            $resposta = $_POST['resposta'];
        
            // Verificar se a resposta da pergunta está correta
            $sql = "SELECT resposta_seguranca FROM usuario WHERE email = :e";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':e', $email);
            $stmt->execute();
            $user = $stmt->fetch();
        
            if ($user && $user['resposta_seguranca'] === $resposta) {
                // Resposta correta, prosseguir para a redefinição de senha
                $_SESSION['email'] = $email; // Armazenar o email na sessão para uso posterior
                header('location: /projeto-capacitacao-tecnologia-main/controller/redefinir-senha.php');
            } else {
                // Resposta incorreta, exibir mensagem de erro
                echo "Resposta incorreta!
                      <div>
                        <a href='/projeto-capacitacao-tecnologia-main/recuperar-senha.php' class='link-voltar'>
                        <img src='/projeto-capacitacao-tecnologia-main/assets/images/arrow.svg' alt=''>
                        <span>Voltar</span>
                        </a>
                      </div>";
            }
        }
        ?>
        
      </div>
    </div>
  </section>
</body>

</html>
