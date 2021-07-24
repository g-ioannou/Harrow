
$(document).ready(function () {
    $('#check_re').click(function () {
        //var password_re = $("#password_re").val();
        if ($('#password_re').attr('type') == 'text') {
            $('#password_re').attr('type', 'password');
        }
        else {
            $('#password_re').attr('type', 'text');
        }
    });
});
