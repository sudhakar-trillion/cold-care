$(document).ready(function()
{

$(".add_more_edit").css({'cursor':'pointer','margin-left': '5px'});

//console.log(document.createEvent("TouchEvent"));
if (window.innerWidth <= 370) 
{
 	// document.write('<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.3/jquery.mobile.min.js"><\/script>');
}

var wid =window.innerWidth 

var pathname = window.location.pathname;
var pge = pathname.split("/");
//var lastelem = pge.length;
var current_pge = pge[pge.length-1];
if(current_pge=='cart-view')
{
	if(wid>767)
	{
	//	window.location.reload();
		$(".smalldeviceCart").html('');
	}
	else
	{
		//window.location.reload();
		$(".mediumdeviceCart").html('');
		
	}
}

//login validation
//popup

$("#username_popup").on('focus',function() { $("#username-err").html(''); });
$("#password_popup").on('focus',function() { $("#pwd-err").html(''); });

//normal
$("#UserName").on('focus',function() { $("#username_err").html(''); });
$("#PassWord").on('focus',function() { $("#pwd_err").html(''); });


$("#PassWord, #UserName").keyup(function(event){
    if(event.keyCode == 13){
        $(".loginBTN").trigger('click');
    }
});


//normal
$(document).on('click',".loginBTN",function() 
{ 

var username = $("#UserName").val();
	username = $.trim(username);

var password = $("#PassWord").val();
	password = $.trim(password);

var err_cnt=0;
	
	if(username=='')
	{
		err_cnt=1;			
		$("#username_err").html('Userid is required');
	}
	if(password=='')
	{
		err_cnt=1;		
		$("#pwd_err").html('Password is required');	
	}
	if(err_cnt==0)
	{
		
		$.ajax({
					url:baseurl+'Requestdispatcher/validateUserlogin',
                                    type:'POST',
                                    data:{'username':username,'password':password},
									beforeSend:function(){ $(".ajax_load").show(); $(".ajax_load").html("<img src='"+baseurl+"/resources/site/img/loading2.gif'>");  },
                                    success:function(resp_data) 
                                            {
												$(".ajax_load").html(""); 
												$(".ajax_load").hide();
												resp_data = $.trim(resp_data);
												if(resp_data=="0")
												{
													$("#pwd_err").html('Invalid login credentials');
												}
												else if(resp_data=="1")
												{
													window.location.href=baseurl+"checkout";	
												}
											}
				
				});	
	
	
	}
	
	
});

//

$("#password_popup, #username_popup").keyup(function(event){
    if(event.keyCode == 13){
        $(".loginpopbtn").trigger('click');
    }
});



//popup 

$(document).on('click',".loginpopbtn",function() 
{ 

var username = $("#username_popup").val();
	username = $.trim(username);

var password = $("#password_popup").val();
	password = $.trim(password);

var err_cnt=0;
	
	if(username=='')
	{
		err_cnt=1;			
		$("#username-err").html('Userid is required');
	}
	if(password=='')
	{
		err_cnt=1;		
		$("#pwd-err").html('Password is required');	
	}
	if(err_cnt==0)
	{
		$.ajax({
					url:baseurl+'Requestdispatcher/validateUserlogin',
                                    type:'POST',
                                    data:{'username':username,'password':password},
									beforeSend:function(){ $(".popup_ajax_load").show(); $(".popup_ajax_load").html("<img src='"+baseurl+"/resources/site/img/loading2.gif'>");  },
                                    success:function(resp_data) 
                                            {
												$(".popup_ajax_load").html(""); 
												$(".popup_ajax_load").hide();
												resp_data = $.trim(resp_data);
												if(resp_data=="0")
												{
													$("#pwd-err").html('Invalid login credentials');	
												}else if(resp_data=="1")
												{
													window.location.href=baseurl+'profile-info';	
												}
												else if(resp_data=="-1")
												{
													$("#pwd-err").html('Inactive user');	
												}
											}
				
				});	
	}
	
});



    //get the categories based on the brand choosen starts here
    
    $("#brand").on('change',function() 
                        { 
                            var brandid = $(this).val();
                            brandid = $.trim(brandid);
                           
                            if(brandid!=0)
                            {
                                 /*
								   $.ajax({
                                    url:baseurl+'Requestdispatcher/getcategories_Brand',
                                    type:'POST',
                                    data:{'brandid':brandid},
                                    success:function(resp_categ) 
                                            {
                                                var categs = $.parseJSON(resp_categ);
                                                var optins='';
												 optins="<option value=0>Select category</option>"; 
                                                if(categs.nodata=="no")
                                                    {
														
                                                        $.each(categs[0],function(ind,val)
														{
															optins=optins+val;
                                                        });
                                                    }
                                              //  alert(optins);
                                                $("select#category").html(optins);
                                            }

                                });//ajax ends here 
								*/
                            }
                            else
                                {
                                 // $("select#category").html("<option value=0>Select category</option>");
                                }
                                   
                        });
    
    //get the categories based on the brand choosen ends here

$(document).on('change',"#category",function() 
{ 
	
	 
                            var categid = $(this).val();
                            categid = $.trim(categid);
                          /* 
						   var brand = $("#brand").val();
						   brand = $.trim(brand);
						  */ 
                            if(categid!=0)
                            {
                                   $.ajax({
                                    url:baseurl+'Requestdispatcher/getsubcategories_Category',
                                    type:'POST',
                                  //  data:{'categid':categid,'brand':brand},
								    data:{'categid':categid},
                                    success:function(resp_subcateg) 
                                            {
												
                                                var subcategs = $.parseJSON(resp_subcateg);
                                                var optins='';
												 optins="<option value=0>Select sub-category</option>"; 
                                                if(subcategs.nodata=="no")
                                                    {
														
                                                        $.each(subcategs[0],function(ind,val)
														{
															optins=optins+val;
                                                        });
                                                    }
                                              //  alert(optins);
                                                $("select#subcategory").html(optins);
                                            }

                                });//ajax ends here 
                            }
                            else
                                {
                                  $("select#subcategory").html("<option value=0>Select sub-category</option>");
                                }
                                   
                        

});

///get the product in the popup

//$(".product_view").on('click',function() { 
$(document).on('click','.product_view',function() {
	
$("#ProductId").val('');

$(".popup_titl").html('');
$(".popup_img").html('');
$(".popup_heading").html('');
$(".popup_price").html('');

//alert($(this).parent().parent().parent().find('.pkgtypes').attr('class')); return false;

var ide = $(this).attr('id');
if($(this).parent().parent().parent().find('.pkgtypes').attr('class')=='form-control pkgtypes')
{
	ide = $(this).parent().parent().parent().find('.pkgtypes').val();

}

	ide = $.trim(ide);

	$.ajax({
			 url:baseurl+'Requestdispatcher/getProduct',
			 type:'POST',
			 data:{'productid':ide},
 			 
			 success:function(resp_prdct) 
					 {
						resp_prdct = $.parseJSON(resp_prdct);
						
						if(resp_prdct.Noproducts=="no")
						{
							
							$(".popup_titl").html(resp_prdct.products.BrandName+"-"+resp_prdct.products.Name);
							var IMG = '<img src="'+resp_prdct.products.ProductImage+'" alt="" class="img-responsive" />';
							$(".popup_img").html(IMG);
							$(".popup_heading").html(resp_prdct.products.BrandName+"-"+resp_prdct.products.Name);
							//$(".popup_price").html("Rs."+resp_prdct.products.ProductPrice+"/"+resp_prdct.products.NetWeight+resp_prdct.products.MeasurementUnit);
							
							$(".netweight").html(resp_prdct.products.NetWeight+resp_prdct.products.MeasurementUnit);

							$(".grossweight").html(resp_prdct.products.GrossWeight+resp_prdct.products.MeasurementUnit);
							
							$(".pkgtype").html(resp_prdct.products.packagetype);
							
							if(resp_prdct.products.ReadyTo=='NA')
							{
								
								$(".radytoeat_yes").hide();
							}
							else
							{
								$(".radytoeat_yes").show();
								$(".radytoeat").html(resp_prdct.products.ReadyTo);
							}
							
						$(".price").html('<i class="fa fa-inr" aria-hidden="true"></i> '+resp_prdct.products.ProductPrice+"/-");		
						$("#ProductId").val(resp_prdct.products.ProductId);
						
						$(".decrs_qty").attr('prdid',resp_prdct.products.ProductId+"_"+resp_prdct.products.PackageId);
						$(".incrs_qty").attr('prdid',resp_prdct.products.ProductId+"_"+resp_prdct.products.PackageId);
						
						$(".qty_val").html(resp_prdct.products.Quantity);
						if(resp_prdct.incart=="yes")
						{
							$("button.addtocart").removeClass('btn-info');	
							$("button.addtocart").addClass('btn-danger');
							$("button.addtocart").addClass('addedtocart');
							$("button.addtocart").removeClass('addtocart');
							$(".addedtocart").html('In Cart');
						}
						else
						{
							
							$("button.addedtocart").removeClass('btn-danger');
							
							$("button.addedtocart").addClass('addtocart');
							$("button.addedtocart").removeClass('addedtocart');
							$("button.addtocart").html('Add to Cart');
							$("button.addtocart").addClass('btn-info');	
							
							$("button.addtocart").attr('id',resp_prdct.products.ProductId+"_"+resp_prdct.products.PackageId);
							
						}
							
						}
						else
						{
								//alert();
						}
												 
					 }//success ends here
			});

});

//check whether the product is in the cart or not when user changes the package type

$(document).on('change','.pkgtypes',function() 
{
	 
	var prdide = $(this).val();
	
	var resp_prdct_msg= '';
	
	var encyProductid = '';
var obj = $(this);
	console.log(obj);
var href= 	$(this).parent().parent().parent().find('.product_img_link').attr('href');


var href_split = href.split('product-view');
var href_split_productid = href_split[1].split('/');

var newhref='';
//send the product to the server to get the emcrypted one
			
	$.ajax({
			 url:baseurl+'Requestdispatcher/encryptProductid',
			 type:'POST',
			 data:{'productid':prdide},
			 async:true,
			 beforeSend:function(){ 
			 //	$(".pkgtypes").prev(".select_ajax_load").show(); 
				//$(".pkgtypes").prev(".select_ajax_load").html("<img src='"+baseurl+"/resources/site/img/loading2.gif'>");  
			 },
			 success:function(resp_prdct_enc) 
					 {
						 encyProductid = $.trim(resp_prdct_enc);
						 
						 
						var newhref =href.replace(href_split_productid[1],encyProductid);

						//alert(encyProductid+":"+newhref);
						 obj.parent().parent().parent().find('.product_img_link').attr('href',newhref);
						obj.parent().parent().parent().find('.product-name').attr('href',newhref);
						
						
						obj.parent().parent().parent().find('.product_img_link').attr('href',newhref);
						obj.parent().parent().parent().find('.product-name').attr('href',newhref);
					 }
					 
					 
			
			});


	$.ajax({
			 url:baseurl+'Requestdispatcher/checkProductincart',
			 type:'POST',
			 data:{'productid':prdide},
			 async:false,
			 success:function(resp_prdct) 
					 {
						 resp_prdct_msg = $.trim(resp_prdct);						 
					 }
			
			});
//alert(resp_prdct_msg); return false;
if(resp_prdct_msg=='0')
		 {
			 $(this).parent().parent().parent().find('.add-to-cart').html('<a class="addedtocart" style="color:red"  >In Cart</a>'); 
		 }
		 else
		 {
			 
			 $(this).parent().parent().parent().find('.add-to-cart').html(" <a class='addtocart' id='"+prdide+"'><i class='fa fa-shopping-basket' aria-hidden='true'></i></a>"); 
		 }
	

});



$(document).on('click','.addedtocart', function() { alert('Already in cart'); });

$(document).on('click',".addtocart",function() { 
	
	
	var ide='';
		
		
//check whether the product had any package types
//if then get the values of the selected package type
//if no then assign the id which came by default

if($(this).parent().parent().parent().find('.pkgtypes').attr('class')=='form-control pkgtypes')
{
	ide = $(this).parent().parent().parent().find('.pkgtypes').val();
	//alert('Found'+ide); return false;
}
else{
		ide = $.trim( $(this).attr('id') );
		//(ide+"Not FIND"); return false;
	}

//ide = parseInt(ide);		
		
	var qty_val = $('.qty_val').html();
	
	var thi=$(this);			
	
	
	$.ajax({
			url:baseurl+'Requestdispatcher/addtocart',
			type:'POST',
			data:{'productid':ide,'qty_val':qty_val},
			success:function(resp_prdct) 
			{
					resp_prdct = $.trim(resp_prdct);
					if(resp_prdct>0)
					{
						$(".cartItems").html(resp_prdct);
						thi.html('Added to cart');
						$('button.addtocart').addClass('addedtocart');
						$('button.addtocart').removeClass('btn-info');
						$('button.addtocart').addClass('btn-danger');
						$('button.addtocart').removeClass('addtocart');		
						
						
					}
			}
			
		});	
		
		

});


$(".clear_cart").on('click',function() { 

$.ajax({
			url:baseurl+'Requestdispatcher/clearcart',
			type:'POST',
			success:function(resp_prdct) 
			{
				//window.location.reload();
				window.location.href = window.location.href;
			}

});
});

///deleting single product from the cart

$(".cart-product-cancel").on('click',function() 
{ 
	var delPrd = $(this).attr('delPrd');
	delPrd = $.trim(delPrd);
	
	var rowid = $(this).attr('id');
	rowid = $.trim(rowid);
	
	var amnt = $("."+rowid).find('.prod-ammount').html();
	amnt=parseFloat(amnt);
	
	var total = $(".total-price").html();
		total = parseFloat(total);
		
	var remaining_total = ((total)-(amnt));
	$.ajax({
			url:baseurl+'Requestdispatcher/deletePrdCart',
			type:'POST',
			data:{'productId':delPrd},
			success:function(resp) 
			{
				resp = $.trim(resp);
				if(resp=="1")
				{
					$("."+rowid).remove();
					$(".total-price").html( remaining_total);
				}
			}

});


	
});

///confirm order
$(".order-confirm").on('click',function()
{
	
	$.ajax({
			url:baseurl+'Requestdispatcher/confirmOrder',
			type:'POST',
			beforeSend:function(){ $(".ajax_load").show(); $(".ajax_load").html("<img src='"+baseurl+"/resources/site/img/loading2.gif'>");  },
			success:function(resp) 
			{
				
				$(".ajax_load").html(""); 
				$(".ajax_load").hide();
				$(".order-confirm").hide();
				resp = $.trim(resp);
				if(resp=="1")
				{
					//window.location.reload();
					window.location.href = window.location.href;
				}
				else
				{
					if(resp=="no")
					//window.location.reload();
					window.location.href = window.location.href;
				}
				
				
			}
	});		
	
});
//confirm order ends here
	
//confirm order for changing from awaiting to approve

$("#terms_cond").on('click',function() 
{
	
	if(  $("#terms_cond").prop('checked'))
		{
			$("#term_cond_error").html('');
		}
	else
	{
		$("#term_cond_error").html('Please accept terms and conditions');
	}
});

$(".confirmbtn").on('click',function() 
{ 

var orderid = $("#orderId").val();
	orderid = $.trim(orderid);
	
	if(  $("#terms_cond").prop('checked'))
	{
		
		$.ajax({
			url:baseurl+'Requestdispatcher/approveOrder',
			type:'POST',
			data:{'OrderID':orderid},
			beforeSend:function(){ $(".ajax_load").show(); $(".ajax_load").html("<img src='"+baseurl+"/resources/site/img/loading2.gif'>");  },
			success:function(resp) 
			{
				$(".ajax_load").html(""); 
				$(".ajax_load").hide();
				$(".confirmbtn").hide();
				resp = $.trim(resp);
				if(resp=="1")
				{
					//window.location.reload();
					window.location.href = window.location.href;
				}
			}
	});		
		
	}
	else
	{
		$("#term_cond_error").html('Please accept terms and conditions');
	}

});


 
$(document).on('change','#filtered_subcateg, #filtered_type, #filtered_readyto,#Product_wise',function() 
{ 

	var subcateg = '0';
	var type = '';
	var readyto = 'NA';
	var Product_wise = '0';
	
		var totalProducts = $(".allproducts").length;
		var productId = $(".allproducts:eq("+(totalProducts-1)+")").attr("id");
	
		var chkcnt = $("#"+productId).attr('total_prdcts');
	
	var categID = $("#categID").val();
		categID = $.trim(categID);
	
	if($(document).find('#Product_wise'))
	{
		Product_wise = $("#Product_wise").val();
	}
	if($(document).find('#filtered_subcateg'))
	{
		subcateg = $("#filtered_subcateg").val();
	}
	if($(document).find('#filtered_type'))
	{
		type=$("#filtered_type").val();	
	}
	
	if($(document).find('#filtered_readyto'))
	{
		readyto=$("#filtered_readyto").val();
		
	}
	$.ajax({
				url:baseurl+'Requestdispatcher/getfilteredProducts',
				type:'POST',
				data:{'totalProducts':totalProducts,'comingFrom':'filter','Product_wise':Product_wise,'subcateg':subcateg,'type':type,'readyto':readyto,'categID':categID},
				beforeSend:function(){ 
				$(".select_ajax_load").show(); 
				$(".select_ajax_load").html("<img src='"+baseurl+"/resources/site/img/loading2.gif'>");  
			 },
				success:function(resp) 
				{
				
				$(".select_ajax_load").html("");  	
				$(".select_ajax_load").hide(); 
				
					resp = $.trim(resp);
					
					//$(".product_list").html(resp);
					$(".products_content").html(resp);
				}
			});


});


//change the order status

//$("#changeOrderStatus").on('change',function() { 
$(document).on('change','#changeOrderStatus', function()
{
	var status = $.trim( $(this).val() );
	if(status=="Cancelled")
	{
		//$("#reasontocancel").slideDown();	
		$("#reasontocancel").css({'display':'block'});
	}
	else
	{
		$("#reasontocancel").css({'display':'none'});
		//$("#reasontocancel").slideUp();
	}
});

$(document).on('click','#changestatusbtn',function(){
	
	$(this).prop('disabled',true);
	var status = $.trim( $("#changeOrderStatus").val() );
	var orderId = $("#orderId").val();
$(".select_ajax_load").show(); 

	if(status=="Cancelled")
	{
		var reason= $("textarea#reasontocancel").val();	
	}else
	{
		var reason='';	
	}


	if(status!='Change Status')
	{
		
		//check the scheduled on and scheduled at fields 
		
		var scheduledOn = $("#scheduledOn").val();
		var hrs = $("#hrs").val();
		var mins = $("#mins").val();
		
		var meri = $(".meridian").html();
		
		if(status=="Delivered")
		{
			var data ={'status':status,'reason':'','orderId':orderId,'scheduledOn':'','hrs':'','mins':'','meri':''};
		}
		else if(status=="Shipped")
		{
			var data ={'status':status,'reason':reason,'orderId':orderId,'scheduledOn':scheduledOn,'hrs':hrs,'mins':mins,'meri':meri};
		}
		
		else if(status=="Cancelled")
		{
			var data ={'status':status,'reason':reason,'orderId':orderId,'scheduledOn':'','hrs':'','mins':'','meri':''};
		}
		
		
		//alert();
		$.ajax({
					url:baseurl+'Requestdispatcher/changeOrderStatus',
					type:'POST',
					data:data,
					beforeSend:function(){ 
											$(this).prop('disabled',false);
											$(".select_ajax_load").show(); 
											$(".select_ajax_load").html("<img src='"+baseurl+"/resources/site/img/loading2.gif'>");  
			 								},
					
					async:true,
					success:function(resp) 
					{
						resp = $.trim(resp);
						if(resp=="1")
						{
							//alert(resp);
							$(".select_ajax_load").html("");  	
							$(".select_ajax_load").hide(); 
						
							window.location.href = window.location.href;	
						}
						else
						{
							$(".select_ajax_load").html("");  	
							$(".select_ajax_load").hide(); 	
						}
					}
				});
	
	}
	else
	{
		$(this).prop('disabled',false);
		return false;	
	}

	
});


//profile edit

$("#edit_authorised_email").on('focus',function() { $(".authorised_err").html(""); });

$(".profile_edit").on('click',function() 
{ 
	
	$(".succ_msg").html('');
	
	var edit_user_name = $("#edit_user_name").val();
		edit_user_name = $.trim(edit_user_name);
		
	var edit_store_name = $("#edit_store_name").val();
		edit_store_name = $.trim(edit_store_name);
		
	var edit_store_email = $("#edit_store_email").val();
		edit_store_email = $.trim(edit_store_email);
		
	var edit_authorised_email = $("#edit_authorised_email").val();
		edit_authorised_email = $.trim(edit_authorised_email);
		
	var edit_phone = $("#edit_phone").val();
		edit_phone = $.trim(edit_phone);
		
	var edit_store_addr = $("#edit_store_addr").val();
		edit_store_addr = $.trim(edit_store_addr);	

	var edit_location = $("#edit_location").val();
		edit_location = $.trim(edit_location);
		
	var edit_password = $("#edit_password").val();
		edit_password = $.trim(edit_password);
		
		
	if(edit_authorised_email=='')		
	{
		$(".authorised_err").html('Authorised email is required');
		return false;	
	}
	else
	{
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!filter.test(edit_authorised_email)) 
		{
			$(".authorised_err").html('Please provide a valid email address');
			return false;
		}
				
	}
	 
	 var $elem = $('.succ_msg');
	 
	$.ajax({
					url:baseurl+'Requestdispatcher/editprofile',
					type:'POST',
					data:{'edit_store_name':edit_store_name,'edit_password':edit_password,'edit_store_email':edit_store_email,'edit_authorised_email':edit_authorised_email,'edit_phone':edit_phone,'edit_store_addr':edit_store_addr,'edit_location':edit_location},
					success:function(resp) 
					{
						resp = $.trim(resp);
						if(resp=="1")
						{
							$(".alert-danger").hide();
							var msg = '<div class="alert alert-success"	>Profile updated successfully</div>';
							$(".succ_msg").html(msg);
							
							$('html, body').animate({scrollTop: $elem.height()}, 800);
							
							$(".authorisedemail").html(edit_authorised_email);
							$(".emailide").html(edit_store_email);
							
							$(".edit_phone").html(edit_phone);
							$(".edit_store_addr").html(edit_store_addr);
						}
						else
						{
								var msg = '<div class="alert alert-danger	>Unable to update profile</div>';
							$(".succ_msg").html(msg);
						}
					}
				});
	
	
	
	
});

$("#forget_reg_email").keyup(function(event){
    if(event.keyCode == 13){
        $(".forget_pwd").trigger('click');
    }
});

//forget password

 $("#forget_reg_email").on('focus',function(){ $(".forget_reg_email_err").html('');  $(".forget_pwd").attr("disabled",false); });

$(document).on('click','.forget_pwd',function() 
{ 

 $(".forget_pwd").attr("disabled","disabled");
 
	var forget_reg_email = $("#forget_reg_email").val();
		forget_reg_email = $.trim(forget_reg_email);

	if(forget_reg_email=='')
	{
		$(".forget_reg_email_err").html('Enter registered email');
		$( ".close" ).focus();
		
	}
	else
	{
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!filter.test(forget_reg_email)) 
		{
			$( ".close" ).focus();
			$(".forget_reg_email_err").html('Please provide a valid email address');
			return false;
		}
		else
		{
			$.ajax({
					url:baseurl+'Requestdispatcher/resetpassword',
					type:'POST',
					data:{'forget_reg_email':forget_reg_email},

					success:function(resp) 
					{
						
						var response = $.parseJSON(resp);
						if(response.Message=='done')
						{
							$("#forget_reg_email").val('');
							$(".forget_reg_email_err").html('Password has send to '+response.to);
							$( ".close" ).focus();
						}
						
					}
				});
				
			
		}
	}


});//forget password ends here

