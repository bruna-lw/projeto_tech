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
          Login
        </p>
        <p class="login-text">
        </p>
      </div>
      <div class="login-container-small">
        <form action="./controller/verifica-login.php" method="post" id="form-input-login">
          <div class="input-login">
            <div>
              <label class="input-label-login">E-mail</label>
              <input type="text" class="email-input" id="data-login" name="email">
              <small id="textEmail"></small>
            </div>
            <div>
              <label class="input-label-password">Senha</label>
              <input type="password" class="password-input" id="data-password" name="senha" autocomplete="current-password" required>
              <small id="textPassword"></small>
            </div>
          </div>
          <button type="submit" class="button-default">Continuar</button>
        </form>
        </a>
        </br><a href="cadastro-usuario.php">Ainda não é cadastrado? Clique aqui!</a></br></br>
        <a href="recuperar-senha.php">Esqueceu a senha? Clique aqui!</a>
      </div>
    </div>
  </section>
</body>

</html>