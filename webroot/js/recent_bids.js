/**
 * Created by Sergo on 13.12.2015.
 */


$('#accept-bid-user-id-input').selectpicker();
$('#accept-bid-expiration-date-input-group').datetimepicker({
    defaultDate: moment().add(1,'days'),
    format: 'DD.MM.YYYY HH:mm'
});
function showAcceptBidDialog(bid_id) {
    if (isFinite(bid_id)) {
        $('#accept-bid-form').attr('action', $('#accept-bid-form-action').val() + '/' + bid_id);
        $('#accept-bid').modal('show');
    }
    else {
        console.log('bid_id is not a number!');
    }
}

function setMaxDate()
{
    $('#accept-bid-expiration-date-input').val(moment.unix(2147483647).format('DD.MM.YYYY hh:mm'));
}