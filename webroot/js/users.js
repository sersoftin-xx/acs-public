/**
 * Created by Sergo on 17.12.2015.
 */
function showEditUserDialog(user_id) {
    if (isFinite(user_id)) {
        $.get(location.protocol + '//' + window.location.hostname + '/users/get_info/' + user_id + '.json').success(function (data, textStatus, jqXHR) {
            var user = data['user'];
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