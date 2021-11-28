function changeActiveInputs(e) {
    // console.log(e.target.value);
    ['house', 'flat', 'plot'].forEach(cat => {
        document.querySelector(`div[data-name='${cat}']`).style.display = 'none';
    });

    let itemToShow = document.querySelector(`div[data-name=${e.target.value}]`);
    itemToShow.style.display = '';
}

function changePrice(e) {
    console.log("You changed the input: ", e);
    let rentField = document.querySelector('div[data-name="for_rent"]');
    let priceField = document.querySelector('div[data-name="for_sale"]');
    rentField.style.display = 'none';
    priceField.style.display = 'none';
    if(e.target.value == "rent") {
        rentField.style.display = '';
    }
    else if(e.target.value == "sale") {
        priceField.style.display = '';
    }
    else {
        rentField.style.display = '';
        priceField.style.display = '';
    }
}

function changeAge(e)
{
    let ageField=document.querySelector('div[data-name="age"]');
    ageField.style.display='none';
    if(e.target.value!="plot")
    {
        ageField.style.display='';
    }
}


let selectInput = document.querySelector('#category');
let rentBuySelect = document.querySelector('#for');
console.log(rentBuySelect);

changeActiveInputs({target: selectInput});
changePrice({target: rentBuySelect});
changeAge({target: selectInput});
selectInput.addEventListener('change', changeActiveInputs);
rentBuySelect.addEventListener('change', changePrice);
selectInput.addEventListener('change',changeAge);