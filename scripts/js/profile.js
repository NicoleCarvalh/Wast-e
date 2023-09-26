let btnsActionsForm = document.querySelectorAll(".btnActionForm")
let btnsActionsArray = [...btnsActionsForm]

btnsActionsArray.forEach(btn => {
    btn.addEventListener('click', () => {
        if(btn.className.includes('submit')) {
            let form = btn.parentNode.parentNode.parentNode.children[1]
            form.submit()
        } else {
            window.location.reload()
        }
    })
})
