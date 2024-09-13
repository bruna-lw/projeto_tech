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
  <title>Editar produto</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/cadastro_produto.css">
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

  if(isset($_POST['nome'])){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id_upd = addslashes($_GET['id_up']);
      $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
      $sku = filter_input(INPUT_POST, 'sku', FILTER_SANITIZE_STRING);
      $valor = filter_input(INPUT_POST, 'valor');
      $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);

     if (!empty($nome) && !empty($sku) && !empty($valor) && !empty($descricao)) {
        $produto->atualizarProduto($id_upd, $nome, $sku, $valor, $descricao);
        header("location: produtos.php");
        } else {
        echo '<h4>Preencha todos os campos.</h4>';
      }
    }
  }

  ?>


  <section class="page-cadastro-produto paddingBottom50">
    <div class="container">
      <div>
        <a href="dashboard.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Editar produto</span>
        </a>
      </div>
      <div class="container-small">
        <form method="post" id="form-cadastro-produto">
          <div class="bloco-inputs">
            <div>
              <label class="input-label">Nome</label>
              <input type="text" class="nome-input" name="nome" value="<?php echo $dadosProduto['nome'] ?>">
            </div>
            <div>
              <label class="input-label">Descrição</label>
              <textarea class="textarea" name="descricao"><?php echo $dadosProduto['descricao'] ?></textarea>
            </div>
            <div class="flex-2">
              <div>
                <label class="input-label">SKU</label>
                <input type="text" class="sku-input" name="sku" value="<?php echo $dadosProduto['sku'] ?>">
              </div>
              <div>
                <label class="input-label">Valor</label>
                <input type="text" class="valor-input" name="valor" value="<?php echo $dadosProduto['valor'] ?>">
              </div>
            </div>
            <div>
              <label class="bt-arquivo" for="bt-arquivo">Adicionar imagem</label>
              <input id="bt-arquivo" type="file">
            </div>
          </div>
          <button type="submit" class="button-default">Atualizar produto</button>
        </form>
      </div>
    </div>
  </section>
</body>

</html>