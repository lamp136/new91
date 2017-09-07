//导航
var mt = 0;
window.onload = function () {
    var mydiv = document.getElementById("topics_nav");
    var mt = mydiv.offsetTop; //当前对象到距离上方或上层控件的位置
    var tt = document.documentElement.scrollTop || document.body.scrollTop;
    if (tt > mt) {
        mydiv.style.position = "fixed";
        mydiv.style.margin = "0";
        mydiv.style.top = "0";
    }
    window.onscroll = function () {
        var t = document.documentElement.scrollTop || document.body.scrollTop;
        if (t > mt) {
            mydiv.style.position = "fixed";
            mydiv.style.margin = "0";
            mydiv.style.top = "0";
        }
        else {
            mydiv.style.position = "static";
        }
    }
}
$(".topics_nav ul li").click(function () {
    $(".topics_nav ul li").removeClass();
    $(this).addClass("currter");
});

//陵园资质滚动
$(function(){
    $("#marquee1").kxbdMarquee({direction:"left"});
});