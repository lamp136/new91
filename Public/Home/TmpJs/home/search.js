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