// JavaScript Document
$(document).ready(function(){
	
	
	////////////////////
	// captcha generate
	////////////////////
	
	
	var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for(var i = 0; i <5; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
	$('.captcha_code').html(text);
	
	
	$(".brand_tab").addClass('active');
	
	$(".brand_tab, .categories_tab").each(function(index, element) {
		
		var tabs_btn = $(this).attr('class');
		
		if(tabs_btn == 'brand_tab active'){
			
			$('.categories_list').hide();
			$('.brand_list').show();
			
		}else if(tabs_btn == 'categories_tab active'){
			
			$('.brand_list').hide();
			$('.categories_list').show();
			
		}
	
    });
	
	
	$(".categories_tab").click(function(){
			$(this).addClass('active');
			$('.brand_tab').removeClass('active');
			$('.categories_list').show();
			$('.brand_list').hide();
    });
	
	
	$(".brand_tab").click(function(){
			$(this).addClass('active');
			$('.categories_tab').removeClass('active');
			$('.categories_list').hide();
			$('.brand_list').show();
    });
    
	
	
	$(".tree-menu-list").click(function(){
		
	$(this).siblings('.tree-menu-list').css({'background':'#fff'}).find('.tree-sub-menu').hide(800).parent().find('a > span.pull-right > .fa').removeClass('fa-minus').addClass("fa-plus");
	
	$(this).children('.tree-sub-menu').slideToggle(800).parent(".tree-menu-list").css({'background':'#f7f7f7'}).find('span.pull-right > .fa').toggleClass("fa-minus ");
	
	$(this).siblings().find('a').css({'background':'#fff','color':'#333'});
	
	$(this).children('a').css({'background':'#d4e8b5','color':'#517d0d'});
		
	});
	
	
	/*$(".brand_list").html('');
	$(".brand_list").html('<li class=" item last-item-of-mobile-line col-sm-4"><div class="product-container"><div class="left-block"><div class="product-image-container"><a class="product_img_link" href="categoryproduct.php" title="Nascetur ridiculus mus" itemprop="url"><img class="replace-2x img-responsive" src="img/brands/mccain-logo.jpg" alt="" title="" width="220" height="200" itemprop="image" /></a></div></div></div></li>');*/
	
	//$(".address-colm").hide();
	/*$(".login-btn").click(function(){
		$(".login-form").hide();
		$(".address-colm").show();
	})*/
	
	
	$('#myCarousel').carousel({
	  interval: 3000,
	  cycle: true
	}); 
	
	
	/*-----------------------------------------------
	** Change Login form to forgot pass
	-----------------------------------------------*/
	
	$('.forgot-text').click(function(){
		//console.log('ok');
		$('.close').trigger('click');
		$('body.index').css('padding-right','0px');
	});
	
	$('body.index').css('padding-right','0px');
	
	
	//////////////////////////////////////////////////
	// Cart quantity value increment and decrement
	//////////////////////////////////////////////////
	
	//console.log($(".prod-ammount").length);
	
	var prd_amt = $(".prod-ammount").html();
	
	$(".incrs_qty").click(function(){
	
		var prdid = $(this).attr('prdid');
			
			prdid = $.trim(prdid);
		var qty_val = $(this).prev('.qty_val').html();
		
		$.ajax({
				url:baseurl+'Requestdispatcher/alterCart',
				type:'POST',
				data:{'productid':prdid,'qty_val':qty_val,"Inc_dec":'Inc'},
				success:function(resp_prdct) 
					{
						
					}
			});
		
		var cost = $(this).parent().prev().find('.cost').text();
		var prod_amt = $(".prod-ammount").html();
		$(this).prev('.qty_val').html(parseInt(qty_val)+1);
		var qty_val = $(this).prev('.qty_val').html();
		
		
		$(this).parent('.prod-quty').next().find(".prod-ammount").html(parseInt(qty_val)*cost);
		var oldTotal = $('.total-price').html();
		
		$('.total-price').html(parseInt(oldTotal)+parseInt(cost));

	});
	
	
	$(".decrs_qty").click(function(){
		var prdid = $(this).attr('prdid');
		
		var qty_val = $(this).next('.qty_val').html();
		//alert(qty_val);
		if(qty_val >1){
		
		
				$.ajax({
				url:baseurl+'Requestdispatcher/alterCart',
				type:'POST',
				data:{'productid':prdid,'qty_val':qty_val,"Inc_dec":'Dec'},
				success:function(resp_prdct) 
					{
						
					}
			});
		}
		
		var cost = $(this).parent().prev().find('.cost').text();
				

		if(qty_val>1)
		{
			$(this).next('.qty_val').html(parseInt(qty_val)-1);
			var qty_val = $(this).next('.qty_val').html();
		
		$(this).parent('.prod-quty').next().find(".prod-ammount").html(parseInt(qty_val)*cost);
		
		var oldTotal = $('.total-price').html();
		
		$('.total-price').html(parseInt(oldTotal)-parseInt(cost));
		}
		
		
		
		
	});
	
/*	
	var cls_len = $(".prod-ammount").length;
	var prd_amt = 1;
	
	var tt_val = 0;
	$(".prod-ammount").each(function(){		
			ammt = parseInt($(this).text());
			tt_val +=ammt;
			$('.total-price').html(tt_val);
			console.log(tt_val, prd_amt++);
	});
	
*/	
	
	//////////////////////////////////////////////////
	// Cart quantity value increment and decrement
	//////////////////////////////////////////////////
	
	
	
	//////////////////////////////////////////////////
	// footer colums toggle function in mobile device
	//////////////////////////////////////////////////

	//alert($(window).width());
	if($(window).width() < 767){
		$(".toggle-footer").toggle();
		$(".footer-block h4").click(function(){
			$(this).next(".toggle-footer").slideToggle(500);
		});
	};
	
	$(".navbar-toggle").click(function(){
		$(".menu-content").slideToggle(500);
	});
	
	
	///////////////////////
	// sign up validation
	///////////////////////

	$(".EmailId").focus(function(){
		$('span.error_email').html('');
	});
	
	$(".UserName").focus(function(){
		$('span.error_userId').html('');
	});

	$(".signup_btn").click(function(){
		
		var StoreName = $(".StoreName");
		var Location = $(".Location");
		var brands_name = $(".brands_name");
		var EmailId= $(".EmailId");
		var UserName = $(".UserName");
		var Password= $(".Password");
		var captcha_val = $(".captcha_val");
		var org_captcha = $(".captcha_code").html();
		var City = $(".city");
		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
		
		$.each([StoreName, Location,City, brands_name, EmailId, UserName, Password, captcha_val], function(){
				if($(this).val() != ''){
					$(this).css('border-color','#d6d4d4');
				};
				
				
				if($(".brands_name").val() != '0'){
					$(this).css('border-color','#d6d4d4');
				};
				
				$(this).keyup(function(){
					$(this).css('border-color','#d6d4d4');
				});
				
				$(".brands_name").change(function(){
					$(this).css('border-color','#d6d4d4');
				});
			});

		
		if(City.val()=="0")
		{
			$(".city").focus().css('border-color','red');
			return false;
		}
		if(StoreName.val() == ''){
			$(StoreName).focus().css('border-color','red');
			return false;
		}else if(Location.val() == ''){
			$(Location).focus().css('border-color','red');
			return false;
		}else if(brands_name.val() == '0'){
			$(brands_name).focus().css('border-color','red');
			return false;
		}else if(EmailId.val() == ''){
			$(EmailId).focus().css('border-color','red');
			return false;
		}else if(pattern.test(EmailId.val()) == false){
			$(EmailId).focus().css('border-color','red');
			return false;
		}else if(UserName.val() == ''){
			$(UserName).focus().css('border-color','red');
			return false;
		}else if(Password.val() == ''){
			$(Password).focus().css('border-color','red');
			return false;
		}else if(captcha_val.val() == ''){
			//alert($(".captcha_code").text());
			//op1+'+'+op2
			$(captcha_val).focus().css('border-color','red');
			return false;
		}else if(captcha_val.val() != org_captcha){
			$(captcha_val).focus().css('border-color','red');
			return false;
		}else{
			
				$.ajax({
						
						url:baseurl+'Requestdispatcher/registeruser',
						type:'POST',
						//data:{'StoreName':StoreName.val(), 'Location':Location.val(), 'brands_name':brands_name.val(), 'EmailId':EmailId.val(), 'UserName':UserName.val(), 'Password':Password.val()},
						data:{'StoreName':StoreName.val(), 'Location':Location.val(), 'City':City.val(), 'EmailId':EmailId.val(), 'UserName':UserName.val(), 'Password':Password.val()},
						beforeSend:function(){ $(".ajax_load").show(); $(".ajax_load").html("<img src='"+baseurl+"/resources/site/img/loading2.gif'>");  },
						success:function(respData) 
						{ 
							$(".ajax_load").html(""); 
							$(".ajax_load").hide();
							
							var out = $.parseJSON(respData);
							
							if(out.userId == 'yes'){
								$("span.error_userId").html('<i class="fa fa-times-circle" aria-hidden="true"></i>');
							}else if(out.Email == 'yes'){
								$("span.error_email").html('<i class="fa fa-times-circle" aria-hidden="true"></i>');
							}
							else if(out.Inserted == 'yes')
							{
								$("#user_reg")[0].reset();
								$("#reg_here").html('register success please check your Mail Id');
							}	
							else if(out.Inserted == 'oops')
							{
								$("#user_reg")[0].reset();
								$("#reg_here").html('register success unable to send Mail Id');
							}
							else if(out.Inserted == 'no')
							{
								$("#reg_here").html('register success please check your Mail Id');
							}	
							
							
							
							
						}
						});
		}
		
	});
	
	/////////////////////////////////////////
	// get barands in home page on 13-02-2017
	/////////////////////////////////////////
	
	$.ajax({
						
			url:baseurl+'Requestdispatcher/getbrands',
			type:'POST',
			//data:{},
			success:function(respData) { //alert(respData)
				var brands = $.parseJSON(respData);
				var opts = "<option value='0'>Select Brand</option>";

				if(brands.length > 0){
					$.each(brands, function (index, value){
						opts = opts+"<option value='"+value.BrandId+"'>"+value.Brand+"</option>";
						//alert(value.BrandId);
					});
				}
				
				$("select#brands_name").html(opts);
			}
			});
	
});


/////////////////////////////////
// dropdown menu for in menu.php
/////////////////////////////////


$(".dropdown_btn").click(function(){
	$(this).toggleClass('open');
});