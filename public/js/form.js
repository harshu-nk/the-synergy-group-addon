document.addEventListener('DOMContentLoaded', function(){ //document.ready

    const selectSingle_labels = document.querySelectorAll('.select-name');
    const selectSingle_ul = document.querySelectorAll('.select');

    for (let i = 0; i < selectSingle_labels.length; i++) {
        selectSingle_labels[i].addEventListener('click', (evt) => {
            var parent = selectSingle_labels[i].closest('.select');
            var idInput = parent.querySelector('input').getAttribute('id');

            for (let k = 0; k < selectSingle_ul.length; k++) {
                if(selectSingle_ul[k].querySelector('input').getAttribute('id') != idInput) {
                  selectSingle_ul[k].classList.remove('show');
                }
            }

            parent.classList.toggle("show");
        });
    }

    const list_li = document.querySelectorAll('.select li');

    for (let i = 0; i < list_li.length; i++) {
        list_li[i].addEventListener('click', (evt) => {
            var parent = list_li[i].closest('.select');
            if(parent.classList.contains('multi-select')) {
                list_li[i].classList.toggle("li-active");
                var list_sel_items = parent.querySelectorAll('.li-active');
                var res_arr = [];
                for (let k = 0; k < list_sel_items.length; k++) {
                    res_arr.push(list_sel_items[k].textContent);
                }
                parent.querySelector('input').setAttribute('value', res_arr.join(", "));
                parent.querySelector('span').textContent = res_arr.join(", ");
            } else {
                var sel = list_li[i].textContent;
                parent.classList.remove("show");
                parent.querySelector('input').setAttribute('value', sel);
                parent.querySelector('span').textContent = sel;
            }
        });
    }

    window.onclick = function(event) {
        if (!event.target.matches('.select-name, .select-name span, .multi-select li')) {
        var dropdowns = document.getElementsByClassName("select");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
        }
    }

    /*checkboxes js begin*/
    var element = document.querySelectorAll('.checkbox-block .check-container');
    for(var i = 0; i < element.length; i++){
        element[i].addEventListener("click", function(event){
        var mas = new Array();

        var parent = event.target.closest('.checks');
        var childs =  parent.querySelectorAll('.checkmark');

        for(var k = 0; k < childs.length; k++){
            childs[k].classList.remove('check');
        }

        var element2 = parent.querySelectorAll('.check-container');
        for(var m = 0; m < element2.length; m++){
            var val = element2[m].querySelector('span').innerText;
            if(element2[m].querySelector('input').checked) {
            mas.push(val);
            }
            /*alert(val);*/
        }

        parent.closest('.checkbox-block').querySelector('input.hidfield').setAttribute("value", mas);

        }, false); 
    }
    /*checkboxes js end*/

});

/*$(document).ready(function(){
    
    $(document).on('click', '.select-name', function(){ 
        $(this).parent('.select').find('ul').slideToggle();
        $(this).parent('.select').find('.select-name').toggleClass('sel');
        $(this).parent('.select').toggleClass('selcl');
    });

    $(document).on('click', '.select ul li', function(){ 
        var sel = $(this).text();
        $(this).parent('ul').parent('.select').find('input').attr('value',sel);
        $(this).parent('ul').parent('.select').find('.select-name').text(sel);
        $(this).parent('ul').slideUp();
        $(this).parent('ul').parent('.select').find('.select-name').removeClass('sel');
        $(this).parent('ul').parent('.select').toggleClass('selcl');
    });

});*/
    
    
    