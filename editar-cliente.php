<?php
// Inicia a sessão no início do script, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'classes/cliente.php';
// Criação de uma instância da classe Cliente
$cliente = new Cliente("projeto", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar cliente</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
  <link rel="stylesheet" href="./assets/css/styles2.css">
</head>

<body>
  <header>
    <?php
      require_once 'header.php';
    ?>
  </header>

  <?php
  if(isset($_GET['id_up'])){
    $id_update = addslashes($_GET['id_up']);
    $dadosCliente = $cliente->buscarDadosCliente($id_update);
  }

  if(isset($_POST['nome'])){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id_upd = addslashes($_GET['id_up']);
      $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
      $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);

     if (!empty($nome) && !empty($email) && !empty($cpf)) {
        $cliente->atualizarCliente($id_upd, $nome, $email, $cpf, $telefone);
        header("location: clientes.php");
        } else {
        echo '<h4>Preencha todos os campos.</h4>';
      }
    }
  }
  ?>

  <section class="page-cadastro-cliente paddingBottom50">
    <div class="container">
      <div>
        <a href="clientes.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Editar cliente</span>
        </a>
      </div>
      <div class="container-small">
        <form method="post" id="form-cadastro-cliente">
          <div class="bloco-inputs">
            <div>
              <label class="input-label">Nome</label>
              <input type="text" class="nome-input" name="nome" value="<?php echo $dadosCliente['nome'] ?>">
            </div>
            <div>
              <label class="input-label">E-mail</label>
              <input type="text" class="email-input" name="email" value="<?php echo $dadosCliente['email'] ?>">
            </div>
            <div>
              <label class="input-label">CPF</label>
              <input type="text" class="cpf-input" id="cpf" name="cpf" value="<?php echo $dadosCliente['cpf'] ?>" maxlength="14">
            </div>
            <div>
              <label class="input-label">Telefone</label>
              <input type="tel" class="telefone-input" id="telefone" name="telefone" value="<?php echo $dadosCliente['telefone'] ?>" maxlength="15">
            </div>
          </div>
          <button type="submit" class="button-default">Atualizar dados do cliente</button>
        </form>
      </div>
    </div>
  </section>
<script src="controller/mascara.js"></script>
</body>

</html>