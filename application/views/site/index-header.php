
          <div class="row">
          <div id="top_column" class="center_column col-xs-12 col-sm-12">
          <?php
		  if($this->session->userdata('UserName') == '')
		  {
		  ?>
              
              <div id="tmhomepage-slider">
                
              <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
              </ol>
            
              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <div class="item active">
                  <img src="resources/site/img/banner/banner.jpg" alt="Chania">
                </div>
            
                <div class="item">
                  <img src="resources/site/img/banner/banner1.jpg" alt="Chania">
                </div>
            
                <div class="item">
                  <img src="resources/site/img/banner/banner2.jpg" alt="Flower">
                </div>
            
              </div>
            
              <!-- Left and right controls -->
              <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="fa fa-chevron-circle-left glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="fa fa-chevron-circle-right glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
                
              </div>
              
              <div class="tm_topbanner">
                <form method="post" id="user_reg">
                	<h4 id="reg_here">Register Here</h4>
                	
                    <div class="form-group">
                       <select class="form-control city" name="city">
                       <option value="0" selected="selected">Select City</option>
                       <option value="Hyderabad">Hyderabad</option>
                       
                       </select><!--
                        <input type="text" name="city" class="City form-control" placeholder="City (Ex: Ameerpet, Uppal, etc)" />-->
                        <!--<span class="location_icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>-->
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="location" class="Location form-control" placeholder="Location (Ex: Ameerpet, Uppal, etc)" />
                        <!--<span class="location_icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>-->
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="owner_name" class="StoreName form-control" placeholder="Store Name" />
                    </div>
					
                    <!--
                    <div class="form-group">
                        <select name="brands_name" id="brands_name" class="brands_name form-control">
                        	
                        </select>
                    </div>-->
                    
                    <div class="form-group">
                        <input type="text" name="email" class="EmailId form-control" placeholder="Email" />
                        <span class="error_email"></span>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="user_name" class="UserName form-control" placeholder="Login Id" />
                        <span class="error_userId"></span>
                    </div>
                                        
                    
                    
                    <div class="form-group">
                        <input type="password" name="password" class="Password form-control" placeholder="Password" />
                    </div>
                   
                    <div class="form-group captcha">
                    	<input class="form-control captcha_val"  size="30" type="text" name="captcha_val" placeholder="captcha">
                        <span class="captcha_code"></span>
                    	<div class="mesg_captcha"></div>
                    </div>
                    
                    <div class="form-group">
                    	<div class="ajax_load"></div>
                    	<button type="button" class="btn btn-block btn-success signup_btn">Signup</button>
                    </div>
                </form>
               
               
              </div>
              
            <?php
			}else{
			?>
              
              <div id="Carouselslider" class="col-sm-12">
                
              <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
              </ol>
            
              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <div class="item active">
                  <img src="resources/site/img/banner/banner-lg.jpg" alt="" class="img-responsive" />
                </div>
            
                <div class="item">
                  <img src="resources/site/img/banner/banner-lg1.jpg" alt="" class="img-responsive" />
                </div>
            
                <div class="item">
                  <img src="resources/site/img/banner/banner-lg2.jpg" alt="" class="img-responsive" />
                </div>
            
              </div>
            
              <!-- Left and right controls -->
              <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="fa fa-chevron-circle-left glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="fa fa-chevron-circle-right glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
                
              </div>
              
            <?php
			}
            ?>
          </div>
          </div>
          
          <div id="brands_product" class="mar-all-0">
            <div id="brands_slider" class="block products_block">
              <h2 class="centertitle_block"><a href="javascript:void(0)" title="Manufacturers">Manufacturers</a></h2>
              <div class="block_content">
                <div class="customNavigation"> <a class="btn prev manufacturer_prev"><i class="icon-chevron-sign-left"></i></a> <a class="btn next manufacturer_next"><i class="icon-chevron-sign-right"></i></a></div>
                <ul id="manufacturer-carousel" class="tm-carousel clearfix">
                  <li class="item ">
                    <div class="manu_image"> <a href="javascript:void(0)" title=""><img src="resources/site/img/brands/product-logo/mccain.jpg" alt="" class="img-responsive" /></a></div>
                  </li>
                  <li class="item ">
                    <div class="manu_image"> <a href="javascript:void(0)" title=""><img src="resources/site/img/brands/product-logo/kfc-logo.jpg" alt="" class="img-responsive" /></a></div>
                  </li>

                  <li class="item ">
                    <div class="manu_image"> <a href="javascript:void(0)" title=""><img src="resources/site/img/brands/product-logo/dominos-logo.jpg" alt=""  class="img-responsive"/></a></div>
                  </li>
                  <li class="item ">
                    <div class="manu_image"> <a href="javascript:void(0)" title=""><img src="resources/site/img/brands/product-logo/burger-logo.jpg" alt="" class="img-responsive" /></a></div>
                  </li>
                  <li class="item ">
                    <div class="manu_image"> <a href="javascript:void(0)" title=""><img src="resources/site/img/brands/product-logo/mcd-logo.jpg" alt="" class="img-responsive" /></a></div>
                  </li>

                  <li class="item ">
                    <div class="manu_image"> <a href="javascript:void(0)" title=""><img src="resources/site/img/brands/product-logo/pizzahut-logo.jpg" alt="" class="img-responsive" /></a></div>
                  </li>
                  
                </ul>
              </div>
            </div>
          </div>
          
          <div class="clearfix">
          	<hr/>
          </div>
          
         