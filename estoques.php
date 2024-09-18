<?php
// Inicia a sessão no início do script, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'classes/produto.php';
// Criação de uma instância da classe Produto
$produto = new Produto("projeto", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciamento de estoque</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/gerenciamento_produto.css">
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
          <span>Estoque de produto</span>
        </a>
        <!-- <a href="cadastro-produto.php" class="bt-add">Adicionar novo produto</a> -->
      </div>
      <div class="shadow-table">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <!-- <th>Imagem</th> -->
              <th>Nome</th>
              <th>SKU</th>
              <!-- <th>Descrição</th> -->
              <!-- <th>Valor</th> -->
              <th>Estoque</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              $dados = $produto->buscarDados();
              if(count($dados) > 0){
                foreach ($dados as $dado) {
                  echo "<tr>";
                  echo "<td>".$dado['id_produto']."</td>";
                  echo "<td>".$dado['nome']."</td>";
                  echo "<td>".$dado['sku']."</td>";
                  echo "<td>".$dado['quantidade']."</td>";
                  echo "<td>
                          <a href='editar-estoque.php?id_up=".$dado['id_produto']."' class='edit-button'>Editar estoque</a>
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
