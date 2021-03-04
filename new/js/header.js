const input = document.querySelector('.header__search input[type="text"]');
const searchbar = document.querySelector('.header__search');
const header = document.querySelector('.header');
const searchIcon = document.querySelectorAll('.header__search-icon')[0];
const cancelIcon = document.getElementById('header__cancel-icon');

// input.addEventListener('keydown', function(e) {

//   clearTimeout(this.timeoutID);
//   this.timeoutID = setTimeout(search.bind(this), 300); // call, apply

// })

// function search() { console.log(this.value)};

searchIcon.addEventListener('click', () => {
  input.value = '';
  if (window.screen.width <= 800) {
    searchbar.toggleAttribute('smallScreen');
    header.classList.toggle('smallScreen');
  }
});

cancelIcon.addEventListener('click', () => {
  if (window.screen.width <= 800) {
    searchbar.toggleAttribute('smallScreen');
    header.classList.toggle('smallScreen');
  }
  setTimeout(() => {
    input.value = '';
  }, 1000);
});