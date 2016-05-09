/**
 * Created by Sergo on 17.12.2015.
 */
$('#edit-user-group-id-input').selectpicker();
$('#add-user-group-id-input').selectpicker();
$("#search-form-query-input").keyup(function () {
    var filter = $(this).val();
    $("tbody tr").each(function () {
        var table_row = $(this);
        if ((table_row.find('td').eq(1).html().search(new RegExp(filter, "i")) < 0)
            && (table_row.find('td').eq(2).html().search(new RegExp(filter, "i")) < 0)) {
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
            $('#edit-user-caption').text(user['name'] + ' (' + user['login'] + ')');
            $('#edit-user-form').attr('action', $('#edit-user-form-action').val() + '/' + user['id']);
            $('#edit-user-name-input').val(user['name']);
            $('#edit-user-login-input').val(user['login']);
            var group_selector = $('#edit-user-group-id-input');
            group_selector.val(user['group_id']);
            group_selector.selectpicker('refresh');
            $('#edit-user').modal('show');
        });
    }
    else {
        console.log('user_id is not a number!');
    }
}

function showResetPasswordDialog(user_id) {
    if (isFinite(user_id)) {
        $.get(location.protocol + '//' + window.location.hostname + '/users/get_info/' + user_id + '.json').success(function (data, textStatus, jqXHR) {
            var user = data['user'];
            $('#reset-password-user-caption').text(user['name'] + ' (' + user['login'] + ')');
            $('#reset-password-user-form').attr('action', $('#reset-password-user-form-action').val() + '/' + user['id']);
            $('#reset-password-user').modal('show');
        });

    } else {
        console.log('user_id is not a number!');
    }
}