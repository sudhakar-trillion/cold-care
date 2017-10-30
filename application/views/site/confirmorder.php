<?PHP
$total_amount_cart = 0;
$rowcnt=0;

?>
<!--------------------------------------------------------------------------- 
	Order Summery Starts Here
---------------------------------------------------------------------------->
<div class="row" id="columns_inner">
    <div class="col-sm-12">
        <div class=" order-colm row">
            
           
             <?PHP
            if($cartitems!='0')
            {
				
            ?>
             <h3 class="text-left">Order List</h3>
            <div class="col-sm-12 order-heading">
                <div class="row">
                    <span class="col-sm-6 text-left">Product</span>
                    <span class="col-sm-3 text-left">Cost</span>
                    <span class="col-sm-3 text-right">Total Price</span>
                </div>
            </div>
            
            <div class="prod_order_details">
          <?PHP
		/*
		echo "<pre>";
		print_r($cartitems->result());
		exit;
		*/
        foreach($cartitems->result() as $val_arrays)
            {
                $rowcnt++;
            //calling thedatabase for the product
            
            $this->db->select('mes.MeasurementUnit,bse.Baseuom as packagetype, prd.ProductName, pkg.Price as ProductPrice, prd.ProductImage, pkg.Netweight NetWeight, pkg.Grossweight GrossWeight,prd.ReadyTo, prd.BaseUOM');
            $this->db->from('products as prd');
            $this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
            $this->db->join('baseuom as bse', 'bse.baseid=prd.BaseUOM');
			$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
            $this->db->where('prd.ProductId',$val_arrays->Product);
			$this->db->where('pkg.Id',$val_arrays->PackageId);
            $prddetails = $this->db->get('');
			
           //echo $this->db->last_query(); exit;  
		   
            foreach($prddetails->result() as $product )
            {
                $ProductImage = $product->ProductImage;
                $ProductName = $product->ProductName;
                $GrossWeight  = $product->GrossWeight;
                $ProductPrice = ($product->ProductPrice)*($val_arrays->Quantity); 
                $MeasurementUnit = $product->MeasurementUnit;
                $total_amount_cart = $total_amount_cart+$ProductPrice;
                
            }
            
            $quantity = $val_arrays->Quantity;
            ?>
            <div class="col-sm-12 order-body">
                <div class="row">
                    <div class="col-sm-6 text-left">
                        <span class="oder_prod"><?PHP echo $ProductName; ?></span>
                        <span class="order_prod_qty"><?PHP echo $quantity;?></span>
                    </div>
                    <span class="col-sm-3 text-left"><i class="fa fa-inr" aria-hidden="true"></i> <?PHP echo $ProductPrice/$quantity."/".$GrossWeight." ".$MeasurementUnit;  ?></span>
                    <span class="col-sm-3 text-right"><i class="fa fa-inr" aria-hidden="true"></i><?PHP echo $ProductPrice; ?></span>
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
				if($this->session->flashdata('Appoved')!='')
				{
					echo $this->session->flashdata('Appoved');
				}
				else
				{
            ?>
    	       	 <div class="alert alert-danger">Order may be lost or may be already approved by you</div>
				<?PHP	
                }
		}
            ?>
            
            <div class="clearfix"></div>
        </div>
    </div>
</div>

 <?PHP
            if($cartitems!='0')
            {
           ?>
           
<div class="col-sm-12 terms-and-conditions">
	<h2>Terms & Conditions</h2>
	<p class="text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
   
		
                 <p><input type="checkbox" name="terms-cond" id="terms_cond" /> Accepting terms and conditions</p>
                <span style="color:red" class="err_msg" id="term_cond_error"></span>
    <input type="hidden" name="orderId" id="orderId" value="<?PHP echo $OrderId;?>" />
			
                <p>
            	<div style="display:inline-block;position:relative;">
                 <div class="ajax_load" ></div>
                    <a href="javascript:void(0)" class="btn btn-success confirmbtn">CONFIRM ORDER</a>
                 </div>
				</p>                
           
</div>
<?PHP
}
?>

<!--------------------------------------------------------------------------- 
	Main container Code ends Here and starts in menu page
---------------------------------------------------------------------------->
			 </div>
          
        </div>
      </div>
    </div>
  </div>