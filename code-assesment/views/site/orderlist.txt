          <!--- center column starts here --->
            <div id="center_column" class="center_column col-xs-12 col-sm-12">
            
            <div class="col-sm-12 col-xs-12 breadcrumb_colm">
                	<ol class="breadcrumb">
                        <li><a href="<?PHP echo base_url();?>">Home</a></li>
                        
                         <li><a href="<?PHP echo base_url('cart-view');?>">View Cart</a></li>
                        <li class="active">
						<?PHP 
							echo "Total Orders (".$orderlist->num_rows().")";
						
						?>  
                        </li>        
                      </ol>
                </div>
                <div class="clearfix"></div>
            
                  <div class="clearfix">
                   <!-- 	<h2 class="cart-page-title">My Orders</h2>-->
                        
                        
                        
                        <div class="col-sm-12 hidden-xs mediumdeviceCart">
                        	
						
                        <?PHP
						if($orderlist->num_rows()>0)
						{
							?>
                            <div class="row">
                            	<div class="col-sm-2 cart-heading">Order Id</div>
                                <div class="col-sm-2 cart-heading">Store Name</div>
                                <div class="col-sm-2 cart-heading">Quantity</div>
                                <div class="col-sm-2 cart-heading">Order Status</div>
                                <div class="col-sm-2 cart-heading">Ordered On</div>                                
                                <div class="col-sm-2 cart-heading">Actions</div>
                            </div>
                            <?PHP
							foreach($orderlist->result() as $orders)
							{
							$OrderId = $orders->OrderId;
							$Owner_Name = $orders->Owner_Name;
							
							$TotalProducts = $orders->TotalProducts;
							$OrderStatus = $orders->OrderStatus;
							
							$OrderedOn = $orders->OrderedOn;
							
						?>
                        
                        <div class="row product-cart-row">
                            	<div class="col-sm-2 product-details">
                                    <span class="cart-product-title"><?PHP echo $OrderId;?></span>
                                </div>
                                
                                <div class="col-sm-2 product-details product-price">

                                	<span class="cost"><?PHP echo $Owner_Name;?></span>
                                </div>
                                
                                <div class="col-sm-2 product-details prod-quty">
	                                <p class="text-center"><?PHP echo $TotalProducts;?></p>
                                </div>
                                
                                <div class="col-sm-2 product-details">
                                 <span class="prod-ammount"><?PHP echo $OrderStatus;?></span>
                                 </div>
                                 
                                  <div class="col-sm-2 product-details">
                                 <span class="prod-ammount"><?PHP echo $OrderedOn;?></span>
                                 </div>
                                 
                                  <div class="col-sm-2 product-details">
                                  <?PHP
							$id=(double)(($OrderId)*526825.24);
							$orderId_encoded = base64_encode($id);
						  ?>
                                 <span class="prod-ammount"><a class="btn btn-success" href="<?PHP echo base_url('order-history')."/".$orderId_encoded;  ?>">View Order</a></span>
                                 </div>
                                 
                            </div>
                            
                            
                       
                       <?PHP
					    }
						}
						else
						{
							?>
                            <div class="alert alert-success">No order placed yet</div>
                            <?PHP	
						}
						?>    
                        
                        
                                                        
                        
                        
                        </div>
                                        
               
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
              