// /*loader*/
window.addEventListener('load', function () {
  const loader = document.querySelector('.loader')
  loader.className += ' hidden'
})

/***toggle menu **/
let toggleMenu = document.getElementById('toggleMenu')
      // let menu = document.getElementById('menu')

      toggleMenu.addEventListener('click', () => {
          toggleMenu.classList.toggle('active')
      })


/*******PARALLAX ******/
let text = document.getElementById('text');
window.addEventListener('scroll' , function(){
  let value = window.scrollY;
  text.style.marginBottom = value * 1.5 + 'px';
})


/*****HEADER SCROLL******/
const header = document.querySelector('#header')
const navHeight = header.offsetHeight

window.addEventListener('scroll', function () {
  if (window.scrollY >= navHeight) {
    //scroll maior que a altura do header
    header.classList.add('scroll')
  } else {
    //scroll menor que a altura do header
    header.classList.remove('scroll')
  }
})

