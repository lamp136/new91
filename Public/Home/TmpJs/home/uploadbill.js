$('.cha_save').click(function () {
    var error = false;
    var bill = $('#myform input[name="bill[]"]').val();
    if (bill == '') {
        $('#billError').show();
        error = true;
    }
    if (error) {
        return false;
    }

});