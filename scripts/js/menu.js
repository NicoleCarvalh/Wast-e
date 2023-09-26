let toggleMenu = document.getElementById('toggleMenu')
let dropDown = document.getElementById("dropDown")
let body = document.querySelector('body')

toggleMenu.addEventListener('click', () => {
    toggleMenu.classList.toggle('active')
    body.classList.toggle('overflow')
})

console.log()

if(dropDown != null && window.getComputedStyle(dropDown.children[1]).maxHeight == "0px") {
    dropDown.addEventListener("click", event => {
        if(event.target.className.includes( 'title')) {
            event.target.classList.toggle("active")
            dropDown.children[1].classList.toggle("show")
        }
    })
}