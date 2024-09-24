<?php
// Inicia a sessão no início do script, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'controller/conecta-servidor.php';

  ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Novo pedido</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/styles2.css">
  <link rel="stylesheet" href="./assets/css/novo_pedido.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
      .dropdown {
            display: none;
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            background-color: white;
            z-index: 1000;
            width: 100%;
        }
        .dropdown-item {
            padding: 8px;
            cursor: pointer;
        }
        .dropdown-item:hover {
            background-color: #f0f0f0;
        }
        .dropdown-wrapper {
            position: relative;
        }
  </style>
</head>

<body>
  <header>
    <?php require_once 'header.php'; ?>
  </header>

  <?php
  
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_cliente = filter_input(INPUT_POST, 'nome-cliente', FILTER_SANITIZE_STRING);
    $produtos = $_POST['produto']; // Captura o array de produtos
    $valorTotal = filter_input(INPUT_POST, 'valor-total-pedido', FILTER_SANITIZE_STRING);

    // Checa se todos os campos estão preenchidos
    if (empty($nome_cliente) || empty($produtos) || empty($valorTotal)) {
      echo '<h4>Preencha todos os campos.</h4>';
    } else {

      require_once 'classes/pedido.php';
      $pedido = new Pedido($pdo, $nome_cliente, $produtos, $valorTotal);
      $pedido->criarPedido();
  }
  }
  ?>

  <section class="page-novo-pedido paddingBottom50">
    <div class="container">
      <div>
        <a href="dashboard.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Novo pedido</span>
        </a>
      </div>
      <form id="pedido-form" method="POST">
      <div class="maxW340">
        <label class="input-label">Cliente</label>
        <input type="text" class="input" id="input-cliente" name="nome-cliente" placeholder="Digite o nome do cliente" autocomplete="off">
        <div id="cliente-dropdown" class="dropdown"></div>
      </div>
      <div class="shadow-table">
        <table id="tabela-pedidos">
          <thead>
            <tr>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Valor parcial</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="text" class="input-produto" name="produto[nome][]" placeholder="Digite o nome do produto" autocomplete="off">
              <div class="produto-dropdown dropdown"></div></td>
              <td><input type="number" class="input" name="produto[quantidade][]" value="1"></td>
              <td><input type="text" class="input" name="valorParcial[]" readonly></td>
              <td><a href="#" class="bt-remover"><img src="assets/images/remover.svg" alt="" /></a></td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4">
                <div class="row justify-content-between align-items-center">
                  <div class="col">
                    <a href="#" class="bt-add-produto">
                      <span>Adicionar produto</span>
                      <img src="assets/images/adicionar.svg" alt="" />
                    </a>
                  </div>
                  <div class="blc-subtotal d-flex">
                    <div class="d-flex align-items-center">
                      <span>Subtotal</span>
                      <input type="text" class="input" name="subtotal" disabled value="" />
                    </div>
                    <div class="d-flex align-items-center">
                      <span>Desconto</span>
                      <input type="text" class="input" id="input-desconto" value="0" />
                    </div>
                    <div class="d-flex align-items-center">
                      <span>Total</span>
                      <input type="hidden" class="input" id="valor-total-hidden" name="valor-total-pedido" value="" />
                      <input type="number" class="input" id="valor-total" disabled value="" />
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="maxW340">
        <label class="input-label">Observação</label>
        <input type="text" class="input" name="observacao">
      </div>
      <div class="maxW340">
        <button type="submit" class="button-default">Salvar</button>
      </div>
      </form>
    </div>
  </section>

  <script src="controller/dropdown_clientes.js"></script>
  <script src="controller/dropdown_produtos.js"></script>

  <script>

  // Função para adicionar linha à tabela
  function adicionarLinha() {
    $("#tabela-pedidos tbody").append(
        "<tr>" +
        "<td><input type='text' class='input-produto' name='produto[nome][]' placeholder='Digite o nome do produto' autocomplete='off'>" +
        "<div class='produto-dropdown dropdown'></div></td>" +
        "<td><input type='number' class='input' name='produto[quantidade][]' value='1'></td>" +
        "<td><input type='text' class='input' name='valorParcial[]' readonly></td>" +
        "<td><a href='#' class='bt-remover'><img src='assets/images/remover.svg' alt='' /></a></td>" +
        "</tr>"
    );
  }

  $(function() {
    $(".bt-add-produto").bind("click", adicionarLinha);
  });

  // Remover linha da tabela
  $(document).on('click', '.bt-remover', function() {
    $(this).closest('tr').remove();
    calcularSubtotal(); // Atualiza o subtotal
  });

  </script>
</body>

</html>
