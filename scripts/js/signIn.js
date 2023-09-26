let optionsForm = document.querySelectorAll('#optionsForm .option input')
let forms = document.querySelectorAll('.form')
let titleContainer = document.getElementById('titleContainer')

optionsForm.forEach(input => {
    input.addEventListener('change', () => {
        let fomsArray = [...forms]

        fomsArray.map((form) => {
            form.classList.toggle('active')

            if(form.classList[1] == 'institution' && form.classList[2] == 'active') {
                let subTitleElement = document.createElement('h4')
                subTitleElement.innerText = 'INSTITUIÇÃO'
                subTitleElement.classList.add('subTitle')

                titleContainer.appendChild(subTitleElement)
            } else if(titleContainer.children.length > 1) {
                titleContainer.removeChild(titleContainer.lastChild)
            }
        })
    })
})
