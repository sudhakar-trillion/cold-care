<?PHP
$incart = array();
$product = '';

$total_amount_cart = 0;
$rowcnt=0;
?>

          <!--- center column starts here --->
            <div id="center_column" class="center_column col-xs-12 col-sm-12">
            <div class="col-sm-12 col-xs-12 breadcrumb_colm">
                	<ol class="breadcrumb">
                        <li><a href="<?PHP echo base_url();?>">Home</a></li>
                         <li><a href="<?PHP echo base_url('order-list');?>">Orders List</a></li>
                        <li class="active">
						<?PHP 
						$url_id=base64_decode($this->uri->segment(2));
						$orderid = (double)$url_id/526825.24;
						if(!empty($cartitems))
								echo sizeof($cartitems). " Products In Order# ".$orderid;
						else
							{
								redirect(base_url());
							}
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
                      <!--  <h2 class="cart-page-title">Products in the order (Order #)<?PHP echo $orderid; ?></h2>-->
                        <?PHP
						}
						else
						{
				 ?>
                    	<!--<h2 class="cart-page-title">Products in the order (Order #)<?PHP echo $orderid; ?></h2>-->
                        
                        <div class="col-sm-12 hidden-xs mediumdeviceCart">
                        	<div class="row">
                            	<div class="col-sm-2 cart-heading">Order Id</div>
                                
                                <div class="col-sm-2 cart-heading">Product Name</div>
                                
                                <div class="col-sm-2 cart-heading">Price</div>
                                
                                <div class="col-sm-2 cart-heading">Quantity</div>
                                
                                <div class="col-sm-2 cart-heading">Total Price</div>
                                 <div class="col-sm-2 cart-heading">Order Status</div>
                            </div>
			<?PHP
					// call the items from the database using the cartitems
				
				/*	echo "<pre>";
					print_r($cartitems);
					echo "</pre>";*/
					
					foreach($cartitems as $val_arrays)
						{
							$rowcnt++;
						//calling thedatabase for the product
						
						$this->db->select('mes.MeasurementUnit,bse.Baseuom as packagetype, prd.ProductName, pkg.Price as ProductPrice, prd.ProductImage, pkg.Netweight as NetWeight, pkg.Grossweight as GrossWeight,prd.ReadyTo, prd.BaseUOM');
						$this->db->from('products as prd');
						$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
						$this->db->join('baseuom as bse', 'bse.baseid=prd.BaseUOM');
						$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
						$this->db->where('prd.ProductId',$val_arrays['ProductId']);
						$this->db->where('pkg.Id',$val_arrays['PackageId']);
						
						$prddetails = $this->db->get('');
						
						foreach($prddetails->result() as $product )
						{
							$ProductImage = $product->ProductImage;
							$ProductName = $product->ProductName;
							$GrossWeight  = $product->GrossWeight;
							$ProductPrice = ($product->ProductPrice)*($val_arrays['Quantity']); 
							$MeasurementUnit = $product->MeasurementUnit;
							$total_amount_cart = $total_amount_cart+$ProductPrice;
							
						}
						
						$quantity = $val_arrays['Quantity'];
						
						
						$url_id=base64_decode($this->uri->segment(2));
						$orderid = (double)$url_id/526825.24;
						
						//get the order status
						
						
						?>
                        
                        
                        <div class="row product-cart-row row_<?PHP echo $rowcnt;?>">
                            	
                                <div class="col-sm-2 product-details">
                                	
                                    <span class="cart-product-title"><?PHP echo $orderid;?></span>
                                </div>
                                
                                <div class="col-sm-2 product-thumb">
                                	
                                    <span class="cart-product-title"><?PHP echo ucwords(str_replace("-"," ",$ProductName));?></span>
                                </div>
                                
                                <div class="col-sm-2 product-details product-price"><i class="fa fa-inr" aria-hidden="true"></i> <span class="cost"><?PHP echo $ProductPrice; ?></span>/<?PHP echo $GrossWeight.$MeasurementUnit;?></div>
                                
                                <div class="col-sm-2 product-details prod-quty">
                                
                                <p class="text-center"><?PHP echo $quantity;?></p>
                                
                                </div>
                                
                                <div class="col-sm-2 product-details"><i class="fa fa-inr" aria-hidden="true"></i>  <span class="prod-ammount"><?PHP echo $ProductPrice; ?></span>/-</div>
                                
                                
                                
                                <div class="col-sm-2 product-details"><span class="prod-ammount"><?PHP echo $OrderStatus; ?></span></div>
                            </div>
                        <?PHP
					}
            
            ?>
                            
  <div class="row product-cart-row">
                            	<div class="">
                                	<div class="col-sm-7"></div>
                                    
                                	<div class="col-sm-3 ">
                                    	<b>Total Ammount : <i class="fa fa-inr" aria-hidden="true"></i><span class="total-price"><?PHP echo $total_amount_cart;?></span>/-</b>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            
                        </div>
                        
                        
                        
                 
               <?PHP
				} //if cart is not empty 
				?>
                  </div>
               <div class="clearfix"></div>
             </div>
          <!--- center column starts here --->
          <div class="clearfix"></div>
            </div>
            
            
            
 </div>
          
        </div>
      </div>
    </div>
  </div>
              