//load products on scroll	

$(document).on("scroll",function()
{
/*
	 
	if($(window).scrollTop() == $(document).height() - $(window).height())
	 {

		var totalProducts = $(".allproducts").length;
		var productId = $(".allproducts:eq("+(totalProducts-1)+")").attr("id");
	
		var chkcnt = $("#"+productId).attr('total_prdcts');
	
	if(chkcnt>totalProducts)
	{
		var subcateg = '0';
		var type = '';
		var readyto = 'NA';
		var Product_wise = '0';
		
		var categID = $("#categID").val();
			categID = $.trim(categID);
		
		if($(document).find('#Product_wise'))
		{
			Product_wise = $("#Product_wise").val();
		}
		if($(document).find('#filtered_subcateg'))
		{
			subcateg = $("#filtered_subcateg").val();
		}
		if($(document).find('#filtered_type'))
		{
			type=$("#filtered_type").val();	
		}
		
		if($(document).find('#filtered_readyto'))
		{
			readyto=$("#filtered_readyto").val();
		}
		
		$.ajax({
					url:baseurl+'Requestdispatcher/getfilteredProducts',
					type:'POST',
					data:{'productId':productId,'totalProducts':totalProducts,'comingFrom':'scroll','Product_wise':Product_wise,'subcateg':subcateg,'type':type,'readyto':readyto,'categID':categID},
					async:true,
					beforeSend:function(){ $(".ajax_load").show(); $(".ajax_load").html("<img src='"+baseurl+"/resources/site/img/loading2.gif'>");  },
					success:function(resp) 
					{
						$(".ajax_load").html(""); 
						$(".ajax_load").hide();
						resp = $.trim(resp);
						
						$("#"+productId).after(resp);
					}
				});
				
	}
		
		
	}

 
 */
 
 }); //window scroll ends here


