$(".news_nav li").hover(function(){$(this).find(".news_subnav").slideDown("fast")},function(){$(this).find(".news_subnav").slideUp("fast")}),$(".muxing").hover(function(){$("#zsmxImg").find("img").each(function(i){$(this).attr("src","/Public/Home/images/loading_260x150.gif")}),$(".muxing").removeClass("thistab"),$(this).addClass("thistab");var news_id=$(this).attr("data-id");$.ajax({url:"News/getzsmxinfo.html",type:"POST",data:"id="+news_id,success:function(d){for(var result=eval("("+d+")"),str="",i=0;i<result.BuriedImg.length;i++)str+=3==i?'<li class="last">':"<li>",str+='<a href="news/detail/'+result.id+'" title="'+result.title+'">',str+='<img src="'+result.BuriedImg[i].image_url+'" alt="'+result.title+'"/>',str+="</a></li>";$("#zsmxImg").html(str)}})},function(){}),$("#dynamic").kxbdMarquee({direction:"up",isEqual:!1});