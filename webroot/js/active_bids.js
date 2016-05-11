/**
 * Created by Сергей on 26.12.2015.
 */

var defaultDateFormat = 'DD.MM.YYYY HH:mm';

$('#edit-active-bid-product-id-input').selectpicker();
$('#search-form-product-id').selectpicker();
$('#search-form-user-id').selectpicker();
$('#search-form-pc-id').selectpicker();
$('#edit-active-bid-expiration-date-input-group').datetimepicker({
    defaultDate: moment().add(1, 'days'),
    format: defaultDateFormat,
    ignoreReadonly: true,
    focusOnShow: false,
    showClose: true,
    minDate: moment()
});

$("#search-form-query-input").keyup(function () {
    var filter = $(this).val();
    $("tbody tr").each(function () {
        var table_row = $(this);
        if ((table_row.find('td').eq(0).html().search(new RegExp(filter, "i")) < 0)
            && (table_row.find('td').eq(1).html().search(new RegExp(filter, "i")) < 0)
            && (table_row.find('td').eq(2).html().search(new RegExp(filter, "i")) < 0)
            && (table_row.find('td').eq(3).html().search(new RegExp(filter, "i")) < 0)) {
            table_row.fadeOut();
        } else {
            table_row.show();
        }
    });
});

function showEditActiveBidDialog(active_bid_id) {
    if (isFinite(active_bid_id)) {
        $.get(location.protocol + '//' + window.location.hostname + '/bids/get_info/' + active_bid_id + '.json').success(function (data) {
            var bid = data['bid'];
            $('#edit-active-bid-caption').text('#' + bid['id']);
            $('#edit-active-bid-form').attr('action', $('#edit-active-bid-form-action').val() + '/' + bid['id']);
            var product_selector = $('#edit-active-bid-product-id-input');
            product_selector.val(bid['product_id']);
            product_selector.selectpicker('refresh');
            $('#edit-active-bid-expiration-date-input').val(moment(bid['expiration_date']).format(defaultDateFormat));
            $('#edit-active-bid').modal('show');
        });
    }
    else {
        console.log('active_bid_id is not a number!');
    }
}

function setMaxDate() {
    $('#edit-active-bid-expiration-date-input').val(moment.unix(2147483647).format(defaultDateFormat));
}