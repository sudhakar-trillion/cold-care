<!--------------------------------------------------------------------------- 
			Display product by brands view in brandproduct page
---------------------------------------------------------------------------->
  
            <div id="center_column" class="center_column col-xs-12 col-sm-12 col-md-9">
              <div class="clearfix">
                <div id="featured-products_block_center" class="block products_block clearfix">
                
                <div class="col-sm-12 col-xs-12 breadcrumb_colm">
                	<ol class="breadcrumb">
                        <li><a href="<?PHP echo base_url();?>">Home</a></li>
                        <li class="active"><?PHP echo ucwords($this->uri->segment(2)." in ".$this->uri->segment(1));?>  </li>        
                      </ol>
                </div>
                <div class="clearfix"></div>
                 <!-- filter section-->
                 <?PHP
				   if($products->num_rows()>0)
				   {
				   ?>
	              <div class="col-sm-12">
                       
                        <div class="row">
                        <div class="filter_all_colms">
                            <div class="filter_colms form-group">
                                <label class="filter_by_label">Filter By : </label>
                                <div class="clearfix"></div>
                            </div>
                            
                            <?PHP
							if($subcatide!='0')
							{
							?>
                            <div class="filter_colms form-group">
                                <select class="form-control" id="filtered_subcateg">
                                    <option value="0" selected="selected">Select Subcategory</option>
                                    <?PHP
									foreach($subcatide->result() as $SUBCAT)
									{
									?>
                                    <option value="<?PHP echo $SUBCAT->Sub_CatId;?>"><?PHP echo $SUBCAT->SubCategory;?></option>
                                    <?PHP	
									}
									?>
                                    
                                </select>
                            </div>
                            <?PHP
							}
							if($prdnames->num_rows()>0)
							{
								?>
                                <div class="filter_colms form-group">
                                <select class="form-control" id="Product_wise">
                                    <option value="0" selected="selected">Select Product</option>
                                    <?PHP
									foreach($prdnames->result() as $PRODUCT)
									{
									?>
                                    <option value="<?PHP echo $PRODUCT->ProductName;?>"><?PHP echo $PRODUCT->ProductName;?></option>
                                    <?PHP	
									}
									?>
                                    
                                </select>
                            </div>
                                <?PHP	
							}
							
							if($type!='0')
							{
							?>
                            <div class="filter_colms form-group">
                                <select class="form-control" id="filtered_type">
                                    <option value="0" selected="selected">Select type</option>
                                    <?PHP
									foreach($type->result() as $typ)
									{
									?>
                                    <option value="<?PHP echo $typ->Type;?>"><?PHP echo $typ->Type;?></option>
                                    <?PHP	
									}
									?>
                                </select>
                            </div>
                            <?PHP
							}
							if($frozen!='0')
							{
							?>
                            <div class="filter_colms form-group">
                                <select class="form-control" id="filtered_readyto">
                                    <?PHP
									//$froz_cnt=0;
										foreach($frozen as $val)
										{
											?>
                                            <option value="<?PHP echo $val;?>"><?PHP echo $val;?></option>
                                            <?PHP	
										}
									?>
                                </select>
                            </div>
                            <?PHP
							}
							?>
                             <input type="hidden"  class="form-control"  id="categID" value="<?PHP echo $Category_Id;?>" />     
                            <div class="clearfix"></div>
                        </div>
                        </div>
                </div>
                 <div class="clearfix"></div>
                <!-- filter section ends here -->
                
                  <div class="form-group">
                   <div class="select_ajax_load"></div>
                   </div>
                  
                  <div class="block_content products_content">
                   
					   <?PHP
					  
					  
					$Prdidincart = array();
					$Pkdidincart = array();
					
					if( $this->session->userdata('lastcartItem')!='')
					{
						$cartitems = $this->session->userdata('lastcartItem'); //load the sessioncart items into the array
						
						
						foreach($cartitems as $val_arrays)
						{
							$Prdidincart[] = $val_arrays['ProductId'];
							$Pkdidincart[] = $val_arrays['PackageId'];
						}
					}
					   
					 ?>
                     
                       
                    <ul class="tm-carousel product_list" style="display:block;">
                    
                    <!--------------------------------------------------------------------------- 
                               Products List View Starts Here
                    ---------------------------------------------------------------------------->
                    <?PHP
					foreach($products->result() as $product)
					   {
						  
						  /* $id=(double)(($product->ProductId)*526825.24);
						$prd_encoded = base64_encode($id);
							*/
							$prd_encoded = base64_encode($product->ProductId);
						   ?>
                       
                      <li class="item last-item-of-mobile-line col-sm-4 allproducts"  id="PRD_<?PHP echo $product->ProductId; ?>" total_prdcts='<?PHP echo $totalProducts;?>'>
                        <div class="product-container">
						 <!-- <div class="product_brand_icon"><img src="resources/site/img/brands/mccain-logo.jpg" alt="" class="img-responsive" /></div>-->
                        
                          <div class="left-block">
                            <div class="product-image-container"> 
                            <a class="product_img_link" href="<?PHP echo base_url('product-view/').$prd_encoded."/".str_replace(" ","-",$product->ProductName); ?>" title="Nascetur ridiculus mus" itemprop="url"> 
                            <img class="replace-2x img-responsive" src="<?PHP echo $product->ProductImage;?>" alt="" title="" width="220" height="200" itemprop="image" /> 
                            </a> 
                            </div>
                          </div>
                          
                          <div class="right-block">
                          	<h5><a class="product-name" href="<?PHP echo base_url('product-view/').$prd_encoded."/".str_replace(" ","-",$product->ProductName); ?>" title=""> <b><?PHP echo  $product->BrandName."-".$product->ProductName;?></b> </a></h5>
<?PHP


$this->db->select('prd.ProductId,ms.MeasurementUnit, bs.Baseuom, pkg.Id as packageid, pkg.Price as ProductPrice, pkg.Netweight as NetWeight');
$this->db->from('products as prd');
$this->db->join('baseuom as bs','bs.baseid=prd.BaseUOM');
$this->db->join('measurements as ms','ms.MeasurementId=prd.MeasurementUnit');
$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
$this->db->where('prd.ProductName',$product->ProductName);
$this->db->where('prd.BrandId',$product->BrandId);
$this->db->where('pkg.ProductId',$product->ProductId);
$this->db->order_by('pkg.Id','DESC');
$pkgng_types = $this->db->get('');


if($pkgng_types->num_rows()>1)
{


?>
<div class="form-group">
<select class="form-control pkgtypes" pdk_id="<?PHP echo $product->ProductId;?>"> 
<?PHP
$cnt=0;
	foreach($pkgng_types->result() as $pkgtype)
	{
		if($cnt==0)
		{
			$packageId = $pkgtype->packageid;
			$packageIde = $packageId;
		}
		$cnt++;
?>
	<option value="<?PHP echo $pkgtype->ProductId."_".$pkgtype->packageid; ?>"><?PHP echo $pkgtype->NetWeight." ".$pkgtype->MeasurementUnit."-Rs ".$pkgtype->ProductPrice; ?> </option>

<?PHP
	}
?>
</select>
</div>
<?PHP
}
else
{
	

$ProductId = $product->ProductId;
foreach($pkgng_types->result() as $pkgtype)
	{
		$packageIde = "_".$pkgtype->packageid;
		$packageId = $pkgtype->packageid;
?>
<p><a class="product-name" href="<?php echo base_url('product-view'); ?>" title=""><i class="fa fa-inr" aria-hidden="true"></i>  <?PHP echo $pkgtype->ProductPrice;?>/<?PHP echo $pkgtype->NetWeight.$pkgtype->MeasurementUnit;?></a></p>
                           
<?PHP 
	}
} //else ends here
?>
 <span class="btn btn-default product_view" id="<?PHP echo $product->ProductId;?>" data-toggle="modal" data-target="#myModal" ><i class="fa fa-search-plus" aria-hidden="true"></i></span>
					
                            <?PHP
							if(in_array($product->ProductId,$Prdidincart))
							{
								if(in_array($packageId,$Pkdidincart))
								{
							?>
                           			  <span class="btn btn-default add-to-cart">
                                      <a class="addedtocart" style="color:red"  >In Cart</a>
                                      </span>
                            <?PHP
								}
									else
									{
									?>
							
                             <span class="btn btn-default add-to-cart">
                             <a class="addtocart" id="<?PHP echo $product->ProductId.$packageIde;?>"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
                             </span>
									<?PHP 
									}
									
							}
							else
							{
							?>
                            
                            <span class="btn btn-default add-to-cart">
                            <a class="addtocart" id="<?PHP echo $product->ProductId.$packageIde;?>"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
                            </span>
                            <?PHP 
							}
							?>
                           
                            
                          </div>
                        </div>
                      </li>
                      
                    <!--------------------------------------------------------------------------- 
                               Products List View Ends Here
                    ---------------------------------------------------------------------------->
                      
                      
                      
                      
                      
                      <?PHP 

					   }//foreach ends here 
					?>                      
                      
                      
                    </ul>
                    
                     <?PHP
				   			
					if($totalProducts>15  )
					{
						
						$page=1;
						$perPage = 15;
						$totalPages = ceil($totalProducts/$perPage);
						$startAt = $perPage * ($page-1);
						$links='';

						if($page<=$totalPages)
						{
						$prev=$page-1;
						
						if($prev<=0)
						{
						$prev=1;
						}
						
						$links=$links."<a class='getdata_click active' id='".$page."'>$page</a>"; // previous page link 
						
						//preparing the remaining pages
						
						//for ($i = $page-5; $i<20+$page-5; $i++) 
						for ($i = $page-2; $i<5+$page-2; $i++)
						{
						
							if($i>0 && $i<=$totalPages)
							{
								$links .= ($i != $page ) ? "<a class='getdata_click' id='".$i."'> $i</a> " : "";
							}
							
							}
				}

						//next pages
						
				
				if($page<$totalPages)
				{
					$next=$page+1;
					
					if($next<0)
					{
					$next=1;
					}
					$links=$links."<a class='getdata_click' id='".$next."'>&raquo;</a>";
				
				}
				
				else
				{
					$next=$page+1;
					
					if($next>$totalPages)
					{
					$next=$totalPages;
					}
					$links=$links."<a class='getdata_click' id='".$next."'>&raquo;</a>";
				}
				
				
				//$links=$links."<a class='getdata_click' id='".$totalPages."'>Last</a>";
						
						?>
                         <div class="clearfix"> </div>
                        <div class="pagination">
 							<?PHP echo $links;?>
                        </div>
                        <?PHP						
					
					}
				   ?>
                    
                    
                    
                      <div style="display: inline-block; position: relative;  width: 50px; height: 50px; margin: 10px;  overflow: hidden; float: left; ">
                 	<div class="ajax_load" ></div>
                 </div>
					<?PHP
					}else
					{
					?>
                    <div class="alert alert-danger">No Products Found</div>
                    <?PHP
					}
					?>
                  </div>
                </div>
                
                </div>
                
              </div>
            