//get the data when user clicks on any one the page in the pagination

$(document).on('click',".getdata_click",function()
{

	var this_obj = $(this);
	
	var pge = this_obj.attr('id');
	
	var total_prdcts = $(".allproducts").attr('total_prdcts');
	


		var totalProducts = $(".allproducts").length;
		var productId = $(".allproducts:eq("+(totalProducts-1)+")").attr("id");
	
		var chkcnt = $("#"+productId).attr('total_prdcts');
	
	if(chkcnt>totalProducts)
	{
		var subcateg = '0';
		var type = '';
		var readyto = 'NA';
		var Product_wise = '0';
		
		var categID = $("#categID").val();
			categID = $.trim(categID);
		
		if($(document).find('#Product_wise'))
		{
			Product_wise = $("#Product_wise").val();
		}
		if($(document).find('#filtered_subcateg'))
		{
			subcateg = $("#filtered_subcateg").val();
		}
		if($(document).find('#filtered_type'))
		{
			type=$("#filtered_type").val();	
		}
		
		if($(document).find('#filtered_readyto'))
		{
			readyto=$("#filtered_readyto").val();
		}
		
		$.ajax({
					url:baseurl+'Requestdispatcher/getfilteredProducts',
					type:'POST',
					data:{'productId':productId,'totalProducts':totalProducts,'pge':pge,'comingFrom':'scroll','Product_wise':Product_wise,'subcateg':subcateg,'type':type,'readyto':readyto,'categID':categID},
					async:true,
					beforeSend:function(){ $(".ajax_load").show(); $(".ajax_load").html("<img src='"+baseurl+"/resources/site/img/loading2.gif'>");  },
					success:function(resp) 
					{
						$(".ajax_load").html(""); 
						$(".ajax_load").hide();
						resp = $.trim(resp);
						
						$(".pagination a ").removeClass('active');
						this_obj.addClass('active');
					
						 $(".products_content").html(resp);
						var $products_content = $('.breadcrumb_colm');
						 $('html, body').animate({scrollTop: $products_content.offset().top}, 800);
						
					}
				});
				
	}
		
		
	
	
});

