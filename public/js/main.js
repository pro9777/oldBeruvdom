const myLink = document.querySelectorAll('.header-line_right__info .subtitle');

for (let i = 0; i < myLink.length; i++) {
    myLink[i].addEventListener('click', function (event) {
        console.log(1)
        if (!myLink[i].classList.contains('header_number')) {
            myLink[i].classList.add('header_number');

        }

    });
}


function chips(message, bg = '', timeremove = 3000) {
    // if (timeremove === undefined) timeremove = 3000;
    let chips = document.createElement('div');
    chips.classList.add('chips');
    chips.classList.add(bg);
    chips.innerHTML = message;
    //document.querySelector('body').appendChild(chips);
    addChips(chips);
    setTimeout(function () {
        deleteChips(chips)
    }, timeremove);
}

function deleteChips(chips) {
    chips.remove();
    let allChips = document.querySelectorAll('.chips-field .chips');
    if (allChips.length == 0) document.querySelector('.chips-field').remove();
}

function addChips(chips) {
    let chipsField = document.querySelector('.chips-field');
    if (chipsField) {
        chipsField.appendChild(chips);
    } else {
        let chipsField = document.createElement('div');
        chipsField.classList.add('chips-field');
        document.querySelector('body').appendChild(chipsField);
        chipsField.appendChild(chips);
    }
}

//document.querySelector('.cart-title2').onclick = function () {
//    chips('hello', 5000);
//}
window.addEventListener('load', (e) => {
    if (window.innerWidth <= 1100) {
        moveBlock('.basked-right__cont', '.basked .container');
    } else {
        moveBlock('.basked-right__cont', '.basked .container', '.basked-cont');
    }
});

window.addEventListener('resize', (e) => {
    if (window.innerWidth <= 1100) {
        moveBlock('.basked-right__cont', '.basked .container');
    } else {
        moveBlock('.basked-right__cont', '.basked .container', '.basked-cont');
    }
});

function moveBlock(classBlock, classParent, classBackBlock = '') {
    let block = document.querySelector(classBlock);
    let parent = document.querySelector(classParent);
    let check = document.querySelector(`${classBackBlock} ${classBlock}`);
    if (block) {
        if (!classBackBlock) {
            parent.appendChild(block);
        } else {
            if (!check) {
                document.querySelector('.basked-cont').appendChild(block);
            }
        }
    }
}


let more = document.querySelectorAll('.more_open');

for (let i = 0; i < more.length; i++) {
    more[i].onclick = () => {
        console.log(more[i].offsetParent.style.height = 'auto');
        more[i].remove()
    }
}
