    //删除关注
    $('.del_btn').click(function(){
        var collect_id = $(this).attr('collect_id');
        $.ajax({
            //url:"{:U('UserCenter/collect')}",
            url:'/UserCenter/collect.html',
            type:'post',
            data:"collect_id="+collect_id,
            dataType:'json',
            success:function(data){
                //提示框
                $('#content').empty().append(data.msg);
                $(".tooltip_pers").css({"display":"block"});
                $(".tooltip_box").css({"display":"block"});
                setTimeout(function(){window.location.reload();},2000);
            }
        });
    });
    
     //关闭提示框
    $(".tooltip_cloce, .ack_btn").click(function(event){
        $(".tooltip_pers").css({"display":"none"});
        $(".tooltip_box").css({"display":"none"});
    });