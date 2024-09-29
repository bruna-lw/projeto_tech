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
  <title>Relatório de Vendas</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/vendas.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
  <link rel="stylesheet" href="./assets/css/styles2.css">
</head>

<body>
  <header>
    <?php
      require_once 'header.php';
    ?>
  </header>
  <section class="page-gerenciamento-produto paddingBottom50">
    <div class="container">
      <div class="d-flex justify-content-between">
        <a href="dashboard.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Relatório de Vendas</span>
        </a>
        <!-- <a href="cadastro-produto.php" class="bt-add">Adicionar novo produto</a> -->
      </div>
      <div class="filtro-data">
        <form class="filtro" method="GET" action="">
          <div class="input-group">
            <div class="input-item">
              <label for="data_inicio">Data Início:</label>
              <input type="date" id="data_inicio" name="data_inicio" required>
            </div>
            <div class="input-item">
              <label for="data_fim">Data Fim:</label>
              <input type="date" id="data_fim" name="data_fim" required>
            </div>
          </div>
          <button type="submit">Filtrar</button>
        </form>
      </div>
      <div class="shadow-table">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Data</th>
              <th>Cliente</th>
              <th>Produtos</th>
              <th>Valor</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
              // $dados = $pedido->buscarDados();
              if(count($dadosPedido) > 0){
                foreach ($dadosPedido as $dado) {
                  echo "<tr>";
                  echo "<td>".$dado['id_pedido']."</td>";
                  echo "<td>".date('d/m/Y', strtotime($dado['data_pedido']))."</td>";
                  echo "<td>".$dado['nome_cliente']."</td>";
                  echo "<td>".$dado['produtos']."</td>";
                  echo "<td>".$dado['valor_total']."</td>";
                  echo "<td>
                          <span class='status-text'>".$dado['status']."</span>
                          <a href='editar-status-pedido.php?id_up=".$dado['id_pedido']."' class='edit-button'>Editar</a>
                        </td>";
                  echo "</tr>";
              }
              }
            ?> 
          </tbody>
        </table>
      </div>
    </div>
  </section>
</body>

</html>
