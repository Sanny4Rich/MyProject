var addToCartButtons, cartInHeader, removeFromCartButtons, cartItems, setCount;

cartInHeader = $('#cart-in-header');
addToCartButtons = $('.js-add-to-cart');
removeFromCartButtons = $('.js-remove-item');
cartItems = $('#cartItems');

addToCartButtons.on('click', function (event) {
    event.preventDefault();
    console.log('Button pressed.');

    $.get(event.target.href, function (data) {
        cartInHeader.html(data);
    });

});

$('body').on('click', '.js-remove-item', function (event) {
    event.preventDefault();

    if(confirm('Действительно удалить?')) {
        mask();

        $.get(event.currentTarget.href, function (data) {
            cartItems.html(data);
            cartInHeader.load(cartInHeader.data('refresh-url'));
            unmask();
        });
    }
});



var headerSearchForm = $('#header-search-form');
var headerSearchResults = $('#header-search-result');
var resultClicked = false;

headerSearchForm.find('input').on('input', function () {
    var query = this.value;

    if(query.length >= 2){
        headerSearchForm.submit();
    } else {
        headerSearchResults.html('');
    }
    })
    .on('blur',function () {
        setTimeout(function () {
            headerSearchResults.html('');
        }, 1000);
    });
headerSearchForm.on('submit',function (event) {
    event.preventDefault();

    $.get(headerSearchForm.attr('action'), headerSearchForm.serialize(), function (data) {
        headerSearchResults.html(data);
    })

});

$('#attributeForm').on('change', function () {
    $('#attributeForm').submit();
});
