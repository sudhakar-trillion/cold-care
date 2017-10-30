<!--------------------------------------------------------------------------- 
	 Category product view code starts Here
---------------------------------------------------------------------------->

            <div id="center_column" class="center_column col-xs-12 col-sm-12 col-md-9">
              <div class="clearfix">
              	
              	
                <div id="featured-products_block_center" class="block products_block clearfix">
                
                  <div class="block_content">
                   
                    <ul class="tm-carousel" style="display:block;">
                    
                    <?PHP
						
						foreach($brnd->result() as $brndId)
						{
							$BrndId = 	$brndId->BrandId;
						}
						
						$CI=&get_instance();
						
						$CI->db->select('cat.LogoPath, cat.CategoryID, cat.Category_Name, prd.BrandId ');
						$CI->db->from('products as prd');
						$CI->db->join('categories as cat','cat.CategoryID=prd.Category_Id');
						$CI->db->where('prd.BrandId',$BrndId);
						$CI->db->group_by('cat.Category_Name');
						$qry = $CI->db->get('');
						
					foreach($qry->result() as $categs)
					{
					?>
                    
                    <li class="item last-item-of-mobile-line  col-sm-4">
                        <div class="product-container">
                          <div class="left-block">
                            <div class="product-image-container"> 
                            <a class="product_img_link" href="<?php echo base_url($this->uri->segment(2)."/".strtolower(str_replace(" ","-",$categs->Category_Name) )); ?>/products" title=""> 
                            <img class="replace-2x img-responsive" src="<?PHP echo $categs->LogoPath; ?>" alt="" title="" width="220" height="200" itemprop="image" /> 
                            </a> 
                          </div>
                          </div>
                          
                          <div class="right-block">
                          	<h5><a class="product-name" href="<?php echo base_url($this->uri->segment(2)."/".strtolower(str_replace(" ","-",$categs->Category_Name) )); ?>/products" title=""> <b><?PHP echo $categs->Category_Name; ?></b></a></h5>
                          </div>
                        </div>
                      </li>
                     <?PHP
					}
					?>
                     
                      
                    <!--
                    	  <li class="item last-item-of-mobile-line  col-sm-4">
                        <div class="product-container">
                          <div class="left-block">
                            <div class="product-image-container"> 
                            <a class="product_img_link" href="brandsproducts.html" title=""> 
                            <img class="replace-2x img-responsive" src="resources/site/img/categories/fruits-and-vegetables.jpg" alt="" title="" width="220" height="200" itemprop="image" /> 
                            </a> 
                            </div>
                          </div>
                          
                          <div class="right-block">
                          	<h5><a class="product-name" href="brandsproducts.html" title=""> <b>Fruits and Vegetables</b> </a></h5>
                          </div>
                        </div>
                      </li>
                      
                      
                      
                      <li class="item last-item-of-mobile-line col-sm-4">
                        <div class="product-container">
                          <div class="left-block">
                            <div class="product-image-container"> 
                            <a class="product_img_link" href="brandsproducts.html" title=""> 
                            <img class="replace-2x img-responsive" src="resources/site/img/categories/chilled-products.jpg" alt="" title="" width="220" height="200"/> 
                            </a>	
                            </div>
						  </div>
                          
                          <div class="right-block">
                          	<h5><a class="product-name" href="brandsproducts.html" title=""> <b>Chilled products</b> </a></h5>
                          </div>
                        </div>
                      </li>
                     -->
                      
                    </ul>
                  </div>
                </div>
                
                </div>
                
              </div>

<!--------------------------------------------------------------------------- 
	 Category product view code starts Here
---------------------------------------------------------------------------->
	            

<!--------------------------------------------------------------------------- 
	Main container Code ends Here and starts in menu page
---------------------------------------------------------------------------->     
 		</div>
          
        </div>
      </div>
    </div>
  </div>
              