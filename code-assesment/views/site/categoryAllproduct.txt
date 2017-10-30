<?PHP
/*
$docroot = $_SERVER['DOCUMENT_ROOT'];
if(unlink($docroot.'/ecom-food/chk.php'))
{
	echo "<pre>";
print_r($_SERVER); exit; 
}
*/?>
<!--------------------------------------------------------------------------- 
			Display product by brands view in brandproduct page
---------------------------------------------------------------------------->
  
            <div id="center_column" class="center_column col-xs-12 col-sm-12 col-md-9">
              <div class="clearfix"> </div>
                <div id="featured-products_block_center" class="block products_block clearfix">
              	
                <div class="col-sm-12 col-xs-12 breadcrumb_colm">
                	<ol class="breadcrumb">
                        <li><a href="<?PHP echo base_url();?>">Home</a></li>
                        <li class="active"><?PHP echo $this->uri->segment(2);?></li>
                        
                      </ol>
                </div>
                 <div class="clearfix"> </div>
	             <!-- filter section-->
				<?PHP
                if($prddetails->num_rows()>0)
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
							if($subcatide!='0')//check whether it had subcategories or not if so then filter will be displayed for the user
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
							if($prdnames->num_rows()>0) //this is for the product filter 
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
							if($type!='0') // if the category has any types then this section will be viewable
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
							if($frozen!='0') // if the category is frozen then this filter will be viewable
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
                             <input type="hidden"  class="form-control"  id="categID" value="<?PHP echo $catid;?>" />
                            <div class="clearfix"></div>
                        </div>
                        
                 		</div>
                </div>
                
                <!-- filter section ends here -->
                   <div class="clearfix"></div>
                   <div class="form-group">
                   <div class="select_ajax_load"></div>
                   </div>
				   
				   
                  <div class="block_content products_content">
            
                <?PHP

					//this section is for checking whether any product is in the cart or not
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
				foreach($prddetails->result() as $prdct) //loopin the products goes here
				{
					//$id=(double)(($prdct->ProductId)*526825.24);
					$prd_encoded = base64_encode($prdct->ProductId);
				 ?>
                          
<!--

we had used total_prdcts attribute for the list item, and we used this in the script.js file 

-->                  
                      <li class="item last-item-of-mobile-line col-sm-4 allproducts"  id="PRD_<?PHP echo $prdct->ProductId; ?>" total_prdcts='<?PHP echo $totalProducts;?>'>
                        <div class="product-container">
						 <!-- <div class="product_brand_icon"><img src="resources/site/img/brands/mccain-logo.jpg" alt="" class="img-responsive" /></div>-->
                         
                          <div class="left-block">
                            <div class="product-image-container"> 
                            <a class="product_img_link" href="<?PHP echo base_url('product-view/').$prd_encoded."/".str_replace(" ","-",$prdct->ProductName); ?>" title="Nascetur ridiculus mus" itemprop="url"> 
                            <img class="replace-2x img-responsive" src="<?PHP echo $prdct->ProductImage?>" alt="" title="" width="220" height="200" itemprop="image" /> 
                            </a> 
                            </div>
                          </div>
                          
                          <div class="right-block">
                         
                          	<h5><a class="product-name" href="<?PHP echo base_url('product-view/').$prd_encoded."/".str_replace(" ","-",$prdct->ProductName); ?>" title=""><b><?PHP echo $prdct->BrandName."-".$prdct->ProductName?></b></a></h5>

<?PHP


///this section is for checking whether the product had any packaging types 

//get the available packin types

$this->db->select('prd.ProductId,ms.MeasurementUnit, bs.Baseuom,pkg.Id as packageid, pkg.Price as ProductPrice, pkg.Netweight as NetWeight');
$this->db->from('products as prd');
$this->db->join('baseuom as bs','bs.baseid=prd.BaseUOM');
$this->db->join('measurements as ms','ms.MeasurementId=prd.MeasurementUnit');
$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
$this->db->where('prd.ProductName',$prdct->ProductName);
$this->db->where('prd.BrandId',$prdct->BrandId);
$this->db->where('pkg.ProductId',$prdct->ProductId);
$this->db->order_by('pkg.Id','DESC');
$pkgng_types = $this->db->get('');

#echo $this->db->last_query(); exit;

if($pkgng_types->num_rows()>1)
{

?>  
<div class="form-group">
	
<select class="form-control pkgtypes" pdk_id="<?PHP echo $prdct->packageid;?>"> 
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
//echo $pkgtype->packageid;

}
else
{
	foreach($pkgng_types->result() as $pkgtype)
	{
		$packageIde = "_".$pkgtype->packageid;
		$packageId = $pkgtype->packageid;
	?>
 <p><a class="product-name" href="<?PHP echo base_url('product-view/').$prd_encoded."/".$prdct->ProductName; ?>" title=""><i class="fa fa-inr" aria-hidden="true"></i> <?PHP echo $pkgtype->ProductPrice?>/<?PHP echo $pkgtype->NetWeight?><?PHP echo $pkgtype->MeasurementUnit?></a></p>
<?PHP
	}
}
?>

<span class="btn btn-default product_view" id="<?PHP echo $prdct->ProductId;?>" data-toggle="modal" data-target="#myModal" ><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                            
                            <span class="btn btn-default add-to-cart ">
                            <?PHP
							//this section will check whether the product and the package is in the cart or not
							//if it's in the cart then we had shown the label as "In Cart"					
							//if not we had shown Add to cart button kind thing, for which we had taken id(productid is appended with n underscore and the package id ) so that we can send this to the Requestdispatcher controller for adding into the cart.
														
							if(in_array($prdct->ProductId,$Prdidincart))
							{
								if(in_array($packageId,$Pkdidincart))
								{
							?>
                           			 <a class="addedtocart" style="color:red"  >In Cart</a>
                            <?PHP
								}
									else
									{
									?>
							<a class="addtocart" id="<?PHP echo $prdct->ProductId.$packageIde;?>"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
									<?PHP 
									}
								
							}
							else
							{
							?>
                       		  <a class="addtocart" id="<?PHP echo $prdct->ProductId.$packageIde;?>"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
                            <?PHP 
							}
							?>
                            </span>
                          </div>
                        </div>
                      </li>
                      
                  <?PHP
				  
				}
				?>
                  
                  
                    <!--------------------------------------------------------------------------- 
                               Products List View Ends Here
                    ---------------------------------------------------------------------------->
              
                        <div class="clearfix"></div>
                    </ul>
                   <?PHP
				 //this section will create pagination depends on the total number of products in the category
				 //we had used ajax call for the pagination links
  			
					if($totalProducts>15  )
					{
						
						$page=1;
						$perPage = 15;
						$totalPages = ceil($totalProducts/$perPage);
						$startAt = $perPage * ($page-1); 
						$links='';
						
						//check whehter the current page is lessthan or equal to the total pages
						
						if($page<=$totalPages)
						{
							//creating the previous link
							$prev=$page-1;
						
							if($prev<=0)
							{
							$prev=1;
							}
						
						$links=$links."<a class='getdata_click active' id='".$page."'>$page</a>"; // previous page link 
						
						//preparing the remaining pages
						//this section i had used for the remaining links i had taken upto 5 links 
						for ($i = $page-2; $i<5+$page-2; $i++) 
						{
						
							if($i>0 && $i<=$totalPages)
							{
								$links .= ($i != $page ) ? "<a class='getdata_click' id='".$i."'> $i</a> " : "";
							}
							
							}
				}


		//this seciton is for next links in the pagnation
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
                        <div class="pagination" style="float:left">
 							<?PHP echo $links;?>
                        </div>
                        <?PHP						
					
					}
				   ?>
                    <div style="display: inline-block; position: relative;  width: 50px; height: 50px; margin: 10px;  overflow: hidden; float: left; ">
                 	<div class="ajax_load" ></div>
                 </div>
          <?PHP
			
				}
			else
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
                    <!--	<img src="resources/site/img/products/mccain/pdocut-view/frozen-foods-product-view.jpg" alt="" class="img-responsive" /> -->
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
                          <input type="hidden" id="ProductId" />
                        	<button type="button" class="btn btn-info addtocart" id="">Add to Cart</button>
                        	<a href="<?PHP echo base_url('cart-view');?>" class="btn btn-success">View Cart</a>
                        </div>
                    </div>
                    
                    <div class="clearfix"></div>
                  </div>
                  
                </div>
            
              </div>
            </div>
<!--------------------------------------------------------------------------- 
			Product view popup in brands product page
---------------------------------------------------------------------------->

