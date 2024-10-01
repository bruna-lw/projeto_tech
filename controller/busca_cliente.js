// Procura o clinte no bd e retorna no datalist
document.getElementById('cliente-input').addEventListener('input', function() {
  const clienteNome = this.value;

  fetch(`controller/fetch_clientes.php?search=${clienteNome}`)
    .then(response => response.json())
    .then(data => {
      let datalist = document.getElementById('cliente-list');
      datalist.innerHTML = ''; // Limpa as opções antigas

      if (data.length > 0) {
        data.forEach(cliente => {
          let option = document.createElement('option');
          option.value = cliente.nome; // Preenche com o nome do cliente
          datalist.appendChild(option);
        });
      }
    });
});

// Filtra o cliente na tabela
document.getElementById('cliente-input').addEventListener('change', function() {
  const clienteNome = this.value;

  fetch(`controller/fetch_clientes.php?search=${clienteNome}`)
    .then(response => response.json())
    .then(data => {
      let tableBody = document.querySelector('tbody');
      tableBody.innerHTML = ''; // Limpa os dados antigos da tabela

      if (data.length > 0) {
        data.forEach(cliente => {
          let row = document.createElement('tr');

          row.innerHTML = `
            <td>${cliente.id_cliente}</td>
            <td>${cliente.nome}</td>
            <td>${cliente.cpf}</td>
            <td>${cliente.email}</td>
            <td>${cliente.telefone}</td>
            <td>
              <a href='editar-cliente.php?id_up=${cliente.id_cliente}' class='edit-button'>Editar</a>
              <a href='clientes.php?id=${cliente.id_cliente}' class='edit-button'>Excluir</a>
            </td>
          `;

          tableBody.appendChild(row);
        });
      } else {
        tableBody.innerHTML = '<tr><td colspan="7">Nenhum cliente encontrado</td></tr>';
      }
    });
});

