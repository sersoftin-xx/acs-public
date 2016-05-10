/**
 * Created by Sergo on 10.05.2016.
 */

$("#search-form-query-input").keyup(function () {
    var filter = $(this).val();
    $("tbody tr").each(function () {
        var table_row = $(this);
        if (table_row.find('td').eq(1).html().search(new RegExp(filter, "i")) < 0) {
            table_row.fadeOut();
        } else {
            table_row.show();
        }
    });
});