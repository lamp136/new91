    $(document).ready(function(){
        $(".order_evaluate").click(function(event){
            $(".order_evaluate_bg").css({"display":"block"});
            $(".order_evaluate_box").css({"display":"block"});
            $('.evaluate_submit').css({"display":"block"});
            $('#star').css({"display":"block"});
            $('#advice').css({"display":"block"});
            $('#huifang').css({"display":"none"});
            $('.suggest_tarea').empty();

            store_id = $(this).parent().attr('store_id');

            order_id = $(this).parent().attr('order_id');

        });
        $(".order_evaluate_cloce").click(function(event){
            $(".order_evaluate_bg").css({"display":"none"});
            $(".order_evaluate_box").css({"display":"none"});
        });
        $('.evaluate_submit').click(function(){
            var hj_score = $('#hj').attr('hj-score');
            var jg_score = $('#jg').attr('jg-score');
            var jt_score = $('#jt').attr('jt-score');
            var fw_score = $('#fw').attr('fw-score');
            var content  = $('.suggest_tarea').val();
            //alert(store_id);
            $.ajax({
                url:"/UserCenter/evaluate.html",
                type:'post',
                data:{order_id:order_id,store_id:store_id,content:content,environment:hj_score,service:fw_score,price:jg_score,traffic:jt_score,},
                dataType:'json',
                success : function(data){
                    if(data.flag==1){
                       $('#content').html(data.msg);
                       $(".tooltip_pers").css({"display":"block"});
                       $(".tooltip_box").css({"display":"block"});
                        $('.suggest_tarea').val('');
                        
                        $(".order_evaluate_bg").css({"display":"none"});
                        $(".order_evaluate_box").css({"display":"none"});
                        window.location.reload();
                    }else{
                        $('#content').html(data.msg);
                        $(".tooltip_pers").css({"display":"block"});
                        $(".tooltip_box").css({"display":"block"});
                        $('.suggest_tarea').val('');

                    }
                }
            });
        });
    });
    //关闭提示框
    $(".tooltip_cloce, .ack_btn").click(function(event){
        $(".tooltip_pers").css({"display":"none"});
        $(".tooltip_box").css({"display":"none"});
    });

    $('#hj').raty({
        click: function (score, evt) {
              $(this).attr('hj-score',score);
           },
    });
    $('#jg').raty({
        click: function (score, evt) {
              $(this).attr('jg-score',score);
           },
    });
    $('#jt').raty({
        click: function (score, evt) {
              $(this).attr('jt-score',score);
           },
    });
    $('#fw').raty({
        click: function (score, evt) {
              $(this).attr('fw-score',score);
           },
    });


    $(document).ready(function(){
         var  member_id = $('#store_id').attr('member_id');
           $('.comment').click(function(){
            var  store_id = $(this).parent().attr('store_id');
             $.ajax({
                 url:"/UserCenter/comment.html",
                 type:'POST',
                 data:{store_id:store_id,member_id:member_id},
                 success:function(d){
                  var data = eval("("+d+")");
                      
                  $(".order_evaluate_bg").css({"display":"block"});
                  $(".order_evaluate_box").css({"display":"block"});
                  $('.evaluate_submit').css({"display":"none"});
                  $('#star').css({"display":"none"});
                  $('#advice').css({"display":"none"});
                  $('#huifang').css({"display":"block"});
                  $('.suggest_tarea').html(data.msg);

                }
             })
               
               
            });
        });
        
        $('.orderback').click(function(){
            var order_id = $(this).parent().attr('order_id');
            var r = confirm("请确认您要申请退单吗?");
           if(r == true){
            $.ajax({
                url:"/UserCenter/orderback.html",
                type:'POST',
                data:{order_id:order_id},
                success:function(data){
                    result = eval("("+data+")");
                    if(result.flag==1){

                      $('#content').html('贵宾您好，您的退单申请已提交，我们的工作人员会在24小时内与您联系！');
                       $(".tooltip_pers").css({"display":"block"});
                       $(".tooltip_box").css({"display":"block"});
                    }
                     window.location.reload();

                }
            });
           }
        });


        $('.returnmoney').click(function(){
            var order_id = $(this).parent().attr('order_id');
            var r = confirm("请确认您要申请返现吗?");
            if(r == true){
            $.ajax({
                url:"/UserCenter/returnmoney.html",
                type:'POST',
                data:{order_id:order_id},
                success:function(data){
                    result = eval("("+data+")");
                    if(result.flag==1){
                        alert(result.msg);
                    }
                     $('.returnmoney').attr('disabled',true);
                }
            });
           }
        });


