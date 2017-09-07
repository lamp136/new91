  //获取验证码
$(function(){
    /*仿刷新：检测是否存在cookie*/
    if($.cookie("captcha")){
        var count = $.cookie("captcha");
        var btn = $('#getting');
        btn.val(count+'秒后可重新获取').attr('disabled',true).css('cursor','not-allowed');
        var resend = setInterval(function(){
            count--;
            if (count > 0){
                btn.val(count+'秒后可重新获取').attr('disabled',true).css('cursor','not-allowed');
                $.cookie("captcha", count, {path: '/', expires: (1/86400)*count});
            }else {
                clearInterval(resend);
                btn.val("获取验证码").removeClass('disabled').removeAttr('disabled style');
            }
        }, 1000);
    }
    /*点击改变按钮状态，已经简略掉ajax发送短信验证的代码*/

    $('#getting').click(function(){
        var btn = $(this);
        var count = 60;
        var mobile = $('#appointForm input[name="mobile"]').val();
        var myreg = /^(1[3|4|5|7|8]\d{9})$/; 
        if(mobile==''){
            $('#appointForm input[name="mobile"]').addClass('subs_hint');
            $('#mobileError').show();
            return false;
        }else if(!myreg.test(mobile)){
            $(this).addClass('subs_hint');
            $('#mobileError').html('<i></i>请输入正确的手机号');
            $('#mobileError').show();
            return false;
        }
        $.ajax({
            url: "/cemetery/sendmessage.html",
            type: 'POST',
            data: "mobile="+mobile,
            success: function (d) {
                var result = eval("(" + d + ")");
                if (result.flag == 1) {
                    var resend = setInterval(function(){
                        count--;
                        if (count > 0){
                            btn.val(count+"秒后可重新获取");
                            $.cookie("captcha", count, {path: '/', expires: (1/86400)*count});
                        }else {
                            clearInterval(resend);
                            btn.val("获取验证码").removeAttr('disabled style');
                        }
                    }, 1000);
                    btn.attr('disabled',true).css('cursor','not-allowed');
                } else {
                    //提示框
                    $('#content').empty().append(result.msg);
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
    
    //表单提交
    $('.subs_btn').click(function(){
        var error = false;
        var buyer = $('#appointForm input[name="buyer"]').val();
        var mobile = $('#appointForm input[name="mobile"]').val();
        var msgcode = $('#appointForm input[name="msgcode"]').val();
        var appoint_time = $('#appointForm input[name="appoint_time"]').val();
        var sesssionMobile = sm;  //session中的手机号
        if(buyer==''){
            error = true;
            $('#appointForm input[name="buyer"]').addClass('subs_hint');
            $('#buyerError').show();
        }
        if(mobile==''){
            error = true;
            $('#appointForm input[name="mobile"]').addClass('subs_hint');
            $('#mobileError').show();
        }
        if((sesssionMobile!='' && sesssionMobile!=mobile) || sesssionMobile==''){ 
            if(msgcode==''){
                error = true;
                $('#appointForm input[name="msgcode"]').addClass('subs_hint');
                $('#msgcodeError').show();
            }
        }
        //if(appoint_time==''){
          //  error = true;
          //  $('#appointForm input[name="appoint_time"]').addClass('subs_hint');
          //  $('#appointtimeError').show();
        //}
        if(error){
            return false;
        }
        var store_name = $('.appoint_cemetery_name').attr('data-value');
        //var r=confirm("您预约的陵园为:"+store_name);
        //if(r==true){
            $.ajax({
                url: "/cemetery/submitappoint.html",
                type: 'POST',
                data: $('#appointForm').serialize(),
                success: function (d) {
                    var result = eval("(" + d + ")");
                    if (result.flag == 10) {
                         //提示框
                        $('#content').empty().append(result.msg);
                        $(".tooltip_pers").css({"display":"block"});
                        $(".tooltip_box").css({"display":"block"});
                        setTimeout(function(){window.location.href='/myorder';},2000);
                    }else if(result.flag == 2){
                        $('#msgcodeError').html('<i></i>'+result.msg);
                        $('#msgcodeError').show();
                    }else {
                        $('#buyerError').html('<i></i>'+result.msg);
                        $('#buyerError').show();
                    }
                }
            });
       // }
        return false;   //阻止表单默认提交
    });
    
    $('#appointForm input[name="buyer"]').blur(function(){
        var buyer = $(this).val();
        if(buyer==''){
            $(this).addClass('subs_hint');
            $('#buyerError').show();
        }else{
            $(this).removeClass('subs_hint');
            $('#buyerError').hide();
        }
    });
    
    $('#appointForm input[name="mobile"]').blur(function(){
        var mobile = $(this).val();
        var myreg = /^(1[3|4|5|7|8]\d{9})$/; 
        var btn = $('#getting');
        var sesssionMobile = '{$Think.session.member_mobile}';
        
        if(mobile==''){
            $(this).addClass('subs_hint');
            $('#mobileError').show();
        }else if(!myreg.test(mobile)){
            $(this).addClass('subs_hint');
            $('#mobileError').html('<i></i>请输入正确的手机号');
            $('#mobileError').show();
        }else{
            if((sesssionMobile!='' && sesssionMobile!=mobile) || sesssionMobile==''){
                $('.getcode_btn').show();
                $('.msgcode').show();
            }else{
                $('.getcode_btn').hide();
                $('.msgcode').hide();
            }
            $(this).removeClass('subs_hint');
            $('#mobileError').hide();
        }
    });
    
    $('#appointForm input[name="msgcode"]').blur(function(){
        var msgcode = $(this).val();
        if(msgcode==''){
            $(this).addClass('subs_hint');
            $('#msgcodeError').show();
        }else{
            $(this).removeClass('subs_hint');
            $('#msgcodeError').hide();
        }
    });
    
    $('#appointForm input[name="appoint_time"]').blur(function(){
        var appoint_time = $(this).val();
        if(appoint_time==''){
            $(this).addClass('subs_hint');
            $('#appointtimeError').show();
        }else{
            $(this).removeClass('subs_hint');
            $('#appointtimeError').hide();
        }
    });
    
    $('#appointForm input[name="appoint_time"]').focus(function(){
        var appoint_time = $(this).val();
        if(appoint_time!=''){
            $(this).removeClass('subs_hint');
            $('#appointtimeError').hide();
        }
    });
    
     //关闭提示框
    $(".tooltip_cloce, .ack_btn").click(function(event){
        $(".tooltip_pers").css({"display":"none"});
        $(".tooltip_box").css({"display":"none"});
    });
});