$("#netweight").on('focus',function() { $(".netweightErr").html(''); });
$("#grossweight").on('focus',function() { $(".grossweightErr").html(''); });

$("#quantity").on('focus',function() { $(".quantityErr").html(''); });
$("#product_price").on('focus',function() { $(".product_priceErr").html(''); });


$(document).on('click',".package-removal",function() { 
if(confirm("Do you want to remove"))
$(this).parent().remove();

});


//for adding product

$(document).on('click',".add_more",function() 
{ 
	var ide = $(this).attr('ide');
		ide = $.trim(ide);
	
	var inp = "";
	
	var parent = $(this).parent().attr('id');
		parent = $.trim(parent);
	
	if(ide == "netweight")
	{
		
		var netweight = $("#netweight").val();
		netweight  = $.trim(netweight);
		
		if( $(this).next().children().attr('class') == 'netweightMore' && netweight!='' )
		{
			
			inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='netweight[]' class='netweightMore netweight'  style='width:100%; margin-left:10px' /><span class='package-removal'>X</span></div>";
			$("#"+parent).find(".netweightMore").last().parent().after(inp); //find the last class and load the input after to that
		}
		else{	
				//	alert();
				if(netweight!='')	
				{
					inp = "<div style='position:relative;display:inline-block; width:8% ;margin-right:5px'><input type ='text' name='netweight[]' class='netweightMore'  style='width:100%; margin-left:10px' /> <span class='package-removal'>X</span></div>";
					$(this).after(inp);
				}
				else
				{
					$(".netweightErr").html("Enter net-weight");
				}
		}
	}
	
else if(ide == "grossweight")
{
	var grossweight = $("#grossweight").val();
		grossweight  = $.trim(grossweight);
		
		if( $(this).next().children().attr('class') == 'grossweightMore' && grossweight!='' )
		{
			inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='grossweight[]' class='grossweightMore'  style='width:100%; margin-left:10px' /><span class='package-removal'>X</span></div>";
			$("#"+parent).find(".grossweightMore").last().parent().after(inp); //find the last class and load the input after to that
		}
		else{		
			if(grossweight!='')
			{
				inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='grossweight[]' class='grossweightMore'  style='width:100%; margin-left:10px' /><span class='package-removal'>X</span></div>";
				$(this).after(inp);
			}
			else
			{
				$(".grossweightErr").html("Enter gross-weight");
			}
			
			}
	
	}//end of grossweight more
	

else if(ide == "quantity")
{
	
	var quantity = $("#quantity").val();
		quantity  = $.trim(quantity);
		
		if( $(this).next().children().attr('class') == 'quantityMore' && quantity!='' )
		{
			inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='quantity[]' class='quantityMore'  style='width:100%; margin-left:10px' /><span class='package-removal'>X</span></div>";
			$("#"+parent).find(".quantityMore").last().parent().after(inp); //find the last class and load the input after to that
		}
		else{		
				if(quantity!='')
				{
					inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='quantity[]' class='quantityMore'  style='width:100%; margin-left:10px' /><span class='package-removal'>X</span></div>";
					$(this).after(inp);
				}
				else
				{
					$(".quantityErr").html("Enter Quantity");	
				}
			}
	
	} ///end of quantity more
	

else if(ide == "product_price")
{
	
	var product_price = $("#product_price").val();
		product_price  = $.trim(product_price);
		
		if( $(this).next().children().attr('class') == 'product_priceMore' && product_price!='' )
		{
			inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='product_price[]' class='product_priceMore'  style='width:100%; margin-left:10px' /><span class='package-removal'>X</span></div>";
			$("#"+parent).find(".product_priceMore").last().parent().after(inp); //find the last class and load the input after to that
		}
		else{		
				if(product_price!='')
				{
					inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='product_price[]' class='product_priceMore'  style='width:100%; margin-left:10px' /><span class='package-removal'>X</span></div>";
					$(this).after(inp);
				}
				else
				{
					$(".product_priceErr").html("Enter Price");
				}
			}
	
	} ///end of quantity more	
	
	
});

