/**
 * Created by Сергей on 26.12.2015.
 */

function cb(start, end) {
    $('#search-form-activation-date').find('span').html(start.format('L') + ' - ' + end.format('L'));
    $('#search-form-activation-date-from').val(start.format());
    $('#search-form-activation-date-to').val(end.format());
}

cb(moment().startOf('day'), moment().endOf('day'));

$('#search-form-activation-date').daterangepicker({
    autoApply:true,
    opens: 'center',
    ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(7, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment().add(1, 'days')],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);

$('#edit-active-bid-product-id-input').selectpicker();
$('#search-form-product_id').selectpicker();
$('#search-form-user-id').selectpicker();
$('#search-form-pc-id').selectpicker();
$('#edit-active-bid-expiration-date-input-group').datetimepicker({
    defaultDate: moment().add(1, 'days'),
    format: 'DD.MM.YYYY HH:mm'
});

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