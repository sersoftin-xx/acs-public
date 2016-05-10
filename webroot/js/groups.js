/**
 * Created by Sergo on 09.05.2016.
 */

$('#add-group-group-permissions-input').selectpicker({
    actionsBox: true
});

$('#edit-group-group-permissions-input').selectpicker({
    actionsBox: true
});

function showEditUserDialog(group_id) {
    if (isFinite(group_id)) {
        $.get(location.protocol + '//' + window.location.hostname + '/groups/get_info/' + group_id + '.json').success(function (data, textStatus, jqXHR) {
            var group = data['group'];
            $('#edit-group-caption').text(group['name']);
            $('#edit-group-form').attr('action', $('#edit-group-form-action').val() + '/' + group['id']);
            $('#edit-group-name-input').val(group['name']);
            var permissions_selector = $('#edit-group-group-permissions-input').selectpicker('val', group['permissions']);
            permissions_selector.selectpicker('refresh');
            $('#edit-group').modal('show');
        });
    }
    else {
        console.log('group_id is not a number!');
    }
}