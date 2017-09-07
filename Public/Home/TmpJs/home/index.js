//查找陵园地区
$(".seek_down").click(function () {
  $(".see_city").css("display", "block");
})
//选择城市关闭
$(".seek_close,.cityB_box ul li").click(function () {
  $(".see_city").hide();
})

//查找殡仪馆地区
$(".byg_down").click(function () {
  $(".byg_city").css("display", "block");
})
//选择城市关闭
$(".byg_close,.cityC_box ul li").click(function () {
  $(".byg_city").hide();
})

//banner部分
$(".main_visual").hover(function () {
  $("#btn_prev,#btn_next").fadeIn()
}, function () {
  $("#btn_prev,#btn_next").fadeOut()
})
$dragBln = false;
$(".main_image").touchSlider({
  flexible: true,
  speed: 200,
  btn_prev: $("#btn_prev"),
  btn_next: $("#btn_next"),
  paging: $(".flicking_con a"),
  counter: function (e) {
      $(".flicking_con a").removeClass("on").eq(e.current - 1).addClass("on");
  }
});
$(".main_image").bind("mousedown", function () {
  $dragBln = false;
})
$(".main_image").bind("dragstart", function () {
  $dragBln = true;
})
$(".main_image a").click(function () {
  if ($dragBln) {
      return false;
  }
})
timer = setInterval(function () {
  $("#btn_next").click();
}, 5000);
$(".main_visual").hover(function () {
  clearInterval(timer);
}, function () {
  timer = setInterval(function () {
      $("#btn_next").click();
  }, 5000);
})
$(".main_image").bind("touchstart", function () {
  clearInterval(timer);
}).bind("touchend", function () {
  timer = setInterval(function () {
      $("#btn_next").click();
  }, 5000);
});

$("#marquee4").kxbdMarquee({direction: "up", isEqual: false});

//搜索陵园选择地区
$('.region_provice').bind('click', function () {
  var provinceId = $(this).attr('data-val');
  var provincename = $(this).text();
  $('.cemetery-province').val(provincename);
  $('.cemetery-provinceid').val(provinceId);
});
//搜索殡仪馆选择地区
$('.funeral_provice').bind('click', function () {
  var provinceId = $(this).attr('data-val');
  var provincename = $(this).text();
  $('.funeral-province').val(provincename);
  $('.funeral-provinceid').val(provinceId);
});

//陵园和殡仪馆搜索
jQuery.jqtab = function (tabtit, tabcon) {
    $(tabcon).hide();
    $(tabtit + " li:first").addClass("thistab").show();
    $(tabcon + ":first").show();

    $(tabtit + " li").click(function () {
        $(tabtit + " li").removeClass("thistab");
        $(this).addClass("thistab");
        $(tabcon).hide();
        var activeTab = $(this).find("a").attr("tab");
        $("#" + activeTab).fadeIn();
        return false;
    });
};

$.jqtab("#seek_nav", ".seek_box");
$.jqtab("#city_nav", ".city_box");
$.jqtab("#cityB_nav",".cityB_box");
$.jqtab("#cityC_nav",".cityC_box");


//首页陵园部分的搜索
function search_cemetery() {
	var wd = $('#search_cemetery_form input[name="wd"]').val();
	var provinceId = $('#search_cemetery_form input[name="province"]').val();
$.ajax({
    url: "/searchcemetery.html",
    type: 'POST',
    async:false,
    data: 'keyword='+wd+'&province_id='+provinceId,
    success: function (d) {
    }
});
}
//首页 殡仪馆部分的搜索
function search_funeral() {
	var wd = $('#search_funeral_form input[name="wd"]').val();
	var provinceId = $('#search_funeral_form input[name="province"]').val();
$.ajax({
    url: "/searchfuneral.html",
    type: 'POST',
    async:false,
    data: 'keyword='+wd+'&province_id='+provinceId,
    success: function (d) {
    }
});
}