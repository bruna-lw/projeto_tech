<?php
// Inicia a sessão no início do script, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se há um ID de pedido na sessão
$id_pedido = isset($_SESSION['id_pedido']) ? $_SESSION['id_pedido'] : null;

// Limpa o ID de pedido da sessão para evitar reutilização
unset($_SESSION['id_pedido']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pedido criado</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/styles2.css">
  <link rel="stylesheet" href="./assets/css/index.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
</head>

<body>
  <header>
    <?php
      require_once 'header.php';
    ?>
  </header>

  <section class="page-cadastro-cliente paddingBottom50">
    <div class="container">
      <div>
        <a href="dashboard.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Voltar</span>
        </a>
      </div>
    </div>
    <h4>Pedido criado com sucesso!</h4>

    <?php if ($id_pedido): ?>
        <h4>ID do Pedido: <strong><?php echo htmlspecialchars($id_pedido); ?></strong></h4>
      <?php else: ?>
        <h4>Erro ao recuperar o ID do pedido.</h4>
    <?php endif; ?>

  </section>
</body>

</html>