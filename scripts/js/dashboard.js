let buttonActionForm = document.getElementsByClassName("buttonAction")
buttonActionForm = [...buttonActionForm]

let allNotConfirmedInputsCollections = document.querySelectorAll("form.notConfirmed .checkCollection")

let allConfirmedInputsCollections = document.querySelectorAll("form.confirmed .checkCollection")

buttonActionForm.forEach(el => {
    let form = el.parentNode.parentNode.parentNode
    let actionForm = form.getAttribute('action')
    let newActionForm;
    el.addEventListener('click', () => {
        switch (event.target.innerText) {
            case "Confirmar":
                newActionForm = 'accept'
                break;
            case "Cancelar":
                newActionForm = 'refuse'
                break;
            case "Alterar":
                newActionForm = 'alter'
                break;
            default:
                // Caso seja "finalizar"
                newActionForm = 'end'
                break;
        }


        allNotConfirmedInputsCollections.forEach(input => {
            if(input.checked == true) {
                form.setAttribute('action', `${actionForm}-${newActionForm}`)
                form.submit()
            }
        })

        let allCheckedInputs = []
        allConfirmedInputsCollections.forEach(input => {
            if(input.checked == true) {
                allCheckedInputs.push(input)
            }
        })

        if(allCheckedInputs.length == 1 && newActionForm == 'alter') {
            form.setAttribute('action', `${actionForm}-${newActionForm}`)
            form.submit()
        }

        if(newActionForm == 'end') {
            // form.setAttribute('action', `${actionForm}-${newActionForm}`)
            // form.submit()

            allConfirmedInputsCollections.forEach(input => {
                if(input.checked == true) {
                    form.setAttribute('action', `${actionForm}-${newActionForm}`)
                    form.submit()
                }
            })
        }
    })
})

// Seleciona todas as tabelas
let allTables = document.querySelectorAll('table')

allTables.forEach(table => {
    let messageDefault = table.previousElementSibling

    // Se a mensagem padrão existir (não existir dados para popular a tabela), aplicar um estilo na tabela, para deixa-la com estilizacão.
    if(messageDefault != null && messageDefault.className.includes('messageCollectionNotExist') || messageDefault != null && messageDefault.className.includes('messageCollectionNotFocus')) {
        table.style.display = 'inline-flex';
        table.children[0].children[0].style.display = 'inline-table'
        table.children[0].children[0].style.minWidth = '100%'
    }
})