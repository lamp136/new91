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