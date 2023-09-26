let submitButton = document.querySelector("button[type='submit']")
let allInputsRequired = document.querySelectorAll('input[required], select[required]')
let userForm = document.getElementById('userForm')
let residueForm = document.getElementById('residueForm')

const verifyAllElements = (element) => element.value != '';

submitButton.addEventListener('click', () => {

    let allInputsUserForm = document.querySelectorAll('#userForm input')
    let div = document.createElement('div')
    div.style.display = 'none'
    div.style.position = 'absolute'
    div.style.inset = '0' 

    if([...allInputsRequired].every(verifyAllElements)){

        allInputsUserForm.forEach(input => {
            div.appendChild(input.cloneNode(true))
        })   

        residueForm.appendChild(div)

        residueForm.submit()
    } else {
        alert('Preencha todos os campos obrigatórios')
    }
})

window.addEventListener('load', () => {
    let controllerGet = window.location.search.split('?').pop()
    if(controllerGet == 'Success') {
        alert('Usuário e solicitação, cadastrados com sucesso')
    } else if(controllerGet == 'Usuario&SolicitacaoExistem') {
        alert('Este usuário já possui um cadastro com uma solicitação em aberto.')
    }

})