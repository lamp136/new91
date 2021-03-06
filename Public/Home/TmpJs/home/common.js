$('#backTop').on('click', move);
$('#backTop').hide();
$(window).on('scroll', function(){
	//设置返回按钮出现的高度（一屏）
	checkPosition($(window).height());
});

checkPosition($(window).height());

//运动返回顶部
function move(){
	$('html, body').animate({
		scrollTop: 0
	}, 800);
}

//直接返回顶部不需要运动 上面click需要修改成go
function go(){
	$('html, body').scrollTop(0);
}

// 返回顶部按钮显示隐藏
function checkPosition(pos){
	if ($(window).scrollTop() > pos) {
		$('#backTop').fadeIn();
	} else{
		$('#backTop').fadeOut();
	}
}
//头部省份切换
jQuery.jqtab = function (tabtit, tabcon) {
    $(tabcon).hide();
    $(tabtit + " li:first").addClass("thistab").show();
    $(tabcon + ":first").show();

    $(tabtit + " li").click(function () {
        $(tabtit + " li").removeClass("thistab");
        $(this).addClass("thistab");
        $(tabcon).hide();
        var activeTab = $(this).find("a").attr("tab");
        $("#" + activeTab).fadeIn();
        return false;
    });
};

$.jqtab("#city_nav", ".city_box");
//头部的搜索
function search_top(){
    var wd = $('#seacth_top_form input[name="wd"]').val();
    $.ajax({
        url: "/searchkeywords.html",
        type: 'POST',
        async:false,
        data: 'keyword='+wd,
        success: function (d) {
        }
    });
}
//头部地址
$(".c_down").click(function () {
  $(".search_city").css("display", "block");
})
//选择城市关闭
$(".search_close,.city_box ul li").click(function () {
  $(".search_city").hide();
})

//去除字符串两边的空格函数
function trimStr(str) {
    return str.replace(/(^\s*)|(\s*$)/g, "");
}