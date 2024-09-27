<?php
session_start(); // Iniciar a sessão
$_SESSION['email'] = $_POST['email'];

require 'conecta-servidor.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar senha</title>
  <link rel="stylesheet" href="/projeto-capacitacao-tecnologia-main//assets/css/reset.css">
  <link rel="stylesheet" href="/projeto-capacitacao-tecnologia-main//assets/css/styles.css">
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
          if (isset($_POST['email'])) {
            $email = $_POST['email'];
        
            // Verificar se o e-mail existe no banco
            $sql = "SELECT pergunta FROM usuario WHERE email = :e";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':e', $email);
            $stmt->execute();
            $user = $stmt->fetch();
        
            if ($user) {
                // Mostrar a pergunta de segurança
                echo '<form action="/projeto-capacitacao-tecnologia-main/controller/redefinir-senha.php" method="post">
                        <input type="hidden" name="email" value="'.$email.'">
                        <label>'.$user['pergunta'].'</label>
                        <input type="text" name="resposta" required>
                        <button type="submit" class="button-default">Confirmar Resposta</button>
                      </form>';
            } else {
                echo "E-mail não encontrado!";
            }
          }
        ?>
        
      </div>
    </div>
  </section>
</body>

</html>
