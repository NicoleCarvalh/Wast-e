let allInputsForms = document.querySelectorAll("form input[required]")

window.addEventListener('load', () => {
    let variableController = window.location.search

    if(variableController == '?UsuarioInexistente') {
        allInputsForms.forEach(input => {
            input.style.borderBottom = "2px solid #FF0000"

            input.addEventListener('change', () => {
                input.style.border = "none"
            })
        })
    }
})