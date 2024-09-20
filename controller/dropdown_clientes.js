$(document).ready(function() {
    // Função para buscar clientes
    function fetchClientes() {
        $.get('controller/fetch_clientes.php', function(data) {
            const clientes = JSON.parse(data);
            const dropdown = $('#cliente-dropdown');
            dropdown.empty(); // Limpa opções anteriores

            clientes.forEach(cliente => {
                const item = $('<div>')
                    .addClass('dropdown-item')
                    .text(cliente.nome)
                    .data('id', cliente.id_cliente)
                    .click(function() {
                        $('#input-cliente').val(cliente.nome); // Preenche o input
                        dropdown.hide(); // Esconde o dropdown
                    });
                dropdown.append(item);
            });
        });
    }

    // Buscar clientes ao focar no input
    $('#input-cliente').focus(function() {
        fetchClientes();
        $('#cliente-dropdown').show(); // Mostra o dropdown
    });

    // Esconder o dropdown ao clicar fora
    $(document).click(function(event) {
        if (!$(event.target).closest('#input-cliente').length) {
            $('#cliente-dropdown').hide(); // Esconde o dropdown
        }
    });
});
