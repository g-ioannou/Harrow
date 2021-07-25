

//show box for validate password
$(document).ready(function() {
    $('#password_reg').keyup(function() {
        
        var password_reg = $("#password_reg").val();
        
        //validate the length
        if ( password_reg.length < 8 ) {
            $('#length').removeClass('valid').addClass('invalid');
        } else {
            $('#length').removeClass('invalid').addClass('valid');
        }
        //validate letter
        if ( password_reg.match(/[A-z]/) ) {
            $('#letter').removeClass('invalid').addClass('valid');
        } else {
            $('#letter').removeClass('valid').addClass('invalid');
        }

        //validate capital letter
        if ( password_reg.match(/[A-Z]/) ) {
            $('#capital').removeClass('invalid').addClass('valid');
        } else {
            $('#capital').removeClass('valid').addClass('invalid');
        }

        //validate number
        if ( password_reg.match(/\d/) ) {
            $('#number').removeClass('invalid').addClass('valid');
        } else {
            $('#number').removeClass('valid').addClass('invalid');
        }

        //validate symbol
        if ( password_reg.match(/[!@#$%^&*]/) ) {
            $('#symbol').removeClass('invalid').addClass('valid');
        } else {
            $('#symbol').removeClass('valid').addClass('invalid');
        }


    }).focus(function() {
        $('#password_reg_info').show();
    }).blur(function() {
        $('#password_reg_info').hide();
    });

});