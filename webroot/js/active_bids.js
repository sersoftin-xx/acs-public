/**
 * Created by Сергей on 26.12.2015.
 */

$('#edit-active-bid-product-id-input').selectpicker();
$('#search-form-product-id').selectpicker();
$('#search-form-user-id').selectpicker();
$('#search-form-pc-id').selectpicker();
$('#edit-active-bid-expiration-date-input-group').datetimepicker({
    defaultDate: moment().add(1, 'days'),
    format: 'DD.MM.YYYY HH:mm',
    ignoreReadonly: true,
    focusOnShow: false,
    showClose: true,
    minDate: moment()
});

$('#search-form').keydown(function (event) {
    if (event.keyCode == 13) {
        searchBids();
    }
});

function searchBids() {
    var bid_id = $('#search-form-bid-id').val();
    if (+bid_id > 0) {
        scrollToBid(bid_id);
    }
    else {
        search_form.submit();
    }
}

function scrollToBid(bid_id) {
    var bid = $('#bid_' + bid_id);
    $('body').animate({
        scrollTop: bid.offset().top
    }, 100);
}

function showEditActiveBidDialog(active_bid_id) {
    if (isFinite(active_bid_id)) {
        $.get(location.protocol + '//' + window.location.hostname + '/bids/get_info/' + active_bid_id + '.json').success(function (data) {
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
        console.log('active_bid_id is not a number!');
    }
}