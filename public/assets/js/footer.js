/*2015-09-10 CC*/

/*登陆弹窗*/
					var bh = $("body").height();
					var bw = $("body").width();
					$("#background").height(bh).width(bw);

					
					$("#register .remember div").click(function(){
						$(".remember").addClass("dn");
						$(".login").removeClass("dn");
						$(".reg").addClass("dn");
					});

					$("#register #close1").click(function(){
						$(".reg").addClass("dn");
						$("#background").addClass("dn");
					});

					$("#register #close2").click(function(){
						$(".login").addClass("dn");
						$("#background").addClass("dn");
					});

					$("#register #close3").click(function(){
						$(".remember").addClass("dn");
						$(".login").removeClass("dn");
						$(".reg").addClass("dn");
					});

					$("#register #forget1").click(function(){
						$(".remember").removeClass("dn");
						$("#background").removeClass("dn");
					});

					$("#register #forget2").click(function(){
						$(".remember").removeClass("dn");
						$("#background").removeClass("dn");
					});

					$("#register #quickreg").click(function(){
						$(".reg").removeClass("dn");
						$(".login").addClass("dn");
						$("#background").removeClass("dn");
					});

					$("#register #quicklogin").click(function(){
						$(".reg").addClass("dn");
						$(".login").removeClass("dn");
						$("#background").removeClass("dn");
					});

					function reg(){
						$(".reg").removeClass("dn");
						$(".login").addClass("dn");
						$("#background").removeClass("dn");
					}

					function login(){
						$(".reg").addClass("dn");
						$(".login").removeClass("dn");
						$("#background").removeClass("dn");
					}
					function ydd(){
						$("#header #smxz").removeClass("dn");
					}
					function ydd_out(){
						$("#header #smxz").addClass("dn");
					}
/*页脚APP二维码*/
	function app(){
		document.getElementById("ewm_img").src="/assets/img/ico_app.png";
		document.getElementById("ewm_app").style.color="#fff";
		document.getElementById("ewm_wx").style.color="#8c8c8c";
		document.getElementById("ewm_wb").style.color="#8c8c8c";
	}
	function weixin(){	
		document.getElementById("ewm_img").src="/assets/img/ico_weixin.png";
		document.getElementById("ewm_wx").style.color="#fff";
		document.getElementById("ewm_app").style.color="#8c8c8c";
		document.getElementById("ewm_wb").style.color="#8c8c8c";
	}
	function weibo(){
		document.getElementById("ewm_img").src="/assets/img/ico_weibo.png";
		document.getElementById("ewm_wb").style.color="#fff";
		document.getElementById("ewm_wx").style.color="#8c8c8c";
		document.getElementById("ewm_app").style.color="#8c8c8c";
	}