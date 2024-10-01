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
  <link rel="stylesheet" href="./assets/css/styles2.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
</head>

<body>
  <header>
  <div class="container">
      <a href="controller/logout.php" class="logo">
        <img src="assets/images/ho.svg" alt="" />
      </a>
      <div class="blc-user">
        <img src="assets/images/icon-feather-user.svg" alt="" />
        <span>
          Olá, <br />
          visitante
        </span>
  </div>
  </header>
  
  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
    $pergunta = filter_input(INPUT_POST, 'pergunta', FILTER_SANITIZE_STRING);
    $resposta = filter_input(INPUT_POST, 'resposta', FILTER_SANITIZE_STRING);

    if (!empty($nome) && !empty($email) && !empty($senha)) {
      if (!$usuario->cadastrarUsuario($nome, $email, $cpf, $telefone, $senha, $pergunta ,$resposta)) {
        echo '<h4>Email já está cadastrado.</h4>';
      } else {
        header("location: novo-usuario-cadastrado.php");
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
        <a href="index.php" class="link-voltar">
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
              <input type="text" class="cpf-input" id="cpf" name="cpf" placeholder="000.000.000-00" maxlength="14" required>
            </div>
            <div>
              <label class="input-label">Telefone</label>
              <input type="tel" class="telefone-input" id="telefone" name="telefone" placeholder="(00) 00000-0000" maxlength="15" required>
            </div>
            <div>
              <label class="input-label">Senha</label>
              <input type="password" class="senha-input" name="senha">
            </div>
            <div>
              <label for="pergunta" style="margin: 5px 0;">Escolha uma pergunta de segurança:</label>
              <select name="pergunta" required style="border-radius: 4px; border: 1px solid #CCCCCC; height: 35px; margin: 10px 0;">
              <option value="Qual o nome do seu pai?">Qual o nome do seu pai?</option>
              <option value="Qual o nome do seu primeiro animal de estimação?">Qual o nome do seu primeiro animal de estimação?</option>
              <option value="Em que cidade você nasceu?">Em que cidade você nasceu?</option>
              </select>
              <label for="resposta" style="margin: 0;">Resposta:</label>
              <input type="text" name="resposta" required style="height: 35px;">
            </div>
          </div>
          <button type="submit" class="button-default">Salvar novo usuário</button>
        </form>
      </div>
    </div>
  </section>
  <script src="controller/mascara.js"></script>
</body>

</html>