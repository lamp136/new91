$('#personalForm input[name="name"]').blur(function(){var o=$(this).val();""==o?$("#nameError").show():$("#nameError").hide()});var bank_account_error=!1;$('#personalForm input[name="bank_account"]').change(function(){var o=$(this).val(),n=o.indexOf("*");n>=0?($("#bank_accountError").show(),bank_account_error=!0):($("#bank_accountError").hide(),bank_account_error=!1)}),$(".pers_save").click(function(){var name=$('#personalForm input[name="name"]').val(),bank_account=$('#personalForm input[name="bank_account"]').val();return""==name?($("#nameError").show(),!1):!bank_account_error&&void $.ajax({url:"user_center/savememberinfo.html",type:"POST",data:$("#personalForm").serialize(),success:function(d){var result=eval("("+d+")");1==result.flag?($("#content").empty().append(result.msg),$(".tooltip_pers").css({display:"block"}),$(".tooltip_box").css({display:"block"}),setTimeout(function(){window.location.reload()},2e3)):0==result.flag&&($("#content").append(result.msg),$(".tooltip_pers").css({display:"block"}),$(".tooltip_box").css({display:"block"}))}})}),$(".tooltip_cloce, .ack_btn").click(function(o){$(".tooltip_pers").css({display:"none"}),$(".tooltip_box").css({display:"none"})});