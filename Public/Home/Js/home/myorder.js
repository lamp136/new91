$(document).ready(function(){$(".order_evaluate").click(function(t){$(".order_evaluate_bg").css({display:"block"}),$(".order_evaluate_box").css({display:"block"}),$(".evaluate_submit").css({display:"block"}),$("#star").css({display:"block"}),$("#advice").css({display:"block"}),$("#huifang").css({display:"none"}),$(".suggest_tarea").empty(),store_id=$(this).parent().attr("store_id"),order_id=$(this).parent().attr("order_id")}),$(".order_evaluate_cloce").click(function(t){$(".order_evaluate_bg").css({display:"none"}),$(".order_evaluate_box").css({display:"none"})}),$(".evaluate_submit").click(function(){var t=$("#hj").attr("hj-score"),e=$("#jg").attr("jg-score"),a=$("#jt").attr("jt-score"),r=$("#fw").attr("fw-score"),s=$(".suggest_tarea").val();$.ajax({url:"/UserCenter/evaluate.html",type:"post",data:{order_id:order_id,store_id:store_id,content:s,environment:t,service:r,price:e,traffic:a},dataType:"json",success:function(t){1==t.flag?($("#content").html(t.msg),$(".tooltip_pers").css({display:"block"}),$(".tooltip_box").css({display:"block"}),$(".suggest_tarea").val(""),$(".order_evaluate_bg").css({display:"none"}),$(".order_evaluate_box").css({display:"none"}),window.location.reload()):($("#content").html(t.msg),$(".tooltip_pers").css({display:"block"}),$(".tooltip_box").css({display:"block"}),$(".suggest_tarea").val(""))}})})}),$(".tooltip_cloce, .ack_btn").click(function(t){$(".tooltip_pers").css({display:"none"}),$(".tooltip_box").css({display:"none"})}),$("#hj").raty({click:function(t,e){$(this).attr("hj-score",t)}}),$("#jg").raty({click:function(t,e){$(this).attr("jg-score",t)}}),$("#jt").raty({click:function(t,e){$(this).attr("jt-score",t)}}),$("#fw").raty({click:function(t,e){$(this).attr("fw-score",t)}}),$(document).ready(function(){var member_id=$("#store_id").attr("member_id");$(".comment").click(function(){var store_id=$(this).parent().attr("store_id");$.ajax({url:"/UserCenter/comment.html",type:"POST",data:{store_id:store_id,member_id:member_id},success:function(d){var data=eval("("+d+")");$(".order_evaluate_bg").css({display:"block"}),$(".order_evaluate_box").css({display:"block"}),$(".evaluate_submit").css({display:"none"}),$("#star").css({display:"none"}),$("#advice").css({display:"none"}),$("#huifang").css({display:"block"}),$(".suggest_tarea").html(data.msg)}})})}),$(".orderback").click(function(){var order_id=$(this).parent().attr("order_id"),r=confirm("请确认您要申请退单吗?");1==r&&$.ajax({url:"/UserCenter/orderback.html",type:"POST",data:{order_id:order_id},success:function(data){result=eval("("+data+")"),1==result.flag&&($("#content").html("贵宾您好，您的退单申请已提交，我们的工作人员会在24小时内与您联系！"),$(".tooltip_pers").css({display:"block"}),$(".tooltip_box").css({display:"block"})),window.location.reload()}})}),$(".returnmoney").click(function(){var order_id=$(this).parent().attr("order_id"),r=confirm("请确认您要申请返现吗?");1==r&&$.ajax({url:"/UserCenter/returnmoney.html",type:"POST",data:{order_id:order_id},success:function(data){result=eval("("+data+")"),1==result.flag&&alert(result.msg),$(".returnmoney").attr("disabled",!0)}})});