<?php

$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : null;
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : null;



// Formatar as datas para o formato adequado para o banco de dados
if ($data_inicio) {
  // Verificar se a data está no formato correto
  $dateObjectInicio = DateTime::createFromFormat('Y-m-d', $data_inicio);
  if ($dateObjectInicio) {
      // Formatar para o formato do banco de dados
      $data_inicio = $dateObjectInicio->format('Y-m-d') . ' 00:00:00';
  } else {
      echo "Data de início inválida.";
      exit; // Para evitar que o restante do código seja executado
  }
}

if ($data_fim) {
  // Verificar se a data está no formato correto
  $dateObjectFim = DateTime::createFromFormat('Y-m-d', $data_fim);
  if ($dateObjectFim) {
      // Formatar para o formato do banco de dados
      $data_fim = $dateObjectFim->format('Y-m-d') . ' 23:59:59';
  } else {
      echo "Data de fim inválida.";
      exit; // Para evitar que o restante do código seja executado
  }
}


echo $data_inicio;

//  Buscar e retornar os dados do BD
$sql = "SELECT 
        pedido.id_pedido AS id_pedido,
        pedido.data_pedido, 
        cliente.nome AS nome_cliente, 
        GROUP_CONCAT(CONCAT(produtos_pedido.quantidade, ' unidade(s) - ', produto.nome) SEPARATOR ', <br>') AS produtos,
        pedido.valor_total
      FROM 
        pedido
      LEFT JOIN 
        cliente ON pedido.id_cliente = cliente.id_cliente
      LEFT JOIN 
        produtos_pedido ON pedido.id_pedido = produtos_pedido.id_pedido
      LEFT JOIN 
        produto ON produtos_pedido.id_produto = produto.id_produto";


// Adicionar a cláusula WHERE se as datas forem fornecidas
if ($data_inicio && $data_fim) {
  // Filtrar pela data de início e fim
  $sql .= " WHERE
              pedido.data_pedido BETWEEN :data_inicio AND :data_fim";
}

$sql .= " GROUP BY 
          pedido.id_pedido
         ORDER BY 
          pedido.id_pedido desc";

$stmt = $pdo->prepare($sql);

if ($data_inicio && $data_fim) {
  $stmt->bindParam(':data_inicio', $data_inicio);
  $stmt->bindParam(':data_fim', $data_fim);
}
$stmt->execute();

$dadosPedido = array();
$dadosPedido = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>