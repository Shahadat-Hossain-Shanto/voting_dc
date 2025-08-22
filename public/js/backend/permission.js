
$("#checkPermissionAll").click(function () {
    if ($(this).is(":checked")) {
        // check all the checkbox
        $("input[type=checkbox]").prop("checked", true);
    } else {
        // un check all the checkbox
        $("input[type=checkbox]").prop("checked", false);
    }
});

function checkCheckboxes(checkbox_id, div_id) {

    $(function () {
        if ($('input#' + checkbox_id).is(":checked")) {
            $('#' + div_id + ' input:checkbox').prop("checked", true);
        }
        else {

            $('#' + div_id + ' input:checkbox').prop("checked", false);

        }
    });

}

