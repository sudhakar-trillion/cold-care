
<!--------------------------------------------------------------------------- 
	Product view code starts Here
---------------------------------------------------------------------------->


<?PHP

/*  Getting the product from the database */

	$this->db->select('mes.MeasurementUnit,bse.Baseuom as packagetype,b.BrandName,prd.Status, b.Status as brandstatus, prd.ProductName, prd.Type, pkg.Price as ProductPrice, prd.ProductImage, pkg.Netweight as NetWeight, pkg.Grossweight as GrossWeight,prd.ReadyTo, prd.BaseUOM, prd.ProductDesc');
	$this->db->from('products as prd');
	$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
	$this->db->join('baseuom as bse', 'bse.baseid=prd.BaseUOM');
	$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
	$this->db->join('brands as b','b.BrandId=prd.BrandId');
	$this->db->where('prd.ProductId',$ProductId);
	$this->db->where('pkg.Id',$packageid);
	$prddetails = $this->db->get('');

#echo $this->db->last_query();  exit; 
if( $prddetails->num_rows() > 0 )
{ 
	foreach($prddetails->result() as $prdct)
	{
		
	if($prdct->Status=='Inactive' || $prdct->brandstatus=='Inactive')
	{
		?>
    <div id="center_column" class="center_column col-xs-12 col-sm-12 col-md-9">
        <div class="alert alert-danger">Product you are trying to view is temporarliy not available </div>
        <div class="clearfix"> </div>
    </div>    
        <?PHP	
		
	}
	else
	{
?>
            <div id="center_column" class="center_column col-xs-12 col-sm-12 col-md-9">
              <div class="clearfix product-view">
                <div class="col-sm-6">
                    	<img src="<?PHP echo $prdct->ProductImage; ?>" alt="" class="img-responsive product-img" />
                    </div>

                    <div class="col-sm-6">
                    	<h4 class="product-heading"><?PHP echo $prdct->BrandName."-".$prdct->ProductName;?></h4>
                        
                        <div class="clearfix">
                        
                        <div class="product-prize">
                        
                        	<p>
                            <span class="title">Net Weight</span> <span class="cost"><?PHP echo $prdct->NetWeight.$prdct->MeasurementUnit;?></span>
                            </p>
                            <p>
                            <span class="title">Gross Weight</span> <span class="cost"><?PHP echo $prdct->GrossWeight.$prdct->MeasurementUnit;?></span>
                            </p>
                           <p>
                            <span class="title">Package Type</span> <span class="cost"><?PHP echo $prdct->packagetype;?></span>
                            </p>
                            <?PHP
							if($prdct->ReadyTo!='NA')
							{
							?>
                           <p>
                            <span class="title">Ready To</span> <span class="cost"><?PHP echo $prdct->ReadyTo;?></span>
                            </p>  
                        <?PHP } ?>
                        
                         <?PHP
							if($prdct->Type!='')
							{
							?>
                           <p>
                            <span class="title">Type</span> <span class="cost"><?PHP echo $prdct->Type;?></span>
                            </p>  
                        <?PHP } ?>      
	                        <p><span class="title">Price</span> 
                            <span class="cost">
                            		<i class="fa fa-inr" aria-hidden="true"></i> 
                                        <span class="prod-ammount">
                                            <?PHP echo $prdct->ProductPrice; ?>
                                        </span>
                                      /-</span></p>
                        </div>
                        
                        
                        
                        <div class="product-quantity-colm">
                        	  <!--<div class="input-group">
                                <span class="input-group-addon">Qty</span>
                                <input id="msg" type="text" class="form-control" name="msg" value="1">
                                <input type="hidden" id="ProductId"  />
                              </div>-->
                              <span class="title_label">Quantity</span>
                              <div class="col-sm-6 product-details prod-quty">
                                <span class="decrs_qty" prdid="<?PHP  echo $ProductId."_".$packageid;?>"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
                    <?PHP
					//loading the cartitems into the cartitems array
					
					$cartitems = $this->session->userdata('lastcartItem');
						
					$Prdidincart = array();
					$Pkdidincart = array();
					$quat=1;
						
					//getting the quantity for the product with the package id
						
					if(sizeof($cartitems)>0 && !empty($cartitems))
					 {
						foreach($cartitems as $key=>$val_arrays)
					  	{
							$Prdidincart[] = $val_arrays['ProductId'];
							$Pkdidincart[] = $val_arrays['PackageId'];
								
							if( $cartitems[$key]['ProductId']==$ProductId && $cartitems[$key]['PackageId']==$packageid )
						 	{
								$quat=$cartitems[$key]['Quantity'];
						 	}
								
						}
						
					}
					else
						$quat=1;
									
					?>
                    
                                <span class="qty_val"><?PHP echo $quat;?></span>
                                <span class="incrs_qty" prdid="<?PHP  echo $ProductId."_".$packageid;?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                              </div>
                        <div class="clearfix"></div>
                        </div>
                        
                        <div class="product-add-cart">
                        	
                    <?PHP
						$cartitems = $this->session->userdata('lastcartItem');
						$Prdidincart = array();
						$Pkdidincart = array();
						
						
						if(sizeof($cartitems)>0 && !empty($cartitems))
						{
							foreach($cartitems as $val_arrays)
							{
								$Prdidincart[] = $val_arrays['ProductId'];
								$Pkdidincart[] = $val_arrays['PackageId'];
								
							}
							//check whether the product with this package id is in the cart or not
							if(in_array($ProductId,$Prdidincart))
								{
									if( in_array($packageid,$Pkdidincart))
									{
										$indexAt = array_search($ProductId,$Prdidincart);
										?>
										<button type="button" class="btn btn-danger addedtocart" id="<?PHP echo $ProductId;?>">Added to Cart</button>
										<?PHP
									}
									else
									{
										?>
                                         <button type="button" class="btn btn-info addtocart" id="<?PHP echo $ProductId."_".$packageid;?>">Add to Cart</button>	
                                        <?PHP
									}
									
									
								}
							else
							{
							?>
							    <button type="button" class="btn btn-info addtocart" id="<?PHP echo $ProductId."_".$packageid;?>">Add to Cart</button>							
							<?PHP	
							}

						}
						else
						{
							?>
							    <button type="button" class="btn btn-info addtocart" id="<?PHP echo $ProductId;?>">Add to Cart</button>							
							<?PHP
						}
					?>
                    
                    <a href="<?PHP echo base_url('checkout'); ?>" type="button" class="btn btn-success">Checkout</a>
                        </div>
                		</div>
                </div>
                
              </div>
              
              <div class="col-sm-12">
                <div class="clearfix product-discription">
                	
                    <h4><?PHP echo $prdct->ProductName;?></h4>
                    
                    <p><?PHP echo $prdct->ProductDesc;?>
                    </p>
                	
                    
                </div>
              </div>
          <!--- center column starts here --->
          
          <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">McCain Potato Cheese Shotz</h4>
                  </div>
                  <div class="modal-body product-view">
                    
                    </div>
                    
                    <div class="clearfix"></div>
                  </div>
                  
                </div>
            
              </div>
            </div>
<?PHP
	}
	}
}
else
{
?>
<div id="center_column" class="center_column col-xs-12 col-sm-12 col-md-9">
        <div class="alert alert-danger">Product you are trying to view is not available </div>
        <div class="clearfix"> </div>
    </div>  

<?PHP	
}
	?>

<!--------------------------------------------------------------------------- 
	Product view code ends Here
---------------------------------------------------------------------------->            
            


<!--------------------------------------------------------------------------- 
	Main container Code ends Here and starts in menu page
---------------------------------------------------------------------------->    
		 </div>
          
        </div>
      </div>
    </div>
  </div>
              