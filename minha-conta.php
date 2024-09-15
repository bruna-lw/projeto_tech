<?php
// Inicia a sessão no início do script, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'classes/usuario.php';
// Criação de uma instância da classe Usuario
$usuario = new Usuario("projeto", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minha Conta</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles2.css">
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
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $dadosUsuario = $usuario->buscarDadosUsuario($user_id);
  }

  if(isset($_POST['nome'])){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id_upd = addslashes($_SESSION['user_id']);
      $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
      $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
      $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

      if (isset($_FILES['imagem']['tmp_name']) && !empty($_FILES['imagem']['tmp_name'])) {
        $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
      } else {
        // Mantem a imagem existente
        $imagem = $dadosUsuario['imagem'];
      }
      
      // Atualiza a senha apenas se o usuário tiver inserido uma nova senha
      if (!empty($senha)) {
        $senha = sha1($senha); // Criptografa a nova senha
    } else {
        $senha = $dadosUsuario['senha']; // Mantém a senha antiga
    }

     if (!empty($nome) && !empty($email)) {
        $usuario->atualizarUsuario($id_upd, $nome, $email, $cpf, $telefone, $senha, $imagem);
        header("location: dados-atualizados.php");
        } else {
        echo '<h4>Preencha todos os campos.</h4>';
      }
    }
  }

  ?>

  <section class="page-cadastro-usuario paddingBottom50">
    <div class="container">
      <div>
        <a href="dashboard.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Meus dados de usuário</span>
        </a>
      </div>
        <div class="container-small">
        <form method="post" enctype="multipart/form-data" id="form-cadastro-usuario">
          <div class="bloco-inputs">
            <div>
              <label class="input-label">Nome</label>
              <input type="text" class="nome-input" name="nome" value="<?php echo $dadosUsuario['nome'] ?>">
            </div>
            <div>
              <label class="input-label">E-mail</label>
              <input type="text" class="email-input" name="email" value="<?php echo $dadosUsuario['email'] ?>">
            </div>
            <div>
              <label class="input-label">CPF</label>
              <input type="text" class="cpf-input" name="cpf" value="<?php echo $dadosUsuario['cpf'] ?>">
            </div>
            <div>
              <label class="input-label">Telefone</label>
              <input type="tel" class="telefone-input" name="telefone" value="<?php echo $dadosUsuario['telefone'] ?>">
            </div>
            <div>
              <label class="input-label">Senha</label>
              <input type="password" class="senha-input" name="senha" value="">
            </div>
            <div>
              <label class="bt-foto" for="bt-foto">Escolher foto</label>
              <input id="bt-foto" type="file" name="imagem">
            </div>
          </div>
          <button type="submit" class="button-default">Atualizar dados</button>
          <button type="submit" class="button-default" name="acao" value="excluir">Excluir minha conta</button>
        </form>
      </div>
    </div>
  </section>
</body>

</html>

<?php
  // Verifica se o botão excluir foi clicado e exclui usuario
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['acao']) && $_POST['acao'] == 'excluir') {
    $usuario->excluirUsuario($user_id);
    header('location: index.php');
  }

?>