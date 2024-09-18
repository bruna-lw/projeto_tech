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
  <title>Editar estoque</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/styles2.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
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
    $dadosProduto = $produto->buscarDadosProduto($id_update);
  }


  if(isset($_POST['adicao'])){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id_upd = addslashes($_GET['id_up']);
      $quantidadeAdd = filter_input(INPUT_POST, 'adicao', FILTER_SANITIZE_NUMBER_INT);
      $quantidadeRetirada = filter_input(INPUT_POST, 'retirada', FILTER_SANITIZE_NUMBER_INT);

      if (empty($quantidadeAdd) && empty($quantidadeAdd)) {
        echo '<h4>Preencha a quantidade a ser adicionada ou retirada do estoque.</h4>';
      } if (!empty($quantidadeAdd)) {
        $produto->adicionarEstoque($id_upd, $quantidadeAdd);
        echo '<h4>Estoque atualizado com sucesso!</h4>';
        } if (!empty($quantidadeRetirada)){
            $produto->retirarEstoque($id_upd, $quantidadeRetirada);
            echo '<h4>Estoque atualizado com sucesso!</h4>';
          } 
    } 
   }
  

  ?>


  <section class="page-cadastro-produto paddingBottom50">
    <div class="container">
      <div>
        <a href="estoques.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Editar estoque</span>
        </a>
      </div>
      <div class="container-small">
        <form method="POST" id="form-cadastro-produto">
          <div class="bloco-inputs">
            <div>
              <pre>
              <?php echo "<p>Produto: ".$dadosProduto['nome']."</p>"; ?>
              </pre>
              <?php echo "<p>SKU: ".$dadosProduto['sku']."</p>"; ?>
            </div>
            <div class="flex-2">
              <div>
                <label class="input-label">Quantidade do produto a ser incluída no estoque:</label>
                <input type="text" class="nome-input" name="adicao">
              </div>
              <div>
                <!-- <label class="input-label">Quantidade do produto a ser retirada no estoque:</label>
                <input type="text" class="nome-input" name="retirada"> -->
              </div>
            </div>
          </div>
          <button type="submit" class="button-default">Atualizar estoque</button>
        </form>
      </div>
    </div>
  </section>
</body>

</html>