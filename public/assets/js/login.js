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
					
					
					


				        