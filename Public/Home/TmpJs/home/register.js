var checkuser = false;      //手机号是否存在，默认不存在
/*仿刷新：检测是否存在cookie*/
if ($.cookie("captcha")) {
    var count = $.cookie("captcha");
    var btn = $('#getting');
    btn.val(count + '秒后可重新获取').attr('disabled', true).css('cursor', 'not-allowed');
    var resend = setInterval(function () {
        count--;
        if (count > 0) {
            btn.val(count + '秒后可重新获取').attr('disabled', true).css('cursor', 'not-allowed');
            $.cookie("captcha", count, {path: '/', expires: (1 / 86400) * count});
        } else {
            clearInterval(resend);
            btn.val("获取验证码").removeClass('disabled').removeAttr('disabled style');
        }
    }, 1000);
}
/*点击改变按钮状态，已经简略掉ajax发送短信验证的代码*/

$('#getting').click(function () {
    var btn = $(this);
    var count = 60;
    var mobile = $('#registerForm input[name="mobile"]').val();
    var myreg = /^(1[3|4|5|7|8]\d{9})$/;
    if (mobile == '') {
        $('#registerForm input[name="mobile"]').addClass('reg_validate_tex');
        $('#mobileError').show();
        return false;
    } else if (!myreg.test(mobile)) {
        $(this).addClass('subs_hint');
        $('#mobileError').html('<i></i>请输入正确的手机号');
        $('#mobileError').show();
        return false;
    }
    var mobileExists = false;
    $.ajax({
        url: "/member/checkusermobile.html",
        type: 'POST',
        data: 'mobile=' + mobile,
        async: false,
        success: function (d) {
            var result = eval("(" + d + ")");
            if (result.flag == 1) {
                $('#mobileError').html('<i></i>' + result.msg);
                $('#mobileError').show();
                mobileExists = true;
            }
        }
    });
    if (mobileExists) {
        return false;
    }

    $.ajax({
        url: "/member/sendmessage",
        type: 'POST',
        data: "mobile=" + mobile,
        success: function (d) {
            var result = eval("(" + d + ")");
            if (result.flag == 1) {
                var resend = setInterval(function () {
                    count--;
                    if (count > 0) {
                        btn.val(count + "秒后可重新获取");
                        $.cookie("captcha", count, {path: '/', expires: (1 / 86400) * count});
                    } else {
                        clearInterval(resend);
                        btn.val("获取验证码").removeAttr('disabled style');
                    }
                }, 1000);
                btn.attr('disabled', true).css('cursor', 'not-allowed');
            } else {
                //提示框
                $('#content').empty().append(result.msg);
                $(".tooltip_pers").css({"display":"block"});
                $(".tooltip_box").css({"display":"block"});
            }
        }
    });
});

//注册相关表单的验证
//姓名
$('#registerForm input[name="name"]').blur(function () {
    var name = $(this).val();
    if (name == '') {
        $('#nameError').html('<i></i>请输入您的姓名');
        $(this).addClass('reg_validate_tex');
        $('#nameError').show();
    } else if (name.length < 2 || name.length > 10) {
        $('#nameError').html('<i></i>姓名为2-10个字符');
        $(this).addClass('reg_validate_tex');
        $('#nameError').show();
    } else {
        $(this).removeClass('reg_validate_tex');
        $('#nameError').hide();
    }
});
$('#registerForm input[name="name"]').focus(function () {
    $(this).removeClass('reg_validate_tex');
});
//手机号
$('#registerForm input[name="mobile"]').blur(function () {
    var mobile = $(this).val();
    var myreg = /^(1[3|4|5|7|8]\d{9})$/;
    if (mobile == '') {
        $(this).addClass('reg_validate_tex');
        $('#mobileError').show();
        return false;
    } else if (!myreg.test(mobile)) {
        $(this).addClass('reg_validate_tex');
        $('#mobileError').html('<i></i>请输入正确的手机号');
        $('#mobileError').show();
        return false;
    } else {
        $(this).removeClass('reg_validate_tex');
        $('#mobileError').hide();
    }
    $.ajax({
        url: "/member/checkusermobile.html",
        type: 'POST',
        data: 'mobile=' + mobile,
        success: function (d) {
            var result = eval("(" + d + ")");
            if (result.flag == 1) {
                checkuser = true;
                $('#mobileError').html('<i></i>' + result.msg);
                $('#mobileError').show();
            }
        }
    });
});
$('#registerForm input[name="mobile"]').focus(function () {
    $(this).removeClass('reg_validate_tex');
});
//动态验证码
$('#registerForm input[name="msgcode"]').blur(function () {
    var msgcode = $(this).val();
    if (msgcode == '') {
        $(this).addClass('reg_validate_tex');
        $('#msgcodeError').show();
    } else {
        $(this).removeClass('reg_validate_tex');
        $('#msgcodeError').hide();
    }
});
$('#registerForm input[name="msgcode"]').focus(function () {
    $(this).removeClass('reg_validate_tex');
});