//for editing product

$(document).on('click',".add_more_edit",function() 
{ 
	var ide = $(this).attr('ide');
		ide = $.trim(ide);
	
	var inp = "";
	
	var parent = $(this).parent().attr('id');
		parent = $.trim(parent);
	
	//product id
	var total_pkgs = $(this).attr('total_pkgs');
	
	var prd_id = $(this).attr('prd_id');
		//alert(prd_id+":"+total_pkgs);
		
	if(ide == "netweight")
	{
		
		var netweight = $("#netweight").val();
		netweight  = $.trim(netweight);
		
		if( $(this).next().children().attr('class') == 'netweightMore' && netweight!='' )
		{
			
			inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='netweight[]' class='netweightMore netweight' chk_param='netweight'  style='width:100%; margin-left:10px' /><span class='package-removal'>X</span></div>";
			$("#"+parent).find(".netweightMore").last().parent().after(inp); //find the last class and load the input after to that
		}
		else{	
				//	alert();
				if(netweight!='')	
				{
					inp = "<div style='position:relative;display:inline-block; width:8% ;margin-right:5px'><input type ='text' name='netweight[]' class='netweightMore' chk_param='netweight'  style='width:100%; margin-left:10px' /> <span class='package-removal'>X</span></div>";
					$(this).after(inp);
				}
				else
				{
					$(".netweightErr").html("Enter net-weight");
				}
		}
	}
	
else if(ide == "grossweight")
{
	var grossweight = $("#grossweight").val();
		grossweight  = $.trim(grossweight);
		
		if( $(this).next().children().attr('class') == 'grossweightMore' && grossweight!='' )
		{
			inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='grossweight[]' class='grossweightMore' chk_param='grossweight' style='width:100%; margin-left:10px' /><span class='package-removal'>X</span></div>";
			$("#"+parent).find(".grossweightMore").last().parent().after(inp); //find the last class and load the input after to that
		}
		else{		
			if(grossweight!='')
			{
				inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='grossweight[]' class='grossweightMore' chk_param='grossweight'  style='width:100%; margin-left:10px' /><span class='package-removal'>X</span></div>";
				$(this).after(inp);
			}
			else
			{
				$(".grossweightErr").html("Enter gross-weight");
			}
			
			}
	
	}//end of grossweight more
	

else if(ide == "quantity")
{
	
	var quantity = $("#quantity").val();
		quantity  = $.trim(quantity);
		
		if( $(this).next().children().attr('class') == 'quantityMore' && quantity!='' )
		{
			inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='quantity[]' class='quantityMore' chk_param='quantity'  style='width:100%;  margin-left:10px' /><span class='package-removal'>X</span></div>";
			$("#"+parent).find(".quantityMore").last().parent().after(inp); //find the last class and load the input after to that
		}
		else{		
				if(quantity!='')
				{
					inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='quantity[]' class='quantityMore' chk_param='quantity' style='width:100%; margin-left:10px' /><span class='package-removal'>X</span></div>";
					$(this).after(inp);
				}
				else
				{
					$(".quantityErr").html("Enter Quantity");	
				}
			}
	
	} ///end of quantity more
	

else if(ide == "product_price")
{
	
	var product_price = $("#product_price").val();
		product_price  = $.trim(product_price);


		if( $(this).next().children().attr('class') == 'product_priceMore' && product_price!='' )
		{
			
			inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='product_price[]' class='product_priceMore'  chk_param='product_price'   style='width:100%; margin-left:10px' /><span class='package-removal'>X</span></div>";
			$("#"+parent).find(".product_priceMore").last().parent().after(inp); //find the last class and load the input after to that
		}
		else{		
				if(product_price!='')
				{
					inp = "<div style='position:relative;display:inline-block; width:8%; margin-right:5px '><input type ='text' name='product_price[]' class='product_priceMore' chk_param='product_price'   style='width:100%; margin-left:10px' /><span class='package-removal'>X</span></div>";
					$(this).after(inp);
				}
				else
				{
					$(".product_priceErr").html("Enter Price");
				}
			}
	
	} ///end of quantity more	
	
	
});


