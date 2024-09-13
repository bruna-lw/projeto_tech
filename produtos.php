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
      <div class="shadow-table">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <!-- <th>Imagem</th> -->
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
                  for ($i=0; $i < count($dados); $i++){
                      // abrindo a linha para preencher os dados com <tr> em html
                      echo "<tr>";
                      foreach ($dados[$i] as $k => $v) {
                              // abrindo o campo para preencher a coluna com <td> em html
                              echo "<td>".$v."</td>";
                      }
                      // ultima coluna não é preenchida com dados do banco, pois são links fixos. Por isso fecha o php, deixa o html e volta a abrir php após.
                    ?><td>
                      <a href="editar-produto.php?id_up=<?php echo $dados[$i]['id_produto']; ?>" class="edit-button">Editar</a> 
                      <a href="produtos.php?id=<?php echo $dados[$i]['id_produto']; ?>" class="edit-button">Excluir</a>
                </td><?php
                  }
                      echo "</tr>";
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