//密码
$('#registerForm input[name="password"]').blur(function () {
    var password = $(this).val();
    if (!/^[a-zA-Z0-9]{6,16}$/.test(password) || password == '') {
        $(this).addClass('reg_validate_tex');
        $('#passwordError').show();
    } else {
        $(this).removeClass('reg_validate_tex');
        $('#passwordError').hide();
    }
});
$('#registerForm input[name="password"]').focus(function () {
    $(this).removeClass('reg_validate_tex');
});
//确认密码
$('#registerForm input[name="repassword"]').blur(function () {
    var repassword = $(this).val();
    var password = $('#registerForm input[name="password"]').val();
    if (repassword == '') {
        $(this).addClass('reg_validate_tex');
        $('#repasswordError').show();
    } else if (password != repassword) {
        $(this).addClass('reg_validate_tex');
        $('#repasswordError').html('<i></i>两次密码不一致');
        $('#repasswordError').show();
    } else {
        $(this).removeClass('reg_validate_tex');
        $('#repasswordError').hide();
    }
});
$('#registerForm input[name="repassword"]').focus(function () {
    $(this).removeClass('reg_validate_tex');
});
//提交表单
$('.register_btn').click(function () {
    if (checkuser) {
        return false;
    }
    var error = false;
    var name = $('#registerForm input[name="name"]').val();
    var mobile = $('#registerForm input[name="mobile"]').val();
    var msgcode = $('#registerForm input[name="msgcode"]').val();
    var password = $('#registerForm input[name="password"]').val();
    var repassword = $('#registerForm input[name="repassword"]').val();
    var protocol = $('#registerForm input[name="protocol"]').is(':checked');
    if (name == '') {
        $('#registerForm input[name="name"]').addClass('reg_validate_tex');
        $('#nameError').show();
        error = true;
    }
    var myreg = /^(1[3|4|5|7|8]\d{9})$/;
    if (mobile == '') {
        $('#registerForm input[name="mobile"]').addClass('reg_validate_tex');
        $('#mobileError').show();
        error = true;
    } else if (!myreg.test(mobile)) {
        $('#registerForm input[name="mobile"]').addClass('reg_validate_tex');
        $('#mobileError').html('<i></i>请输入正确的手机号');
        $('#mobileError').show();
        error = true;
    }
    if (msgcode == '') {
        $('#registerForm input[name="msgcode"]').addClass('reg_validate_tex');
        $('#msgcodeError').show();
        error = true;
    }
    if (!/^[a-zA-Z0-9]{6,16}$/.test(password) || password == '') {
        $('#registerForm input[name="password"]').addClass('reg_validate_tex');
        $('#passwordError').show();
        error = true;
    }
    if (repassword == '') {
        $('#registerForm input[name="repassword"]').addClass('reg_validate_tex');
        $('#repasswordError').show();
        error = true;
    } else if (password != repassword) {
        $('#registerForm input[name="repassword"]').addClass('reg_validate_tex');
        $('#repasswordError').html('<i></i>两次密码不一致');
        $('#repasswordError').show();
        error = true;
    }
    if (!protocol) {
        $('#protocolError').show();
        error = true;
    }
    if (error) {
        return false;
    }
    $.ajax({
        url: "/member/submitregister.html",
        type: 'POST',
        data: $('#registerForm').serialize(),
        success: function (d) {
            var result = eval("(" + d + ")");
            if (result.flag == 1) {
                $('#mobileError').html('<i></i>' + result.msg);
                $('#mobileError').show();
            } else if (result.flag == 2) {
                $('#codeError').html('<i></i>' + result.msg);
                $('#codeError').show();
            } else if (result.flag == 3) {
                $('#nameError').html('<i></i>' + result.msg);
                $('#nameError').show();
            } else if (result.flag == 10) {
                window.location.href = '/';
            } else {
                 //提示框
                $('#content').empty().append('操作失败');
                $(".tooltip_pers").css({"display":"block"});
                $(".tooltip_box").css({"display":"block"});
            }
        }
    });
    return false;
});
//点击我已阅读了搜墓网的《用户协议》—— 弹出协议内容 
$(".igree_click").click(function(event){
    $(".igree_box").css({"display":"block"});
    $(".igree_box_bg").css({"display":"block"});
});
$(".tooltip_cloce").click(function(event){
    $(".igree_box").css({"display":"none"});
    $(".igree_box_bg").css({"display":"none"});
});
$(".igree_btn_img").click(function(event){
    $(".igree_box").css({"display":"none"});
    $(".igree_box_bg").css({"display":"none"});
    $(".reg_check").attr('checked','checked');
});

//关闭提示框
$(".tooltip_cloce, .ack_btn").click(function(event){
    $(".tooltip_pers").css({"display":"none"});
    $(".tooltip_box").css({"display":"none"});
});