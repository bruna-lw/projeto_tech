// Procura o produto no bd e retorna no datalist
document.getElementById('produto-input').addEventListener('input', function() {
  const produtoNome = this.value;

  fetch(`controller/fetch_produtos.php?query=${produtoNome}`)
    .then(response => response.json())
    .then(data => {
      let datalist = document.getElementById('produto-list');
      datalist.innerHTML = ''; // Limpa as opções antigas

      if (data.length > 0) {
        data.forEach(produto => {
          let option = document.createElement('option');
          option.value = produto.nome; // Preenche com o nome do produto
          datalist.appendChild(option);
        });
      }
    });
});

// Filtra o produto na tabela de estoque
document.getElementById('produto-input').addEventListener('change', function() {
  const produtoNome = this.value;

  fetch(`controller/fetch_produtos.php?query=${produtoNome}`)
    .then(response => response.json())
    .then(data => {
      let tableBody = document.querySelector('tbody');
      tableBody.innerHTML = ''; // Limpa os dados antigos da tabela

      if (data.length > 0) {
        data.forEach(produto => {
          let row = document.createElement('tr');

          row.innerHTML = `
            <td>${produto.id_produto}</td>
            <td>${produto.nome}</td>
            <td>${produto.sku}</td>
            <td>${produto.quantidade}</td>
            <td>
              <a href='editar-estoque.php?id_up=${produto.id_produto}' class='edit-button'>Editar estoque</a>
            </td>
          `;

          tableBody.appendChild(row);
        });
      } else {
        tableBody.innerHTML = '<tr><td colspan="7">Nenhum produto encontrado</td></tr>';
      }
    });
});
