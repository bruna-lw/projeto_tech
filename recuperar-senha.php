<?php
session_start(); // Iniciar a sessão

if (isset($_POST['email'])) {
    $_SESSION['email'] = $_POST['email']; // Armazena o email na sessão
    // Redirecionar para a página de redefinição de senha
    header('Location: redefinir-senha.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
</head>

<body>
  <header>
    <div class="container">
      <a href="index.php" class="logo">
        <img src="assets/images/ho.svg" alt="" />
      </a>
    </div>
  </header>
  <section class="page-login">
    <div class="container-login">
      <div>
        <img src="assets/images/logoinpsun.png" alt="">
        <p class="login-title">
          Login - Recuperar senha
        </p>
        <p class="login-text">
          </a>
        </p>
      </div>
      <div class="login container-small">
        <form action="controller/verificar-pergunta.php" method="POST" id="form-input-login">
          <div class="input-login">
            <div>
              <label class="input-label-login">Digite seu email</label>
              <input type="email" class="email-input" name="email" required>
            </div>
          </div>
          <button type="submit" class="button-default">Continuar</button>
        </form>
        </a>
      </div>
    </div>
  </section>
</body>

</html>