//edit product details starts here

$(document).on('click',"#edit_Product_details",function() 
{
	$("#update_msg").html('');
	
	var errcnt='0';
	var query_data=[];
	var prdIde = $(this).attr('prdIde');
//check whether user selects brand or not
var brand	=	$("#brand").val();
	brand 	=	$.trim(brand);
	
	if(brand==0)
	{
		errcnt='1';
		$(".brnd_error").html("Select Brand");
		$('html, body').animate({scrollTop: $(".brnd_error").height()}, 800);
	}
	else
		$(".brnd_error").html("");	
//check whether user selects brand or not ends here		

//category validation starts here
	
var category	=	$("#category").val();
	category	=	$.trim(category);
	
	if(category==0)
	{
		errcnt='1';
		$(".category_err").html("Select Category");
		$('html, body').animate({scrollTop: $(".category_err").height()}, 800);
	}
	else
		$(".category_err").html("");	

//category validation ends here

// subcategory validation starts here		
		
var subcategory	=	$("#subcategory").val();
	subcategory	=	$.trim(subcategory);

	if(subcategory==0 && (category>0 && category<=3))
	{
		errcnt='1';
		$(".subcategory_err").html("Select Subcategory");
		$('html, body').animate({scrollTop: $(".subcategory_err").height()}, 800);
	}
	else
			$(".subcategory_err").html("");

// subcategory validation ends here	

//product name validation starts here

var product_name	=	$("#product_name").val();
	product_name	=	$.trim(product_name);

	if(product_name=='')	
	{
		
		errcnt='1';
		$(".product_name_err").html("Enter Product Name");
		$('html, body').animate({scrollTop: $(".product_name_err").height()}, 800);
	}
	else
		$(".product_name_err").html("");
	

//product name validation ends here

//product description validation starts here
	
var prdct_desc = $("#prdct_desc").val();
	prdct_desc	=	$.trim(prdct_desc);
	
	if(prdct_desc=='')
	{
		errcnt='1';
		$(".prdct_desc_err").html("Enter Product Description");
		$('html, body').animate({scrollTop: $(".prdct_desc_err").height()}, 800);
	}
	else
		$(".prdct_desc_err").html("");
		
//product description validation ends here		

// add type validation starts here

var subcategoryType = $("#subcategoryType").val();
	subcategoryType = $.trim(subcategoryType);

	if(subcategoryType=='')
	{
			
		errcnt='1';
		$(".subcategoryType_err").html("Enter Type");
		$('html, body').animate({scrollTop: $(".subcategoryType_err").height()}, 800);
	}
	else
		$(".subcategoryType_err").html("");
		
// add type validation ends here		



// ready to validation starts here
var prd_status = $('input[name=prd_status]:checked', '#edit_product_details').val();



var readyto = $("input[type=radio]").val();
	readyto = $.trim(readyto);
	

	if(readyto=='')
	{
			
		errcnt='1';
		$(".readyto_err").html("Select ready to eat");
		$('html, body').animate({scrollTop: $(".readyto_err").height()}, 800);
	}
	else
		$(".readyto_err").html("");
		
// ready to validation ends here	

//Measurement unit starts here

var Measurementunit = $("#unit").val();
	Measurementunit = $.trim(Measurementunit);

	if(Measurementunit==0)
	{
		errcnt='1';
		$(".unit_err").html("Select Measurement Unit");
		$('html, body').animate({scrollTop: $(".unit_err").height()}, 800);
	}
	else
		$(".unit_err").html("");


//Measurement unit ends here


//Measurement unit starts here

var baseuom = $("#baseuom").val();
	baseuom = $.trim(baseuom);

	if(baseuom==0)
	{
		errcnt='1';
		$(".baseuom_err").html("Select baseuom");
		$('html, body').animate({scrollTop: $(".baseuom_err").height()}, 800);
	}
	else
		$(".baseuom_err").html("");


//Measurement unit ends here



	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////// 		packing validation starts here		/////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	

	
	var netweight_packng="0";
	var total_pkgs = $(this).attr('total_pkgs');
	
	var total_pkgs = $(this).attr('total_pkgs'); 

	var netweight_attr = $("#netweight").attr('chk_param');
	//var total_netweights = $("input[chk_param='"+netweight_attr+"']" ).length;
	var total_netweights = $("input[name='netweight[]']" ).length;
	
	
	var grossweight_attr = $("#grossweight").attr('chk_param');
	var total_grossweights = $("input[chk_param='"+grossweight_attr+"']" ).length;
	
//	alert(grossweight_attr);

	var quantity_attr = $("#quantity").attr('chk_param');
	var total_quantity = $("input[chk_param='"+quantity_attr+"']" ).length;
	
	
	var product_price_attr = $("#product_price").attr('chk_param');
	var total_product_prices = $("input[chk_param='"+product_price_attr+"']" ).length;
	
	if( (total_netweights==total_grossweights) && (total_quantity==total_product_prices) )//checking whether all the packing has same number of packages
	{
		
		//check any netweight packaging empty or not
		
		var netweight_packng = $("input[name='netweight[]']" );
		
		for(var i=0;i<total_netweights;i++)
		{
			
			if( $.trim(netweight_packng[i].value)>0)	
			{
				
			}
			else
			{
				errcnt='1';
				$("#update_msg").html('<p class="alert alert-danger col-sm-10" style="margin-left:10px">Net weight packaging should be greater than zero</p>')	
				return false;
			}
			
		
		}
		
		//check any netweight packaging empty or not ends here
		
		//check any grossweight packaging empty or not starts here
		
		var grossweight_packng = $("input[name='grossweight[]']" );
		
		for(var i=0;i<total_grossweights;i++)
		{
			
			if( $.trim(grossweight_packng[i].value)>0)	
			{
				
			}
			else
			{
				errcnt='1';
				$("#update_msg").html('<p class="alert alert-danger col-sm-10" style="margin-left:10px">Gross weight packaging should be greater than zero</p>')	
				return false;
			}
			
		
		}
				//check any grossweight packaging empty or not ends here 
				
//check any quantity packaging empty or not starts here
		
		var quantity_packng = $("input[name='quantity[]']" );
		
		for(var i=0;i<total_quantity;i++)
		{
			
			if( $.trim(quantity_packng[i].value)>0)	
			{
				
			}
			else
			{
				errcnt='1';
				$("#update_msg").html('<p class="alert alert-danger col-sm-10" style="margin-left:10px">Quantity packaging should be greater than zero</p>')	
				return false;
			}
			
		
		}
				//check any quantity packaging empty or not ends here				
				
//check any quantity packaging empty or not starts here
		
		var product_price_packng = $("input[name='product_price[]']" );
		
		for(var i=0;i<total_product_prices;i++)
		{
			
			if( $.trim(product_price_packng[i].value)>0)	
			{
				
			}
			else
			{
				errcnt='1';
				$("#update_msg").html('<p class="alert alert-danger col-sm-10" style="margin-left:10px">Pricing packaging should be greater than zero</p>')	
				return false;
			}
			
		
		}
				//check any grossweight packaging empty or not ends here				
						
		
		
		
	
	}// if ends here
	else
	{
		errcnt='1';
		$("#update_msg").html('<p class="alert alert-danger col-sm-10" style="margin-left:10px">Please check the packages, packages looks differ in the number</p>')
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////// 		packing validation ends here		/////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	

	
	if(errcnt=="0")
	{
		

		var netweights = [];

//looping throught the neightweight packages and asign to the newarr
	   for(var i=0;i<total_netweights;i++)
		{
			/*var newarr=Array();
			newarr['packageid'] = $(netweight_packng[i]).attr('package_id');
			newarr['value'] =  $.trim(netweight_packng[i].value);
		*/
		
		var newarr = {
						'packageid':$(netweight_packng[i]).attr('package_id'),
						'value':$.trim(netweight_packng[i].value)
			
						};
			netweights.push(newarr);
		}

//console.log(netweights);

var grossweights = [];

//looping throught the grossweight packages and asign to the newarr
	   for(var i=0;i<total_grossweights;i++)
		{
			var newarr = {
							'packageid':$(grossweight_packng[i]).attr('package_id'),
							'value':$.trim(grossweight_packng[i].value)
							};
			grossweights.push(newarr);
		}


var quantity = [];

	   for(var i=0;i<total_quantity;i++)
		{
			
			var newarr = {
							'packageid':$(quantity_packng[i]).attr('package_id'),
							'value': $.trim(quantity_packng[i].value),
							};
			quantity.push(newarr);
		}
		
		
//console.log(quantity);	

var pricing = [];

	   for(var i=0;i<total_product_prices;i++)
		{
			var newarr=Array();
		
			newarr['packageid'] = $(product_price_packng[i]).attr('package_id');
			newarr['value'] =  $.trim(product_price_packng[i].value);
			
			var newarr = {
							'packageid':$(product_price_packng[i]).attr('package_id'),
							'value':$.trim(product_price_packng[i].value)
			};
			pricing.push(newarr);
		}
		
		
 $.ajax({
			url:baseurl+'Requestdispatcher/updateProductDetails',
			type:'POST',
			
   data:{'brand':brand,'category':category,'subcategory':subcategory,'product_name':product_name,'prdct_desc':prdct_desc,'subcategoryType':subcategoryType,'readyto':readyto,'prd_status':prd_status,'Measurementunit':Measurementunit,'baseuom':baseuom,'Net':netweights,'Gross':grossweights,'Quantity':quantity,'Pricing':pricing,'ProductId':prdIde,'totalpackages':total_pkgs},
		   //data:{"formdata":$('#edit_product_details').serialize()},
			success:function(resp_data) 
					{
						resp_data= $.trim(resp_data);
						if(resp_data=="1")
						{						
							$("#update_msg").html('<p class="alert alert-success col-sm-10" style="margin-left:10px">Product details updated successfully</p>')
						}
					}
	});

	
		
	}
	
});

//increase or decrease time in admin change order status page

$(".inc_dec").on('click',function()
{ 

	var incby = $(this).attr('incby');
	var inc=$(this).attr('inc')

		if(incby=="hrs")
		{
			var hours = $("#hrs").val();
			hours = $.trim(hours);
			
			if(hours!='')
			{
				hours = parseInt(hours);
				if(hours>0 && hours<=12)
				{
					if(inc=="yes" && hours<=11)
						hours = (hours)+1;
					else if(inc=="no" && hours>1)
						hours = (hours)-1;
				
					$("#hrs").val(hours);
				}
			}
		
		}
		else if(incby=="mins")
		{
			var minutes = $("#mins").val();
			minutes = $.trim(minutes);
			
			if(minutes!='')
			{
				minutes = parseInt(minutes);
				if(minutes>0 && minutes<=60)
				{
					if(inc=="yes" && minutes<=59)
						minutes = (minutes)+1;
					else if(inc=="no" && minutes>1)
						minutes = (minutes)-1;
				
					$("#mins").val(minutes);
				}
			}
		
		}
	
	

});



//am or pm

$(".am_pm").on('click',function()
{
	var chk_ampm = $(".meridian").html();
	
	var ampm = $(this).attr('ampm');
	
	if(chk_ampm=="AM" && ampm=="AM")
	{
		$(".meridian").html('PM');
	}
	else if(chk_ampm=="PM" && ampm=="PM")
	{
			$(".meridian").html('AM');
	}
});




//change password

$(document).on('click','.change_pwd',function() { 

//chngepwd_err
var newpassword = $("#newpassword").val();
	newpassword = $.trim(newpassword);
var thisobj = $(this);
	
	if(newpassword=='')
	{
		$(".chngepwd_err").html('Enter new password');
	}
	else
	{
		$.ajax({
					url:baseurl+'Requestdispatcher/changepassword',
					type:'POST',
					data:{'edit_password':newpassword},	
					beforeSend:function(){ thisobj.attr("disabled",true); },				
					success:function(resp) 
					{
						if(resp=="1")
						{
							$(".chngepwd_err").html('Password updated successfully');
							$("#newpassword").val('');
							thisobj.attr("disabled",false);
						}
					}
			});
	}


});

});