/*2015-09-15 CC*/

/*登陆弹窗*/

					/*忘记密码 返回按钮*/
					$("#lg_remember div").click(function(){
						$(".remember").addClass("dn");
						$(".login").removeClass("dn");
						$(".reg").addClass("dn");
						$("#background").addClass("dn");
					});
					
					/*注册 关闭按钮*/
					$("#lg_reg #close1").click(function(){
						$(".reg").addClass("dn");
						$("#background").addClass("dn");
						$("#lg_login").removeClass("dn");
					});

					/*忘记密码 关闭按钮*/
					$("#lg_remember #close3").click(function(){
						$(".remember").addClass("dn");
						$(".login").removeClass("dn");
						$("#background").addClass("dn");
						$(".reg").addClass("dn");
					});
					
					/*注册 忘记密码按钮*/
					$("#lg_reg #forget1").click(function(){
						$(".remember").removeClass("dn");
						$("#background").removeClass("dn");
					});

					/*登录 忘记密码按钮*/
					$("#lg_login #forget2").click(function(){
						$(".remember").removeClass("dn");
						$("#background").removeClass("dn");
					});

					/*登录 快速注册按钮*/
					$(".content #quickreg").click(function(){
						$(".reg").removeClass("dn");
						$(".login").addClass("dn");
						$("#background").addClass("dn");
					});
					
					/*注册 快速登录按钮*/
					$(".content #quicklogin").click(function(){
						$(".reg").addClass("dn");
						$(".login").removeClass("dn");
						$("#background").addClass("dn");
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
