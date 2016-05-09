/**
 * Created by Sergo on 17.12.2015.
 */

$("#search-form-query-input").keyup(function () {
    var filter = $(this).val();
    $("tbody tr").each(function () {
        var table_row = $(this);
        if ((table_row.find('td').eq(1).html().search(new RegExp(filter, "i")) < 0)
            && (table_row.find('td').eq(4).html().search(new RegExp(filter, "i")) < 0)) {
            table_row.fadeOut();
        } else {
            table_row.show();
        }
    });
});

function showEditClientDialog(client_id) {
    if (isFinite(client_id)) {
        $.get(location.protocol + '//' + window.location.hostname + '/clients/get_info/' + client_id + '.json').success(function (data, textStatus, jqXHR) {
            var client = data['client'];
            $('#edit-client-caption').text(client['name'] + ' (#' + client['id'] + ')');
            $('#edit-client-form').attr('action', $('#edit-client-form-action').val() + '/' + client['id']);
            $('#edit-client-name-input').val(client['name']);
            $('#edit-client-contact-input').val(client['contact']);
            $('#edit-client-note-textarea').val(client['note']);
            $('#edit-client').modal('show');
        });
    }
    else {
        console.log('client_id is not a number!');
    }
}