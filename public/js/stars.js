document.addEventListener('DOMContentLoaded', function(){ //document.ready
  
    var starsItems = document.getElementsByClassName('stars-block');
    
        for (let starsItem of starsItems) {
            var starsValue = starsItem.getAttribute('data-stars');
            var stars5Width = starsItem.querySelector('.light').getBoundingClientRect().width;
            var newWidth = (starsValue * stars5Width) / 5;
            var main_stars = starsItem.querySelector('.main-stars');
            main_stars.style.width = newWidth + 'px';
       };
  
  });
  
  
  