//陵园合作申请
$('.leag_joinbtn').click(function () {
    var cemetery_name = trimStr($('#cemetery_name').val());
    var cemetery_linkman = trimStr($('#cemetery_linkman').val());
    var cemetery_mobile = trimStr($('#cemetery_mobile').val());
    //正则匹配mobile和中文
    var pattern = /^1((3\d)|(47)|(5[0-35-9])|(7[01789])|(8\d))\d{8}$/;
    var pattern_name = /^[\u4e00-\u9fa5]{0,}$/;
    if (!(cemetery_name && cemetery_linkman)) {
        $('.leag_validate').empty();
        $('.leag_validate').append('<p>陵园名称或联系人不能为空！</p>');
    } else if (!pattern_name.test(cemetery_name)) {
        $('.leag_validate').empty();
        $('.leag_validate').append('<p>请输入中文陵园名称！</p>');
    } else if (!pattern_name.test(cemetery_linkman)) {
        $('.leag_validate').empty();
        $('.leag_validate').append('<p>请输入中文联系人！</p>');
    } else if (!pattern.test(cemetery_mobile)) {
        $('.leag_validate').empty();
        $('.leag_validate').append('<p>请输入正确的手机号！</p>');
    } else {
        $.ajax({
            url: '/collaborate',
            type: 'post',
            data: {name: cemetery_name, linkman: cemetery_linkman, mobile: cemetery_mobile},
            dataType: 'json',
            success: function (res) {
                //提示框
                $('#content').empty().append(res['msg']);
                $(".tooltip_pers").css({"display":"block"});
                $(".tooltip_box").css({"display":"block"});
                
                $('.leag_validate').empty();
                $('#cemetery_name').val('');
                $('#cemetery_linkman').val('');
                $('#cemetery_mobile').val('');
            },
            error: function () {
                //提示框
                $('#content').empty().append("申请失败,请重新申请!");
                $(".tooltip_pers").css({"display":"block"});
                $(".tooltip_box").css({"display":"block"});
            },
        });
    }
    
    return false;
});
 //关闭提示框
$(".tooltip_cloce, .ack_btn").click(function(event){
    $(".tooltip_pers").css({"display":"none"});
    $(".tooltip_box").css({"display":"none"});
});