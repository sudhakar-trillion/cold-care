// JavaScript Document
$(document).ready(function(){
	
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
    
	
	$("input.captcha").keyup(function(){
		//alert('hi');
		var captcha = $("input.captcha").val();
		
		if(captcha.length == 6){
			$.ajax({
				type:"POST",
				url:"validate.php",
				data:{'captcha':captcha},
				success: function(captcha_resp){
						
						//alert(captcha_resp);
					
						if(captcha_resp == 1){
							$(".mesg_captcha").html('<span style="color:green;"><i class="fa fa-check-circle" aria-hidden="true"></i></span>');
						}else{
							$(".mesg_captcha").html('<span style="color:red;"><i class="fa fa-times-circle" aria-hidden="true"></i></span>');
						}
					}
				});
		}else{
			$(".mesg_captcha").html('');
		}
	});
	
	
	$(".contact_enquery_Submit").click(function(){
		
		var contact_enquery_name = $(".contact_enquery_name");
		var contact_enquery_mobile = $(".contact_enquery_mobile");
		var contact_enquery_email = $(".contact_enquery_email");
		var contact_enquery_message  = $(".contact_enquery_message");
		var captcha = $(".captcha");	
	
		$([contact_enquery_name, contact_enquery_mobile, contact_enquery_email, contact_enquery_message, captcha]).each(function(){
			$(this).keyup(function(){
			$(this).css('border','1px solid #eee');
			});
		});
		
		if(contact_enquery_name.val() == ''){
			contact_enquery_name.focus().css('border','1px solid red');
			return false;
		}else if(contact_enquery_mobile.val() == ''){
			contact_enquery_mobile.focus().css('border','1px solid red');
			return false;
		}else if(contact_enquery_email.val() == ''){
			contact_enquery_email.focus().css('border','1px solid red');
			return false;
		}else if(contact_enquery_message.val() == ''){
			contact_enquery_message.focus().css('border','1px solid red');
			return false;
		}else if(captcha.val() == ''){
			captcha.focus().css('border','1px solid red');
			return false;
		}else if(captcha.val() != ''){
						
			var wrong =	$(".mesg_captcha span i").attr('class');
			
			if(wrong == 'fa fa-times-circle'){
				alert("captch not valid");
			}
			else
			{
				
			var contact_enquery_name   = contact_enquery_name.val();
			var contact_enquery_mobile = contact_enquery_mobile.val();
			var contact_enquery_email  = contact_enquery_email.val();
			var contact_enquery_message  = contact_enquery_message.val();
						
			$.ajax({
				type:'POST',
				url:"sendmail.php",
				data:{'name':contact_enquery_name,'mobile':contact_enquery_mobile,'email':contact_enquery_email,'messg':contact_enquery_message},
				success: function(resp){
					
					$(".mesg_captcha").html('');
					
					$('#form_contact_enquery').trigger('reset');
					alert(resp);
				}

			});
			return false;
			
				
			}
			
		}
		
	});
	
	
	/*$(".address-colm").hide();
	$(".login-btn").click(function(){
		$(".login-form").hide();
		$(".address-colm").show();
	})*/
	
	
	
	
});