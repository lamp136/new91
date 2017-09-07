// 验证码点击更换
$('.codeimg').click(function () {
    changCode();
});
function changCode(){
    var verifyimg = $('.codeimg').attr("src");
    if (verifyimg.indexOf('?') > 0) {
        $('.codeimg').attr("src", verifyimg + '&random=' + Math.random());
    } else {
        $('.codeimg').attr("src", verifyimg.replace(/\?.*$/, '') + '?' + Math.random());
    }
}

//原始密码
$('#myform input[name="oldpassword"]').blur(function () {
    var oldpassword = $(this).val();
    if (oldpassword == '') {
        $(this).addClass('pers_validate_tex');
        $('#oldpasswordError').show();
    } else {
        $(this).removeClass('pers_validate_tex');
        $('#oldpasswordError').hide();
    }
});
//新密码
$('#myform input[name="newpassword"]').blur(function () {
    var newpassword = $(this).val();
    if (newpassword == '') {
        $(this).addClass('pers_validate_tex');
        $('#newpasswordError').show();
    } else {
        $(this).removeClass('pers_validate_tex');
        $('#newpasswordError').hide();
    }
});
//确认密码
$('#myform input[name="newpassword2"]').blur(function () {
    var newpassword2 = $(this).val();
    var newpassword = $('#myform input[name="newpassword"]').val();
    if (newpassword2 == '') {
        $(this).addClass('pers_validate_tex');
        $('#newpassword2Error').show();
    } else if (newpassword != newpassword2) {
        $(this).addClass('pers_validate_tex');
        $('#newpassword2Error').html('<i></i>两次密码不一致');
        $('#newpassword2Error').show();
    } else {
        $(this).removeClass('pers_validate_tex');
        $('#newpassword2Error').hide();
    }
});
//验证码
$('#myform input[name="code"]').blur(function () {
    var code = $(this).val();
    if (code == '') {
        $(this).addClass('pers_validate_tex');
        $('#codeError').show();
    } else {
        $(this).removeClass('pers_validate_tex');
        $('#codeError').hide();
    }
});
//点击将报错的class取消
$('#myform input').click(function () {
    $(this).removeClass('pers_validate_tex');
});

//提交
$('.cha_save').click(function () {
    var error = false;
    var oldpassword = $('#myform input[name="oldpassword"]').val();
    var newpassword = $('#myform input[name="newpassword"]').val();
    var newpassword2 = $('#myform input[name="newpassword2"]').val();
    var code = $('#myform input[name="code"]').val();
    if (oldpassword == '') {
        $('#myform input[name="oldpassword"]').addClass('pers_validate_tex');
        $('#oldpasswordError').show();
        error = true;
    }
    if (newpassword == '') {
        $('#myform input[name="newpassword"]').addClass('pers_validate_tex');
        $('#newpasswordError').show();
        error = true;
    }
    if (newpassword2 == '') {
        $('#myform input[name="newpassword2"]').addClass('pers_validate_tex');
        $('#newpassword2Error').show();
        error = true;
    } else if (newpassword != newpassword2) {
        $('#myform input[name="newpassword2"]').addClass('pers_validate_tex');
        $('#newpassword2Error').html('<i></i>两次密码不一致');
        $('#newpassword2Error').show();
        error = true;
    }
    if (code == '') {
        $('#myform input[name="code"]').addClass('pers_validate_tex');
        $('#codeError').show();
        error = true;
    }
    if (error) {
        return false;
    }
    $.ajax({
        url: "/UserCenter/savepassword",
        type: 'POST',
        data: $('#myform').serialize(),
        success: function (d) {
            var result = eval("(" + d + ")");
            //更新验证码
            changCode();
            if (result.flag == 1) {
                 //提示框
                $('#content').empty().append(result.msg);
                $(".tooltip_pers").css({"display":"block"});
                $(".tooltip_box").css({"display":"block"});
                setTimeout(function(){window.location.herf = '/login?url=changepassword';},2000);
            } else if (result.flag == 2) {
                $('#codeError').html('<i></i>' + result.msg);
                $('#codeError').show();
            } else if (result.flag == 3) {
                $('#oldpasswordError').html('<i></i>' + result.msg);
                $('#oldpasswordError').show();
            } else if (result.flag == 10) {
                 //提示框
                $('#content').empty().append(result.msg);
                $(".tooltip_pers").css({"display":"block"});
                $(".tooltip_box").css({"display":"block"});
                setTimeout(function(){window.location.href = '/personal';},2000);
            } else {
                $('#oldpasswordError').html('<i></i>' + result.msg);
                $('#oldpasswordError').show();
            }
        }
    });
});

//关闭提示框
$(".tooltip_cloce, .ack_btn").click(function(event){
    $(".tooltip_pers").css({"display":"none"});
    $(".tooltip_box").css({"display":"none"});
});