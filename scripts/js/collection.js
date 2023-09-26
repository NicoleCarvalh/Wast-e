let companiesForm = document.getElementById('companiesForm')
let companiesInputs = document.querySelectorAll('[name=companie]')

companiesInputs.forEach(input => {
    input.addEventListener('change', () => {
        companiesForm.submit();
    })
})