//下拉菜单
$(".news_nav li").hover(function () {
    $(this).find(".news_subnav").slideDown("fast");
}, function () {
    $(this).find(".news_subnav").slideUp("fast");
});
