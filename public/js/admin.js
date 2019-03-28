$(function() {
    $('form').on('input', '.js-recalc-cost', function (event) {
        var row = $(this).closest('tr');
        var price = row.find('.js-price').val();
        var count = row.find('.js-count').val();

        row.find('.js-summaryPrice').val(Math.round(price * count * 100)/100);
    });
});