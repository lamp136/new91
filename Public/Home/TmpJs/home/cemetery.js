//陵园地区点击展示更多地区
$(".more_btn").click(function() {
    $(".more_main").toggle();
});
//预约看墓
$(".yu_btn").click(function () {
    var yu_name = trimStr($("#yu_name").val());
    var yu_mobile = trimStr($("#yu_mobile").val());
    //正则匹配mobile
    var pattern = /^1((3\d)|(47)|(5[0-35-9])|(7[01789])|(8\d))\d{8}$/;
    var pattern_name = /^[\u4e00-\u9fa5]{0,}$/;
    if (!pattern.test(yu_mobile)) {
        //提示框
        $('#content').empty().append("请输入正确的手机号！");
        $(".tooltip_pers").css({"display":"block"});
        $(".tooltip_box").css({"display":"block"});
    } else if (!(pattern_name.test(yu_name) && yu_name)) {
        //提示框
        $('#content').empty().append("请输入中文姓名！");
        $(".tooltip_pers").css({"display":"block"});
        $(".tooltip_box").css({"display":"block"});
    } else {
        $.ajax({
            url: '/book',
            type: 'post',
            data: {name: yu_name, mobile: yu_mobile},
            dataType: 'json',
            success: function (res) {
                //提示框
                $('#content').empty().append(res['msg']);
                $(".tooltip_pers").css({"display":"block"});
                $(".tooltip_box").css({"display":"block"});
                $("#yu_name").val("");
                $("#yu_mobile").val("");
            },
            error: function () {
                //提示框
                $('#content').empty().append("预约失败,请重新预约!");
                $(".tooltip_pers").css({"display":"block"});
                $(".tooltip_box").css({"display":"block"});
                
                $("#yu_name").val("");
                $("#yu_mobile").val("");
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

$(function () {
    $('#yu_name').focusin(function(){
        $('#yu_name').attr('maxlength','5');
    })
    $("#yu_mobile").keyup(function () {
        //如果输入非数字，则替换为''，如果输入数字，则在每4位之后添加一个空格分隔
        this.value = this.value.replace(/[^\d]/g, '').replace(/(\d{4})(?=\d)/g, "$1");
    })
});