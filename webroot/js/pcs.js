/**
 * Created by Sergo on 17.12.2015.
 */
$('#edit-pc-user-id-input').selectpicker();
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

function showEditPcDialog(pc_id) {
    if (isFinite(pc_id)) {
        $.get(location.protocol + '//' + window.location.hostname + '/pcs/get_info/' + pc_id + '.json').success(function (data, textStatus, jqXHR) {
            var pc = data['pc'];
            $('#edit-pc-form').attr('action', $('#edit-pc-form-action').val() + '/' + pc['id']);
            var user_selector = $('#edit-pc-user-id-input');
            user_selector.val(pc['user_id']);
            user_selector.selectpicker('refresh');
            $('#edit-pc-name-input').val(pc['name']);
            $('#edit-pc-comment-textarea').val(pc['comment']);
            $('#edit-pc').modal('show');
        });
    }
    else {
        console.log('pc_id is not a number!');
    }
}