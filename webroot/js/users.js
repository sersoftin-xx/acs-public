/**
 * Created by Sergo on 17.12.2015.
 */

$('#search-form-user-name').selectpicker();
$('#search-form-user-contact').selectpicker();

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

function showEditUserDialog(user_id) {
    if (isFinite(user_id)) {
        $.get(location.protocol + '//' + window.location.hostname + '/users/get_info/' + user_id + '.json').success(function (data, textStatus, jqXHR) {
            var user = data['user'];
            $('#edit-user-caption').text(user['name'] + ' (#' + user['id'] + ')');
            $('#edit-user-form').attr('action', $('#edit-user-form-action').val() + '/' + user['id']);
            $('#edit-user-name-input').val(user['name']);
            $('#edit-user-contact-input').val(user['contact']);
            $('#edit-user-note-textarea').val(user['note']);
            $('#edit-user').modal('show');
        });
    }
    else {
        console.log('user_id is not a number!');
    }
}