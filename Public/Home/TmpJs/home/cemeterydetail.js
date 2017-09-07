//陵园景观间歇式轮播
$("#det_landscape").cxScroll();

//陵园资质轮播
$(function () {
    $('#qualify').flexslider({
        animation: "slide",
        direction: "horizontal",
        easing: "swing"
    });
});

//陵园景观点击小图弹出大图
$('.fancybox').fancybox();

//评分
$('.pf').each(function(){
    var pfvalue = $(this).attr('data-value');
    $(this).raty({readOnly: true, score: pfvalue});
 }
);

//添加收藏 
$('.det_collect').click(function(){
	var sid = $(this).attr('data-sid');
	var cimgurl = $(this).attr('data-cimg');
    if(sid == ""){
        window.location.href='/login.html';
    }else{
        var store_id = $(this).attr('storeid');
        $.ajax({
            url:'/cemetery/collect.html',
            type:'post',
            data:"store_id="+store_id,
            dataType:'json',
            success:function(data){
                //提示框
                $('#content').empty().append(data.msg);
                $(".tooltip_pers").css({"display":"block"});
                $(".tooltip_box").css({"display":"block"});
                if(data.flag == 1){
                    $('#collect_src').replaceWith('<img title="关注" alt="关注" id="collect_src" src="'+cimgurl+'collect_b.png"/>');
                    $('.det_collect').removeClass('det_collect');
                }
            }
        });
    }
});

 //关闭提示框
$(".tooltip_cloce, .ack_btn").click(function(event){
    $(".tooltip_pers").css({"display":"none"});
    $(".tooltip_box").css({"display":"none"});
});