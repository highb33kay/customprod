jQuery(document).ready(function($) {
    $('.plus').on('click', function(e) {
        e.preventDefault();
        var productID = $(this).closest('.product-item').data('product-id');
        var quantity = 1; // Change this to customize the quantity added
        $(document.body).trigger('adding_to_cart', [$(this), productID, quantity]);
    });

    $('.minus').on('click', function(e) {
        e.preventDefault();
        var productID = $(this).closest('.product-item').data('product-id');
        var quantity = -1; // Change this to customize the quantity removed
        $(document.body).trigger('adding_to_cart', [$(this), productID, quantity]);
    });
});