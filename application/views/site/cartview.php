<?PHP
$cartitems = array();

//locaing the cart items in the cartitems array

$cartitems = $this->session->userdata('lastcartItem');
//echo "<pre>";
//print_r($cartitems); exit; 
$incart = array();
$product = '';

$total_amount_cart = 0;
$rowcnt=0;
?>

          <!--- center column starts here --->
            <div id="center_column" class="center_column col-xs-12 col-sm-12 col-md-9">
            <div class="col-sm-12 col-xs-12 breadcrumb_colm">
                	<ol class="breadcrumb">
                        <li><a href="<?PHP echo base_url();?>">Home</a></li>
                        <li class="active">
						<?PHP 
						if( empty($cartitems))
						{
							echo "Shoping Cart (0 items)";
						}
						else
						{
							echo "Shoping Cart (".sizeof($cartitems);
							//.; 
							if(sizeof($cartitems)>1){ echo "Items"; }elseif(sizeof($cartitems)<=1){ echo "Item"; }
						}
						echo ")";
						?>  
                        </li>        
                      </ol>
                </div>
                <div class="clearfix"></div>
            
                  <div class="clearfix">
                 <?PHP
				 		if( empty($cartitems))
						{
						?>
                        <h2 class="cart-page-title">Shoping Cart (0 items)</h2>
                        <?PHP
						}
						else
						{
				 ?>
                    	  
                        <div class="col-sm-12 hidden-xs mediumdeviceCart">
                        	<div class="row">
                            	<div class="col-sm-5 cart-heading">Product Details</div>
                                
                                <div class="col-sm-3 cart-heading">Price</div>
                                
                                <div class="col-sm-2 cart-heading">Quantity</div>
                                
                                <div class="col-sm-2 cart-heading">Total Price</div>
                            </div>
			<?PHP
					// call the items from the database using the cartitems
					
					foreach($cartitems as $val_arrays)
						{
							$rowcnt++;
						//querying the database for the product
						
						$this->db->select('mes.MeasurementUnit,bse.Baseuom as packagetype,b.BrandName, prd.ProductName, pkg.Price as ProductPrice, prd.ProductImage, pkg.Netweight as NetWeight, pkg.Grossweight as GrossWeight,prd.ReadyTo, prd.BaseUOM');
						$this->db->from('products as prd');
						$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
						$this->db->join('baseuom as bse', 'bse.baseid=prd.BaseUOM');
						$this->db->join('brands as b','b.BrandId=prd.BrandId');
						$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
						$this->db->where('prd.ProductId',$val_arrays['ProductId']);
						$this->db->where('pkg.Id',$val_arrays['PackageId']);
						$prddetails = $this->db->get('');
						
						foreach($prddetails->result() as $product )
						{
							$ProductImage = $product->ProductImage;
							$ProductName = $product->ProductName;
							$GrossWeight  = $product->GrossWeight;
							$SingleproductCost =  $product->ProductPrice;
							$ProductPrice = ($product->ProductPrice)*($val_arrays['Quantity']); 
							
							$MeasurementUnit = $product->MeasurementUnit;
							$total_amount_cart = $total_amount_cart+$ProductPrice;
							$BrandName = $product->BrandName;
							
						}
						
						$quantity = $val_arrays['Quantity'];

						?>
                        <div class="row product-cart-row row_<?PHP echo $rowcnt;?>">
                            	<div class="col-sm-5 product-thumb">
                                	<img src="<?PHP echo $ProductImage?>" class="img-responsive cart-thumb">
                                    <span class="cart-product-title"><?PHP echo $BrandName."-".ucwords(str_replace("-"," ",$ProductName));?></span>
                                    <span class="cart-product-cancel" delPrd="<?PHP echo $val_arrays['ProductId']."_".$val_arrays['PackageId']; ?>" id="row_<?PHP echo $rowcnt;?>"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                                </div>
                                
                                <div class="col-sm-3 product-details product-price"><i class="fa fa-inr" aria-hidden="true"></i> <span class="cost"><?PHP echo $SingleproductCost; ?></span>/<?PHP echo $GrossWeight.$MeasurementUnit;?></div>
                                
                                <div class="col-sm-2 product-details prod-quty">
                                <span class="decrs_qty" prdid="<?PHP echo $val_arrays['ProductId']."_".$val_arrays['PackageId']; ?>"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
                                <span class="qty_val"><?PHP echo $quantity;?></span>
                                <span class="incrs_qty" prdid="<?PHP echo $val_arrays['ProductId']."_".$val_arrays['PackageId']; ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                                </div>
                                
                                <div class="col-sm-2 product-details"><i class="fa fa-inr" aria-hidden="true"></i>  <span class="prod-ammount"><?PHP echo $ProductPrice; ?></span>/-</div>
                            </div>
                        <?PHP
					}
            
            ?>
                            
  <div class="row product-cart-row">
                            	<div class="">
                                	<div class="col-sm-7"></div>
                                    
                                	<div class="col-sm-5 text-right">
                                    	<b>Total Ammount : <i class="fa fa-inr" aria-hidden="true"></i><span class="total-price"><?PHP echo $total_amount_cart;?></span>/-</b>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="continue-cart-colm">
                            	<a href="<?php echo base_url('checkout') ?>" class="btn btn-success pull-right cart-btn">Proceed to Checkout</a>
                            	<a href="<?PHP echo base_url();?>" class="btn btn-warning pull-right cart-btn continue_shop">Continue Shopping</a>
                                <button type="button" class="btn btn-danger pull-right cart-btn clear_cart">Clear Cart</button>
                            </div>
                            
                        </div>
                        
                        <!--
                        this section if for the smaller devices
                        -->
                        
                        <div class="visible-xs smalldeviceCart">
                        	
                                                        <?PHP
					// call the items from the database using the cartitems
					$total_amount_cart=0;
					foreach($cartitems as $val_arrays)
						{
						
						//calling thedatabase for the product
						
						$this->db->select('mes.MeasurementUnit,bse.Baseuom as packagetype,b.BrandName, prd.ProductName, pkg.Price as ProductPrice, prd.ProductImage, pkg.Netweight as NetWeight, prd.Grossweight as GrossWeight,prd.ReadyTo, prd.BaseUOM');
						$this->db->from('products as prd');
						$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
						$this->db->join('baseuom as bse', 'bse.baseid=prd.BaseUOM');
						$this->db->join('brands as b','b.BrandId=prd.BrandId');
						$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
						$this->db->where('prd.ProductId',$val_arrays['ProductId']);
						$this->db->where('pkg.Id',$val_arrays['PackageId']);
						$prddetails = $this->db->get('');
						
						
						
						
						foreach($prddetails->result() as $product )
						{
							$ProductImage = $product->ProductImage;
							$ProductName = $product->ProductName;
							$GrossWeight  = $product->GrossWeight;
							$SingleproductCost =  $product->ProductPrice;
							$ProductPrice = ($product->ProductPrice)*($val_arrays['Quantity']); 
							$MeasurementUnit = $product->MeasurementUnit;
							$total_amount_cart = $total_amount_cart+$ProductPrice;
							
						}
						
						$quantity = $val_arrays['Quantity'];
						
						?>
                            
                            <div class="product-cart-row product-view">
                            	<div class="col-sm-5 col-xs-12 product-thumb">
                                	<img src="<?PHP echo $ProductImage;?>" class="img-responsive cart-thumb">
                                    <span class="cart-product-cancel"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                                </div>
                                
                                <!--<div class="col-sm-6">
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
                                    <a href="<?PHP #echo base_url('cart-view');?>" class="btn btn-success">View Cart</a>
                                </div>
                            </div>-->
                                
                                <div class="col-sm-7 col-xs-12">
                                <h4 class="product-heading popup_heading"><?PHP echo ucwords(str_replace("-"," ",$ProductName));?></h4>
                                 <div class="product-prize">
                                 	<!--<div class="col-sm-3 col-xs-12 product-details"><span class="cart-product-title"><?PHP //echo ucwords(str_replace("-"," ",$ProductName));?></span></div>-->
                                    
                                    <p>
                                    	<span class="title">Price</span> 
                                        <span class="cost netweight">
                                        <i class="fa fa-inr" aria-hidden="true"></i> <?PHP echo $SingleproductCost; ?> /<?PHP echo $GrossWeight.$MeasurementUnit;?>
                                        </span>
                                    </p>
                                    
                                    <div class="product-quantity-colm">
                                          <span class="title_label">Quantity</span>
                                          <div class="product-details prod-quty">
                                            <span class="decrs_qty" prdid='<?PHP echo $val_arrays['ProductId']."_".$val_arrays['PackageId']; ?>'><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
                                            <span class="qty_val"><?PHP echo $quantity;?></span>
                                            <span class="incrs_qty" prdid='<?PHP echo $val_arrays['ProductId']."_".$val_arrays['PackageId']; ?>'><i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                                          </div>
                                    <div class="clearfix"></div>
                                    </div>
                                    
                                    <p>
                                        <span class="title">Total Price</span> 
                                        <span class="cost price prod-ammount"><?PHP echo $ProductPrice; ?>/-</span>
                                    </p>
                                    
                                    <!--<div class="col-sm-3 col-xs-12 product-details product-price"><i class="fa fa-inr" aria-hidden="true"></i> <span class="cost"><?PHP //echo $SingleproductCost; ?></span>/<?PHP //echo $GrossWeight.$MeasurementUnit;?></div>-->
                                    
                                    <!--<div class="col-sm-2 col-xs-12 product-details prod-quty">
                                    <span class="decrs_qty" prdid="<?PHP #echo $val_arrays['ProductId']; ?>"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
                                    <span class="qty_val"><?PHP #echo $quantity;?></span>
                                    <span class="incrs_qty" prdid="<?PHP #echo $val_arrays['ProductId']; ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                                    </div>-->
                                    
                                    
                                    
                                    <!--<div class="col-sm-2 col-xs-12 product-details text-center"><i class="fa fa-inr" aria-hidden="true"></i>  <span class="prod-ammount"><?PHP #echo $ProductPrice; ?></span>/-</div>-->
                                 </div>
                                </div>
                            </div>
                            
                        <?PHP } ?>                                
                            
                            <div class="clearfix"></div>
                            <div class="row cart-total-price">
                            	<div class="">
                                    
                                	<div class="col-xs-12 text-right">
                                    	<b>Total Ammount : <i class="fa fa-inr" aria-hidden="true"></i> <span class="total-price"><?PHP echo $total_amount_cart;?></span>/-</b>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="continue-cart-colm">
                            	<a href="<?php echo base_url('checkout') ?>" class="btn btn-success pull-right cart-btn">Proceed to Checkout</a>
                            	<a href="<?PHP echo base_url();?>" class="btn btn-warning pull-right cart-btn continue_shop">Continue Shopping</a>
                                <button type="button" class="btn btn-danger pull-right cart-btn clear_cart">Clear Cart</button>
                            </div>
                            
                        </div>
                        <!--
                        this section if for the smaller devices ends here
                        -->

                 
               <?PHP
				} //if cart is not empty 
				?>
                  </div>
             </div>
          <!--- center column starts here --->
            </div>
            
            
            
 </div>
          
        </div>
      </div>
    </div>
  </div>
              