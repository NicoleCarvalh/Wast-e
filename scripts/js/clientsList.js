let allTables = document.querySelectorAll('table')

allTables.forEach(table => {
    let messageDefault = table.previousElementSibling

    // Se a mensagem padrão existir (não existir dados para popular a tabela), aplicar um estilo na tabela, para deixa-la com estilizacão.
    if(messageDefault != null && messageDefault.className.includes('messageClientsNotExist')) {
        table.style.display = 'inline-flex';
        table.children[0].children[0].style.display = 'inline-table'
        table.children[0].children[0].style.minWidth = '100%'
    }
})