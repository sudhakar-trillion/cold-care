<?PHP
$cartitems = array();
$cartitems = $this->session->userdata('lastcartItem');
//echo "<pre>";
//print_r($cartitems); exit; 
$incart = array();
$product = '';

$total_amount_cart = 0;
$rowcnt=0;
?>

<!--------------------------------------------------------------------------- 
	Order Summery Starts Here
---------------------------------------------------------------------------->

            <div class="row" id="columns_inner">
           
            	<div class="col-sm-12">
                <div class="col-sm-12 col-xs-12 breadcrumb_colm">
                	<ol class="breadcrumb">
                        <li><a href="<?PHP echo base_url();?>">Home</a></li>
                         <li><a href="<?PHP echo base_url('cart-view');?>">View Cart</a></li>
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
                
               <?PHP echo $this->session->flashdata('AwaitingList'); ?>
                	<div class="col-sm-7 row">
                	<div class=" order-colm">
                        <h3 class="text-left">Order Summary</h3>
                        <?PHP
                        if(!empty($cartitems))
                        {
						?>
                        <div class="col-sm-12 order-heading hid_sm_colm">
                        	<div class="row">
                                <span class="col-sm-5 col_sm_row text-left">Product</span>
                                <span class="col-sm-4 col_sm_row text-left">Cost</span>
                                <span class="col-sm-3 col_sm_row text-right">Total Price</span>
                            </div>
                        </div>
                        
                        <div class="prod_order_details">
                      <?PHP
					// call the items from the database using the cartitems
					
						foreach($cartitems as $val_arrays)
							{
							$rowcnt++;
						//calling thedatabase for the product
						
						$this->db->select('mes.MeasurementUnit,bse.Baseuom as packagetype, prd.ProductName,b.BrandName, pkg.Price as ProductPrice, prd.ProductImage, pkg.Netweight as NetWeight, pkg.Grossweight as GrossWeight,prd.ReadyTo, prd.BaseUOM');
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
							$ProductPrice = ($product->ProductPrice)*($val_arrays['Quantity']); 
							$MeasurementUnit = $product->MeasurementUnit;
							$total_amount_cart = $total_amount_cart+$ProductPrice;
							$BrandName = $product->BrandName;
							
						}
						
						$quantity = $val_arrays['Quantity'];
						?>
                        <div class="col-sm-12 order-body">
                            <div class="row">
                                <div class="col-sm-5 col_sm_row">
                                	<span class="visible-xs chek_sm_label">Product </span>
                                    <span class="oder_prod"><?PHP echo $BrandName."-".$ProductName; ?></span>
                                    <span class="order_prod_qty"><?PHP echo $quantity;?></span>
                                </div>
                                <div class="col-sm-4 col_sm_row">
                                	<span class="visible-xs chek_sm_label">Cost </span>
                                	<span><i class="fa fa-inr" aria-hidden="true"></i> <?PHP echo $ProductPrice/$quantity."/".$GrossWeight." ".$MeasurementUnit; ?></span>
                                </div>
                                <div class="col-sm-3 col_sm_row text-right">
                                    <span class="visible-xs chek_sm_label">Total Price </span>
                                    <span><i class="fa fa-inr" aria-hidden="true"></i><?PHP echo $ProductPrice; ?></span>
                                </div>
                            </div>
                        </div>
                        <?PHP
						}
						?>
                        </div>
                        
                        
                        <div class="col-sm-12 order-footer">
                        	<div class="row">
                                <span class="col-sm-7 total_head text-left">Grand Total</span>
                                <span class="col-sm-5 total_price text-right"><b><i class="fa fa-inr" aria-hidden="true"></i><?PHP echo $total_amount_cart; ?></b></span>
                            </div>
                        </div>
                       <?PHP
					   }//if ends here
						else
						{
						?>
                        <h4 class="text-left">No items in the cart</h4>
                        <?PHP	
						}
						?>
                        
                        <div class="clearfix"></div>
                    </div>
                	<!--<div class="login-form">
                    	<h3 class="text-center">LOGIN</h3>
                    	<form method="post">
                        	<div class="form-group">
                            	<input type="text" class="form-control" name="userid" placeholder="UserId">
                            </div>
                            
                        	<div class="form-group">
                            	<input type="password" class="form-control" name="userid" placeholder="password">
                            </div>
                            
                        	<div class="form-group">
                            	<button type="button" class="btn btn-success login-btn">LOGIN</button>
                            </div>
                        </form>
                    </div>-->
                    </div>
<?PHP
//get the communication details

$this->db->where('SLNO',$this->session->userdata('userslno'));
$qry = $this->db->get('userdetails');
foreach($qry->result() as $details)
{


?>                    
                    <div class="address-colm col-sm-4">
                    	<h3 class="text-left">Delivery Address</h3>
                        <b><p>MS.<?PHP echo $details->Owner_Name?>,</p></b>
                        <p><span>Address 1 :</span><?PHP echo $details->Address;?></p>
                        <p><span>Location :</span> <?PHP echo $details->Location;?></p>

<?PHP

}
if(!empty($cartitems))
{

?> 
<div style="display:inline-block;position:relative;float:right">
    <div class="ajax_load" ></div>
    <button type="button" class="btn btn-success order-confirm ">Confirm Order</button>
	<div class="clearfix"></div>
</div>
<?PHP
}
?>
	<div class="clearfix"></div>
                    </div>
                    
                  	<div class="clearfix"></div>
                </div>
            </div>

<!--------------------------------------------------------------------------- 
	Order Summery Starts Here
---------------------------------------------------------------------------->

            
<!--------------------------------------------------------------------------- 
	Main container Code ends Here and starts in menu page
---------------------------------------------------------------------------->
			 </div>
          
        </div>
      </div>
    </div>
  </div>
              