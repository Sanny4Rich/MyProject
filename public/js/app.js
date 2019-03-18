var addToCartButtons, cartInHeader, removeFromCartButtons, cartItems, setCount;

cartInHeader = $('#cart-in-header');
addToCartButtons = $('.js-add-to-cart');
removeFromCartButtons = $('.js-remove-item');
cartItems = $('#cartItems');

addToCartButtons.on('click', function(event) {
    event.preventDefault();
    mask();
    console.log('Button pressed.');

    $.get(event.target.href, function (data) {
        cartInHeader.html(data);
        unmask();
    });

});


function mask() {
    $('body').append('<div class="lmask"><div>')
}

function unmask() {
    $('.lmask').remove();
}

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

$('body').on('input','.js-item-count', function (event) {
    var target = $(event.currentTarget);

    $.post(target.data('href'), {'count': target.val()}, function (data) {
        cartItems.html(data);
        cartInHeader.load(cartInHeader.data('refresh-url'));

    })
});