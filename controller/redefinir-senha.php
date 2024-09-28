<?php
session_start(); // Iniciar a sessão

require 'conecta-servidor.php';

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Redefinir Senha</title>
  <link rel="stylesheet" href="/projeto-capacitacao-tecnologia-main/assets/css/reset.css">
  <link rel="stylesheet" href="/projeto-capacitacao-tecnologia-main/assets/css/styles.css">
  <link rel="stylesheet" href="/projeto-capacitacao-tecnologia-main/assets/css/styles2.css">
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
  <?php
    if (isset($_SESSION['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
      $email = $_SESSION['email'];
      $senhaCriptografada = sha1($_POST['password']);
      $confirmar_senha = $_POST['confirm_password'];
  
      // Verificar se as senhas coincidem
      if ($_POST['password'] !== $confirmar_senha) {
        echo "<section class='page-cadastro-cliente paddingBottom50'>
                <div class='container'>
                  <div>
                    <a href='/projeto-capacitacao-tecnologia-main/controller/redefinir-senha.php' class='link-voltar'>
                      <img src='/projeto-capacitacao-tecnologia-main/assets/images/arrow.svg' alt=''>
                      <span>Voltar</span>
                    </a>
                  </div>
                </div>
                <h4>As senhas não coincidem!</h4>
              </section>";
        exit;
      }
  
      // Atualizar a senha no banco de dados
      $sql = "UPDATE usuario SET senha = :s WHERE email = :e";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':s', $senhaCriptografada);
      $stmt->bindParam(':e', $email);
      $stmt->execute();
  
      header('location: /projeto-capacitacao-tecnologia-main/senha-atualizada.php');
    }
  ?>
  <section class="page-login">
    <div class="container-login">
      <div>
        <img src="/projeto-capacitacao-tecnologia-main/assets/images/logoinpsun.png" alt="">
        <p class="login-title">
            Redefinir Senha
        </p>
      </div>
      <div class="login container-small">
        <form action="redefinir-senha.php" method="post" id="form-input-login">
          <!-- <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" /> -->
          <div class="input-login">
            <div>
              <label class="input-label-login">Nova Senha:</label>
              <input type="password" class="email-input" id="password" name="password" required>
            </div>
            <div>
              <label class="input-label-password">Confirmar Nova Senha:</label>
              <input type="password" class="password-input" id="confirm_password" name="confirm_password" required>
            </div>
          </div>
          <button type="submit" class="button-default">Redefinir Senha</button>
        </form>
        </a>
      </div>
    </div>
  </section>
</body>

</html>
