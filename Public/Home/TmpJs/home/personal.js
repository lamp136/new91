$('#personalForm input[name="name"]').blur(function () {
    var name = $(this).val();
    if (name == '') {
        $('#nameError').show();
    } else {
        $('#nameError').hide();
    }
});
//判断银行账号是否修改，修改了银行卡里面不能出现*号
var bank_account_error = false;
$('#personalForm input[name="bank_account"]').change(function () {
    var bank_account = $(this).val();
    var s = bank_account.indexOf('*');
    if (s >= 0) {
        $('#bank_accountError').show();
        bank_account_error = true;
    } else {
        $('#bank_accountError').hide();
        bank_account_error = false;
    }
});

//表单提交
$('.pers_save').click(function () {
    var name = $('#personalForm input[name="name"]').val();
    var bank_account = $('#personalForm input[name="bank_account"]').val();
    if (name == '') {
        $('#nameError').show();
        return false;
    }
    if (bank_account_error) {
        return false;
    }
    $.ajax({
        url: "user_center/savememberinfo.html",
        type: 'POST',
        data: $('#personalForm').serialize(),
        success: function (d) {
            var result = eval("(" + d + ")");
            if (result.flag == 1) {
                $('#content').empty().append(result.msg);
                $(".tooltip_pers").css({"display":"block"});
                $(".tooltip_box").css({"display":"block"});
                setTimeout(function(){window.location.reload();},2000);
            } else if (result.flag == 0) {
                $('#content').append(result.msg);
                $(".tooltip_pers").css({"display":"block"});
                $(".tooltip_box").css({"display":"block"});
            }
        }
    });
});
//关闭提示框
$(".tooltip_cloce, .ack_btn").click(function(event){
    $(".tooltip_pers").css({"display":"none"});
    $(".tooltip_box").css({"display":"none"});
});