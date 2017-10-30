<!--------------------------------------------------------------------------- 
			Brands and Categories view in Index page
---------------------------------------------------------------------------->

            <div id="center_column" class="center_column col-xs-12 col-sm-12 col-md-9">
              <div class="clearfix">
                <div id="featured-products_block_center" class="block products_block clearfix">
                
                 <!-- 
                                    Commented by sudhaker on 18-03-2017 as client asked to show only categories
                 <h2 class="centertitle_block"><a href="javascript:void(0)" class="brand_tab active">Our Brands</a></h2>-->
                  
                  <h2 class="centertitle_block"><a  class="categories_tab active">Categories</a></h2>
                  <!-- 
                   Commented by sudhaker on 18-03-2017 as client asked to show only categories
                  <div class="block_content">
                   
                   
                   		 <ul class="tm-carousel brand_list">
                    
                   	  <?PHP
					  	foreach($brands_logos->result() as $logos)
						{
							
					  ?>
                     
                      <li class="item last-item-of-mobile-line col-sm-4">
                        <div class="product-container">
                          <div class="left-block">
                            <div class="product-image-container"> 
                            <a class="product_img_link" href="<?php echo base_url("brand/".$logos->BrandName."/"); ?>" title="" itemprop="url">
                            <img class="replace-2x img-responsive" src="<?PHP echo $logos->LogoPath; ?>" alt="" title="" width="220" height="200" itemprop="image" />
                            </a> 
                            </div>
                          </div>
                          
                        </div>
                      </li>
                     
                      <?PHP
						}
						?>
		            
                    </ul>
                    
                    
                  </div>
                  -->
                </div>
                
                <div id="newproducts_block" class="block products_block categories_list">
                    
                    <ul class="tm-carousel categories_list">
                    <?PHP
					foreach($Categories->result() as $catg)
					{
						
					?>
                      <li class="item last-item-of-mobile-line  col-sm-4">
                        <div class="product-container">
                          <div class="left-block">
                            <div class="product-image-container"> 
                            <a class="product_img_link" href="<?php echo base_url('categories/'.str_replace(" ","-",$catg->Category_Name) ); ?>" title=""> 
                            <img class="replace-2x img-responsive" src="<?PHP echo $catg->LogoPath; ?>" alt="" title="" width="220" height="200" itemprop="image" /> 
                            </a> 
                          </div>
                          </div>
                          
                          <div class="right-block">
                          	<h5><a class="product-name" href="<?php echo base_url('categories/'.str_replace(" ","-",$catg->Category_Name) ); ?>"  title=""> <b><?PHP echo $catg->Category_Name; ?></b></a></h5>
                          </div>
                        </div>
                      </li>
               <?PHP
					}
				?>

                    
                      
                    </ul>
                </div>
                </div>
                
              </div>
          
<!--------------------------------------------------------------------------- 
			Brands and Categories view code ends here in Index page
---------------------------------------------------------------------------->
            
            
			</div>
          
        </div>
      </div>
    </div>
  </div>
              