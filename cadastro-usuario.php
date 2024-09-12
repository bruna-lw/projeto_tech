<?php
// Inicia a sessão no início do script, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
require_once 'classes/usuario.php';
// Criação de uma instância da classe Usuario
$usuario = new Usuario("projeto", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de usuário</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
</head>

<body>
  <header>
    <?php
      require_once 'header.php';
    ?>
  </header>
  
  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    if (!empty($nome) && !empty($email) && !empty($senha)) {
      if (!$usuario->cadastrarUsuario($nome, $email, $cpf, $telefone, $senha)) {
        echo '<h4>Email já está cadastrado.</h4>';
      } else {
        echo '<h4>Usuário cadastrado com sucesso!</h4>';
      }
    } else {
      echo '<h4>Preencha todos os campos.</h4>';
    }
  }

  ?>

  <section class="page-cadastro-usuario paddingBottom50">
    <div class="container">
      <div>
        <a href="dashboard.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Cadastro de usuário</span>
        </a>
      </div>
      <div class="container-small">
        <form method="post" id="form-cadastro-usuario">
          <div class="bloco-inputs">
            <div>
              <label class="input-label">Nome</label>
              <input type="text" class="nome-input" name="nome">
            </div>
            <div>
              <label class="input-label">E-mail</label>
              <input type="text" class="email-input" name="email">
            </div>
            <div>
              <label class="input-label">CPF</label>
              <input type="text" class="cpf-input" name="cpf">
            </div>
            <div>
              <label class="input-label">Telefone</label>
              <input type="tel" class="telefone-input" name="telefone">
            </div>
            <div>
              <label class="input-label">Senha</label>
              <input type="password" class="senha-input" name="senha">
            </div>
          </div>
          <button type="submit" class="button-default">Salvar novo usuário</button>
        </form>
      </div>
    </div>
  </section>
</body>

</html>