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
  <title>Gerenciamento de produto</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/gerenciamento_produto.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
  <link rel="stylesheet" href="./assets/css/styles2.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
          <span>Gerenciamento de produto</span>
        </a>
        <a href="cadastro-produto.php" class="bt-add">Adicionar novo produto</a>
      </div>
      <div class="search-container">
        <label for="">Buscar produto:</label>
        <input type="text" id="produto-input" placeholder="Digite o nome do produto" list="produto-list" autocomplete="off" style="margin: 10px 0; width: 200px; height: 20px;">
        <datalist id="produto-list"></datalist>
      </div>
      <script src="controller/busca_produto.js"></script>
      <div class="shadow-table">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Imagem</th>
              <th>Nome</th>
              <th>SKU</th>
              <th>Descrição</th>
              <th>Valor</th>
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
                  // Exibir a imagem
                  echo "<td>";
                  if (!empty($dado['imagem'])) {
                      // Converter a imagem para base64 e exibir
                      $imgData = base64_encode($dado['imagem']);
                      echo "<img src='data:image/jpeg;base64,$imgData' alt='Imagem do Produto' width='auto' height='100'>";
                  } else {
                      echo "";
                  }
                  echo "</td>";
                  echo "<td>".$dado['nome']."</td>";
                  echo "<td>".$dado['sku']."</td>";
                  echo "<td>".$dado['descricao']."</td>";
                  echo "<td>".$dado['valor']."</td>";
                  echo "<td>
                          <a href='editar-produto.php?id_up=".$dado['id_produto']."' class='edit-button'>Editar</a>
                          <a href='produtos.php?id=".$dado['id_produto']."' class='edit-button'>Excluir</a>
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

<?php
  // Método para excluir produto a partir do botão Excluir
  if(isset($_GET['id'])){
    $id_prod = addslashes($_GET['id']);
    $produto->excluirProduto($id_prod);
    header("location: produtos.php");
  }
?>