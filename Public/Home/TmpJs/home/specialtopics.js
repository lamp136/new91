//会员专栏banner轮播
img.init();
img.play(0);
//阻止事件冒泡
function estop(e) {
    var e = arguments.callee.caller.arguments[0] || event;
    if (e && e.stopPropagation) {
        //因此它支持W3C的stopPropagation()方法
        e.stopPropagation();
    } else {
        //否则，我们需要使用IE的方式来取消事件冒泡
        window.event.cancelBubble = true;
        return false;
    }
}