/* written by CC on 2015-08-18*/

$("#splby_button_11").click(function(){
	$("#splby_button_1").css("background-position","0px 0px");
	$("#content").removeClass('dn');
	$("#content2").addClass('dn');
	});
$("#splby_button_12").click(function(){
	$("#splby_button_1").css("background-position","0px 24px");
	$("#content2").removeClass('dn');
	$("#content").addClass('dn');
	});	



//

$("#content2 .jibie").hover(
		function(){
			b=this;
			time_jb=setTimeout("jibie_d(b)",200);
		}
,function(){
		clearTimeout(time_jb);
		$(this) .find(".jibie_2").slideUp("600");
});
function jibie_d(a){

	$(a) .find(".jibie_2").slideDown("600");
}


$("#jb_zhongxue").hover(
	function(){
			time_zx=setTimeout("zx()",200);
	},function(){
			clearTimeout(time_zx);
	}
)
function zx(){
	$('#jb_zhongxue').addClass('hbb').siblings().removeClass('hbb');
	$('#content2_zx').removeClass('dn');
	$('#content2_xx').addClass('dn');
	$('#content2_ye').addClass('dn');
}
			
$("#jb_xiaoxue").hover(
	function(){
			time_xx=setTimeout("xx()",200);
	},function(){
			clearTimeout(time_xx);
	}
)
function xx(){
	$('#jb_xiaoxue').addClass('hbb').siblings().removeClass('hbb');
	$('#content2_xx').removeClass('dn');
	$('#content2_zx').addClass('dn');
	$('#content2_ye').addClass('dn');
}

$("#jb_youer").hover(
	function(){
			time_ye=setTimeout("ye()",200);
	},function(){
			clearTimeout(time_ye);
	}
)
function ye(){
	$('#jb_youer').addClass('hbb').siblings().removeClass('hbb');
	$('#content2_ye').removeClass('dn');
	$('#content2_xx').addClass('dn');
	$('#content2_zx').addClass('dn');
}


$(".kelei:eq(2)").removeClass("mr30");
$(".kelei:eq(5)").removeClass("mr30");
$(".kelei:eq(8)").removeClass("mr30");
$(".kelei:eq(11)").removeClass("mr30");
$(".kelei:eq(14)").removeClass("mr30");
$(".kelei:eq(17)").removeClass("mr30");
$(".kelei:eq(20)").removeClass("mr30");
$(".kelei:eq(23)").removeClass("mr30");
$(".kelei:eq(26)").removeClass("mr30");
$(".kelei:eq(29)").removeClass("mr30");
$(".kelei:eq(32)").removeClass("mr30");
$(".kelei:eq(35)").removeClass("mr30");
