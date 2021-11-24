function changeActiveInputs(e) {
    // console.log(e.target.value);
    ['house', 'flat', 'plot'].forEach(cat => {
        document.querySelector(`div[data-name='${cat}']`).style.display = 'none';
    });

    let itemToShow = document.querySelector(`div[data-name=${e.target.value}]`);
    itemToShow.style.display = '';
}


let selectInput = document.querySelector('#category');

changeActiveInputs({target: selectInput});
selectInput.addEventListener('change', changeActiveInputs);