<!--------------------------------------------------------------------------- 
			Display product by brands view in brandproduct page
---------------------------------------------------------------------------->


<!--------------------------------------------------------------------------- 
	Main container Code ends Here and starts in menu page
---------------------------------------------------------------------------->    
		 </div>
          
        </div>
      </div>
    </div>
  </div>
              
<!--------------------------------------------------------------------------- 
		Product view popup in brands product page
---------------------------------------------------------------------------->
		<div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title popup_titl"></h4>
                  </div>
                  <div class="modal-body product-view">
                    <div class="col-sm-6 popup_img">
                    </div>
                    
                    <div class="col-sm-6">
                    	<h4 class="product-heading popup_heading"></h4>
                        
                        <p></p>
                        
                        
                        <div class="product-prize">
                        
                        <p>
                            <span class="title">Net Weight</span> <span class="cost netweight"></span>
                            </p>
                            <p>
                            <span class="title">Gross Weight</span> <span class="cost grossweight"></span>
                            </p>
                           <p>
                            <span class="title">Package Type</span> <span class="cost pkgtype"></span>
                            </p>
                            <p class="radytoeat_yes">
                            <span class="title ">Ready To</span> <span class="cost radytoeat"></span>
                            </p>
	                        <p><span class="title">Price</span> <span class="cost price"></span></p>
                        </div>
                        
                        <div class="product-quantity-colm">
                              <span class="title_label">Quantity</span>
                              <div class="col-sm-6 product-details prod-quty">
                                <span class="decrs_qty" prdid=''><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
                                <span class="qty_val">1</span>
                                <span class="incrs_qty" prdid=''><i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                              </div>
                        <div class="clearfix"></div>
                        </div>
                        
                        <div class="product-add-cart">
                        
                        	<button type="button" class="btn btn-info addtocart" id="">Add to Cart</button>
                        	<a href="<?PHP echo base_url('cart-view');?>" class="btn btn-success">View Cart</a>
                        </div>
                    </div>
                    
                    
                  
                </div>
            
              </div>
            </div>
		</div>

<!--------------------------------------------------------------------------- 
			Product view popup in brands product page
---------------------------------------------------------------------------->

