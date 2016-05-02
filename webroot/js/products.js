/**
 * Created by Sergo on 13.12.2015.
 */

$('input[type=file]').bootstrapFileInput(); // включаем bootstrap file-browser

function showUploadNewProductVersionDialog(product_id) { // открывает окно загрузки нового продукта
    if (isFinite(product_id)) {
        $.get(location.protocol + '//' + window.location.hostname + '/products/get_info/' + product_id + '.json').success(function (data, textStatus, jqXHR) {
            var product = data['product'];
            $('#update-product-form').attr('action', $('#update-product-form-action').val() + '/' + product['id']);
            $('#update-product').modal('show');
        });
    }
    else {
        console.log('product_id is not a number!');
    }
}

function showEditProductDialog(product_id) {
    if (isFinite(product_id)) {
        $.get(location.protocol + '//' + window.location.hostname + '/products/get_info/' + product_id + '.json').success(function (data, textStatus, jqXHR) {
            var product = data['product'];
            $('#edit-product-caption').text(product['name'] + ' (#' + product['id'] + ')');
            $('#edit-product-form').attr('action', $('#edit-product-form-action').val() + '/' + product['id']);
            $('#edit-product-name-input').val(product['name']);
            $('#edit-product-hidden-checkbox').prop('checked', product['hidden']);
            $('#edit-product-download-name-input').val(product['download_name']);
            $('#edit-product-description-textarea').val(product['description']);
            $('#edit-product').modal('show');
        });
    }
    else {
        console.log('product_id is not a number!');
    }
}
new Clipboard('.download-link-generator');