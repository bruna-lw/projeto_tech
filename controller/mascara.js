// Função para formatar CPF automaticamente
document.getElementById('cpf').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for dígito
    if (value.length > 11) value = value.slice(0, 11); // Limita o número de dígitos
  
    // Aplica a máscara ao CPF
    if (value.length > 9) {
      value = value.replace(/(\d{3})(\d)/, '$1.$2');
      value = value.replace(/(\d{3})(\d)/, '$1.$2');
      value = value.replace(/(\d{3})(\d{2})$/, '$1-$2');
    } else if (value.length > 6) {
      value = value.replace(/(\d{3})(\d)/, '$1.$2');
      value = value.replace(/(\d{3})(\d)/, '$1.$2');
    } else if (value.length > 3) {
      value = value.replace(/(\d{3})(\d)/, '$1.$2');
    }
  
    e.target.value = value;
  });
  
  // Função para formatar Telefone automaticamente
  document.getElementById('telefone').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for dígito
    if (value.length > 11) value = value.slice(0, 11); // Limita o número de dígitos
  
    // Aplica a máscara ao Telefone
    if (value.length > 10) {
      value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
    } else if (value.length > 6) {
      value = value.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
    } else if (value.length > 2) {
      value = value.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
    }
  
    e.target.value = value;
  });
  