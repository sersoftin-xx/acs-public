/**
 * Created by Сергей on 26.12.2015.
 */

$('#edit-active-bid-product-id-input').selectpicker();
$('#edit-active-bid-expiration-date-input-group').datetimepicker({
    defaultDate: moment().add(1, 'days'),
    format: 'DD.MM.YYYY HH:mm'
});

function showEditActiveBidDialog(active_bid_id) {
    if (isFinite(active_bid_id)) {
        $.get(location.protocol + '//' + window.location.hostname + '/bids/get_info/' + active_bid_id + '.json').success(function (data, textStatus, jqXHR) {
            var bid = data['bid'];
            $('#edit-active-bid-form').attr('action', $('#edit-active-bid-form-action').val() + '/' + bid['id']);
            var product_selector = $('#edit-active-bid-product-id-input');
            product_selector.val(bid['product_id']);
            product_selector.selectpicker('refresh');
            $('#edit-active-bid-expiration-date-input').val(bid['expiration_date']);
            $('#edit-active-bid').modal('show');
        });
    }
    else {
        console.log('active_bid_id_id is not a number!');
    }
}