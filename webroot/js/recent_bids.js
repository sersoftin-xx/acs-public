/**
 * Created by Sergo on 13.12.2015.
 */


$('#accept-bid-user-id-input').selectpicker();
$('#accept-bid-expiration-date-input-group').datetimepicker({
    format: 'DD.MM.YYYY HH:mm',
    ignoreReadonly: true,
    focusOnShow: false,
    showClose: true,
    defaultDate: moment().add(2, 'hours')
});

$("#search-form-query-input").keyup(function () {
    var filter = $(this).val();
    $("tbody tr").each(function () {
        var table_row = $(this);
        if ((table_row.find('td').eq(0).html().search(new RegExp(filter, "i")) < 0)
            && (table_row.find('td').eq(1).html().search(new RegExp(filter, "i")) < 0)
            && (table_row.find('td').eq(2).html().search(new RegExp(filter, "i")) < 0)) {
            table_row.fadeOut();
        } else {
            table_row.show();
        }
    });
});

function showAcceptBidDialog(bid_id) {
    if (isFinite(bid_id)) {
        $('#accept-bid-caption').text('#' + bid_id);
        $('#accept-bid-form').attr('action', $('#accept-bid-form-action').val() + '/' + bid_id);
        $('#accept-bid').modal('show');
    }
    else {
        console.log('bid_id is not a number!');
    }
}

function setMaxDate() {
    $('#accept-bid-expiration-date-input').val(moment.unix(2147483647).format('DD.MM.YYYY hh:mm'));
}