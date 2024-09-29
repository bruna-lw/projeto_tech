<?php
// Inicia a sessão no início do script, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'controller/conecta-servidor.php';
require 'controller/fetch-pedidos.php'

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status do pedido</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
  <link rel="stylesheet" href="./assets/css/styles2.css">
  <style>
    .status-select {
      border-radius: 4px;
      border: 1px solid #CCCCCC;
      height: 48px;
      padding: 0 16px;
      margin: 10px 0 20px;
      width: 100%;
      box-sizing: border-box;
      font-size: 16px;
    }
  </style>
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
        <a href="vendas.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Status do pedido</span>
        </a>
        <?php
        // Verifica se o array $dadosPedido tem dados
        if (!empty($dadosPedido) && isset($dadosPedido[0])) {
          $pedido = $dadosPedido[0]; // O primeiro resultado
          } else {
          $pedido = null; // Caso o array esteja vazio ou não tenha o índice 0
          }

        // Atualizar o status no banco de dados se o formulário for enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status']) && isset($pedido['id_pedido'])) {
            $novoStatus = $_POST['status'];
            $idPedido = $pedido['id_pedido'];

            // Atualiza o status no banco de dados
            $sql = "UPDATE pedido SET status = :status WHERE id_pedido = :id_pedido";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':status', $novoStatus);
            $stmt->bindParam(':id_pedido', $idPedido);
            $stmt->execute();

            // Atualiza a variável $pedido com o novo status
            $pedido['status'] = $novoStatus;

            header('location: dados-atualizados.php');
            echo "Status atualizado com sucesso!";
        }
        ?>
      </div>
      <div class="container-small">
        <form method="post" id="form-cadastro-cliente">
          <div class="bloco-inputs">
            <div>
              <label class="input-label">Nome</label>
              <input type="text" class="nome-input" name="nome" disabled value="<?php echo $pedido['nome_cliente'] ?>">
            </div>
            <div>
              <label class="input-label">Novo status</label>
              <select name="status" class="status-select">
                <option value="Confirmado" <?php echo ($pedido['status'] == 'Confirmado') ? 'selected' : ''; ?>>Confirmado</option>
                <option value="Em Separação" <?php echo ($pedido['status'] == 'Em Separação') ? 'selected' : ''; ?>>Em Separação</option>
                <option value="Enviado" <?php echo ($pedido['status'] == 'Enviado') ? 'selected' : ''; ?>>Enviado</option>
                <option value="Concluído" <?php echo ($pedido['status'] == 'Concluído') ? 'selected' : ''; ?>>Concluído</option>
                <option value="Cancelado" <?php echo ($pedido['status'] == 'Cancelado') ? 'selected' : ''; ?>>Cancelado</option>
              </select>
            </div>
          <button type="submit" class="button-default">Atualizar status do pedido</button>
        </form>
      </div>
    </div>
  </section>
</body>

</html>