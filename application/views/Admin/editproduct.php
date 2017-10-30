<?PHP
/*
echo "<pre>";
print_r($product->result());
exit;

*/
?>
<div id="content">
  <div id="content-header">
    
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a class="anchor_feel">Manage Products</a> <a href="<?PHP echo base_url('admin-add-product'); ?>">Add product</a><a href="<?PHP echo base_url('admin-view-products'); ?>">View Products</a> <a href="#" class="current">Edit Product</a> </div>
    
    
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Product</h5>
          </div>
          
          <!-- tabs code starts here -->
          <ul class="nav nav-tabs" style="margin-top:10px">
            <li class="<?PHP if( $this->session->flashdata('checkProductImg')==""){ echo "active"; } ?>"><a data-toggle="tab" href="#edit_details">Edit details</a></li>
            <li class="<?PHP if( $this->session->flashdata('checkProductImg')!=""){ echo "active"; } ?>"><a data-toggle="tab" href="#edit_img">Edit image</a></li>
          </ul>
          
          
          <!-- tabs container starts here -->
          <div class="tab-content">
          
          <!-- edit_details starts here -->
          
          
		  <div class="widget-content nopadding tab-pane fade <?PHP if( $this->session->flashdata('checkProductImg')==""){ echo "in active"; } ?>" id="edit_details">
          <?PHP echo $this->session->flashdata('add_product_status');?>
        	
            <?PHP
				//store the product details 
				
				foreach( $product->result() as $prdct)
				{
					$ProductId = $prdct->ProductId;
					$BrandId =  $prdct->BrandId;
					$Category_Id = $prdct->Category_Id;
					$Sub_CatId = $prdct->Sub_CatId;
					
					
					$ProductName = $prdct->ProductName;
					$ProductDesc = $prdct->ProductDesc;
					$MeasurementUnit = $prdct->MeasurementUnit;
					$ReadyTo = $prdct->ReadyTo;	
					$Type = $prdct->Type;	
					$BaseUOM = $prdct->BaseUOM;
					$prdstatus = $prdct->Status;
				}
				
              
             ?>
          
            <form class="form-horizontal" method="post" action="" name="add_product" id="edit_product_details"  novalidate="novalidate" enctype="multipart/form-data" autocomplete='off'>
              
            <div class="control-group">
                
                <label class="control-label">Select Brand</label>
                <div class="controls">
                <select name="brand" id="brand">
                <?PHP if( sizeof($brand_data)>0) { 
                $brnd_cnt=0;
                foreach($brand_data->result() as $brands)
                    {
                        if($brnd_cnt==0)
                        {
                            ?>
                                <option value="0" <?PHP if($BrandId=="0"){ echo 'selected'; } ?>>Select Brand</option>
                                <option value="<?PHP echo $brands->BrandId;?>" <?PHP if($BrandId==$brands->BrandId){ echo 'selected'; } ?>><?PHP echo $brands->BrandName;?></option>
                            <?PHP
                        }
                        else
                        {
                        ?>
                            <option value="<?PHP echo $brands->BrandId;?>" <?PHP if($BrandId==$brands->BrandId){ echo 'selected'; } ?> ><?PHP echo $brands->BrandName;?></option>
                        <?PHP
                            
                        }
                    $brnd_cnt++;
                    }
                }
                else
                {
                    
                }
                ?>
                </select>
                <span class="err_msg brnd_error"></span>
                </div>

            </div>
                
                <div class="control-group">
                <label class="control-label">Select Category</label>
                <div class="controls">
                   
                  <select name="category" id="category">
                 <?PHP
                      if($this->input->post('Add_Product_Btn') && $this->input->post('brand')!='0' )
                        {   
                                //$BrandId = $this->input->post('brand');
                               // $this->db->where("BrandId",$BrandId);
                                $categs = $this->db->get('categories');
                                if($this->input->post('category')!='0')
                                $category_sel = $this->input->post('category');
                                else
                                    $category_sel = "0";
                            if($categs->num_rows()>0)
                            {
								$cat_cnt=0;
                                foreach($categs->result() as $cat)
                                {
									if($cat_cnt==0)
									{
									?>
                                    <option value=0>Select category</option>
                                    <?PHP	
									}
									
                                    ?>
                      <option value="<?PHP echo $cat->CategoryID?>" <?PHP if($cat->CategoryID==$category_sel){ echo 'selected="selected"';  }?>  ><?PHP echo $cat->Category_Name?></option>
                                    <?PHP
									$cat_cnt++;
                                }
                            }
                                
                          
                        }
						else
						{
							?>
                             <option value=0>Select category</option>
                            <?PHP	
							
							$categs = $this->db->get('categories');
							foreach($categs->result() as $catego)
							{
								?>
                                <option value="<?PHP echo $catego->CategoryID; ?>" <?PHP if($Category_Id == $catego->CategoryID) { echo "selected"; }?>><?PHP echo $catego->Category_Name; ?> </option>
                                <?PHP	
							}
						}
                      ?>
                    </select>
                <span class="err_msg category_err"></span>
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Select SubCategory</label>
                <div class="controls">
                  <select name="subcategory" id="subcategory" class="subcategorie">
                 <?PHP
                     if($this->input->post('Add_Product_Btn') && $this->input->post('category')!='0' && $this->input->post('brand')!='0')
                        {
							   
								$sub_cond = array();
								
								$sub_cond['CategId'] = $this->input->post('category');
								//$sub_cond['BrandId'] = $this->input->post('brand');
								
                                $this->db->where($sub_cond);
                                $subcategs = $this->db->get('subcategories');
                                if($this->input->post('subcategory')!='0')
                                $subcategory_sel = $this->input->post('subcategory');
                                else
                                    $subcategory_sel = "0";
                            if($subcategs->num_rows()>0)
                            {
                                foreach($subcategs->result() as $subcat)
                                {
                                    ?>
                      <option value="<?PHP echo $subcat->Sub_CatId;?>" <?PHP if($subcat->Sub_CatId==$subcategory_sel){ echo 'selected="selected"';  }?>  ><?PHP echo $subcat->SubCategory?></option>
                                    <?PHP
                                }
                            }
                                
                          
                        
						}
						else
						{
							//get the subcategory based on category in which the product has added
							
							$this->db->where('CategId',$Category_Id)	;
							$subcateg = $this->db->get('subcategories');
							
							foreach( $subcateg->result() as $sub_categ )
							{
							?>
                            <option value="<?PHP echo $sub_categ->Sub_CatId; ?>" <?PHP if($sub_categ->Sub_CatId == $Sub_CatId){ echo "selected"; }?>> <?PHP echo $sub_categ->SubCategory; ?></option>
                            <?PHP	
							}
						}
                  ?>
                    </select>
                <span class="err_msg subcategory_err"></span>
                </div>
                
              </div>
              
                     <div class="control-group">
                <label class="control-label">Product Name</label>
                <div class="controls">
                  <input type="text" name="product_name" id="product_name" value="<?PHP echo $ProductName; ?>">
                <span class="err_msg product_name_err"></span>
                </div>
                
              </div>
              <div class="control-group">
                <label class="control-label">Product Description</label>
                <div class="controls">
                <textarea name="prdct_desc" id="prdct_desc"><?PHP echo $ProductDesc; ?></textarea>
					 <span class="err_msg prdct_desc_err"></span>
                </div>
              
              <div class="control-group">
                <label class="control-label">Add a Type</label>
                <div class="controls">
					<input type="text" name="subcategoryType" id="subcategoryType" value="<?PHP echo $Type;?>" />
                  
                <span class="err_msg subcategoryType_err"></span>
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Ready To</label>
                <div class="controls">
                <?PHP
				 if($this->input->post('Add_Product_Btn') )
				 {
					$readyto=$this->input->post('readyto'); 
				 }
				 else
				 	$readyto='NA';
				
				?>
                
                  <input type="radio" name="readyto" id="readyto" value="NA" <?PHP if( $ReadyTo == "NA" ){ echo 'checked="checked"'; } ?>  >Not Applicable
                    <input type="radio" name="readyto" id="readyto" value="Eat" <?PHP if( $ReadyTo == "Eat" ){ echo 'checked="checked"'; } ?>  >Eat
                      <input type="radio" name="readyto" id="readyto" value="Cook" <?PHP if( $ReadyTo == "Cook" ){ echo 'checked="checked"'; } ?>  >Cook
                      
                      <span class="err_msg readyto_err"></span>
               
                </div>
                
              </div>
              
              
              <div class="control-group">
                <label class="control-label">Product Status</label>
                <div class="controls">
                <?PHP
				 if($this->input->post('Add_Product_Btn') )
				 {
					$prdstatus=$this->input->post('prd_status'); 
				 }
				 
				
				?>
                
                  <input type="radio" name="prd_status" id="prd_status" value="Active" <?PHP if( $prdstatus == "Active" ){ echo 'checked="checked"'; } ?>   />Active
                  <input type="radio" name="prd_status" id="prd_status" value="Inactive" <?PHP if( $prdstatus == "Inactive" ){ echo 'checked="checked"'; } ?>  >Inactive

                      
               
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Measurement Unit</label>
                <div class="controls">
                  <select name="unit" id="unit">
                     <?PHP if( sizeof($units_data)>0) { 
                    $unit_cnt=0;
                if($this->input->post('Add_Product_Btn') && $this->input->post('unit')!='0')
                        {
                            $UNITS=$this->input->post('unit');
                        }
                else
                        $UNITS='0';
                foreach($units_data->result() as $unit)
                    {
                        if($unit_cnt==0)
                        {
                            ?>
                                <option value="0"<?PHP if($MeasurementUnit=="0") { echo 'selected'; }?> >Select Measurement</option>
                                <option value="<?PHP echo $unit->MeasurementId;?>" <?PHP if($MeasurementUnit==$unit->MeasurementId) { echo 'selected'; }?>><?PHP echo $unit->MeasurementUnit;?></option>
                            <?PHP
                        }
                        else
                        {
                        ?>
                            <option value="<?PHP echo $unit->MeasurementId;?>" <?PHP if($MeasurementUnit==$unit->MeasurementId) { echo 'selected'; }?> ><?PHP echo $unit->MeasurementUnit;?></option>
                        <?PHP
                            
                        }
                    $unit_cnt++;
                    }
                }
                else
                {
                    
                }
                ?>
                 </select>
                <span class="err_msg unit_err"></span>
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Select BaseUOM</label>
                <div class="controls">
                    
                    <?PHP
						$this->db->where('Status','Active');
						$baseuoms = $this->db->get('baseuom');
						
						if($baseuoms->num_rows()>0)
						{
							$baseuoms_data = $baseuoms;
						}
						else
							$baseuoms_data = array();
                    ?>                
                  <select name="baseuom" id="baseuom">
               		<?PHP 
						
						if( sizeof($baseuoms_data)>0)
						{
							$baseuom_cnt=0;
							foreach($baseuoms_data->result() as $baseuom)
							{
								if($baseuom_cnt==0)
								{
									?>
                                    	<option value="0" <?PHP if($BaseUOM==0) echo 'selected="selected"'; ?>  >Select BaseUOM </option>
                                <?PHP
								}
								?>
                                	<option value="<?PHP echo  $baseuom->baseid;?>" <?PHP if($BaseUOM==$baseuom->baseid) echo 'selected="selected"'; ?>   > <?PHP echo  $baseuom->Baseuom;?> </option>
                                <?php	
								
								$baseuom_cnt++;
							}
						}
						else
						{
							?>
                            <option value="0">No Baseuoms</option>
                            <?PHP	
						}
						
						
					?>
                  </select>
                <span class="err_msg baseuom_err"></span>
                </div>
                
              </div>
              
              
              <div class="control-group" >
                <label class="control-label">Net Weight</label>
                <div class="controls" id="netweightObj">
                <?PHP
				
				//get the net weight for this product
				$this->db->select('Netweight, Id');
				$this->db->from('packagintypes');
				$this->db->where('ProductId',$ProductId);
				$this->db->order_by('Id','ASC');
				$neightweights =  $this->db->get('');
				$netweight_cnt=0;
				foreach( $neightweights->result() as $netweig)
				{
				if($netweight_cnt==0)
				{
				?>
                  <input type="text" name="netweight[]" id="netweight" chk_param="netweight" package_id="<?PHP echo $netweig->Id; ?>" value="<?PHP echo $netweig->Netweight; ?>" style="width:17%">
                 <?PHP
                 }
                 $netweight_cnt++;
                  }
				  ?>
                  <a class="add_more_edit" prd_id="<?PHP echo $ProductId; ?>" total_pkgs = "<?PHP echo $neightweights->num_rows(); ?>"  ide="netweight">Add More</a>
                  
                  <?PHP
				  //get the more net weight if any
				  
				  if($neightweights->num_rows()>1)
				  {
					$netweight_cnt=0;
					foreach( $neightweights->result() as $netweig)
					{
						if($netweight_cnt>0) // i had taken from the second one onwards because already first one i had taken above
						{
				  ?>
				  <div style='position:relative;display:inline-block; width:8%; margin-right:5px '>
                                <input type ='text' name='netweight[]' class='netweightMore' chk_param='netweight' package_id="<?PHP echo $netweig->Id; ?>" value="<?PHP echo $netweig->Netweight; ?>"  style='width:100%; margin-left:10px' /><span class='package-removal' package_id="<?PHP echo $netweig->Id; ?>">X</span>
                                </div>
				  <?PHP
						}
						$netweight_cnt++;
					}
					
					  
					 }
					 //get the more net weight if any ends here
                  ?>
                  
                <span class="err_msg netweightErr"><?PHP echo form_error('netweight');?></span>
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Gross Weight</label>
                <div class="controls"  id="grossweightObj">
               <?PHP
			   
			   //get the Gross weight for this product
				$this->db->select('Grossweight,Id');
				$this->db->from('packagintypes');
				$this->db->where('ProductId',$ProductId);
				$this->db->order_by('Id','ASC');
				$Grossweights =  $this->db->get('');
				$Grossweight_cnt=0;
				foreach( $Grossweights->result() as $grossweig)
				{
					if($Grossweight_cnt==0)
					{
					
			   ?>
                
                <input type="text" name="grossweight[]" id="grossweight" chk_param="grossweight" package_id="<?PHP echo $grossweig->Id; ?>" value="<?PHP echo $grossweig->Grossweight; ?>" style="width:17%">
               <?PHP
					}
					$Grossweight_cnt++;
				}
			   ?>  
                 
                   <a class="add_more_edit" ide="grossweight">Add More</a>
                   
                    <?PHP
					$Grossweight_cnt=0;
				 foreach( $Grossweights->result() as $grossweig)
				  {
					
					if($Grossweight_cnt>0)
					{
					?>
                                 <div style='position:relative;display:inline-block; width:8%; margin-right:5px '>
                                <input type ='text' name='grossweight[]' class='grossweightMore' chk_param="grossweight" package_id="<?PHP echo $grossweig->Id; ?>" value="<?PHP echo $grossweig->Grossweight; ?>"  style='width:100%; margin-left:10px'  /><span class='package-removal' package_id="<?PHP echo $grossweig->Id; ?>">X</span>
                                </div>
                 <?PHP	
					}
					$Grossweight_cnt++;
				  }
				  
                  ?>
                   
                <span class="err_msg grossweightErr"><?PHP echo form_error('grossweight');?></span>
                </div>
                
              </div>
                
              
              </div>
            
            
              
              <div class="control-group">
                <label class="control-label">Quantity</label>
                <div class="controls" id="quantityObj">
                
                
                <?PHP
			   
			   //get the Quantity for this product
				$this->db->select('Quantity,Id');
				$this->db->from('packagintypes');
				$this->db->where('ProductId',$ProductId);
				$this->db->order_by('Id','ASC');
				$Quantities =  $this->db->get('');
				$Quantity_cnt=0;
				foreach( $Quantities->result() as $quant)
				{
					if($Quantity_cnt==0)
					{
					
			   ?>
                
                  <input type="text" name="quantity[]" id="quantity" chk_param="quantity" value="<?PHP echo $quant->Quantity; ?>" package_id="<?PHP echo $quant->Id; ?>" style="width:17%">
                  <?PHP
					}
					$Quantity_cnt++;
				}
				?>
                   <a  class="add_more_edit" ide="quantity">Add More</a>
              <?PHP
			    $Quantity_cnt=0;
				
			    foreach( $Quantities->result() as $quant)
				{
					if($Quantity_cnt>0)
					{
					
			   ?>    
                              <div style='position:relative;display:inline-block; width:8%; margin-right:5px '>
                            <input type="text" name="quantity[]" id="quantity" class="quantityMore" chk_param="quantity" package_id="<?PHP echo $quant->Id; ?>" value="<?PHP echo $quant->Quantity; ?>" style="width:100%; margin-left:10px">
                            <span class='package-removal' package_id="<?PHP echo $quant->Id; ?>">X</span>
                            </div>
               <?PHP
					}
					$Quantity_cnt++;
				}
				
                   ?>
                   
                   
                   
                   
                   
                <span class="err_msg quantityErr"><?PHP echo form_error('quantity');?></span>
                </div>
                
              </div>
                <div class="control-group">
                <label class="control-label">Price&nbsp;<b>Rs.</b></label>
                <div class="controls" id="priceObj">
                 <?PHP
			   
			   //get the Prices for this product
			   
				$this->db->select('Price,Id');
				$this->db->from('packagintypes');
				$this->db->where('ProductId',$ProductId);
				$this->db->order_by('Id','ASC');
				$Proces =  $this->db->get('');
				$Price_cnt=0;
				foreach( $Proces->result() as $price)
				{
					if($Price_cnt==0)
					{

				?>
                  <input type="text" name="product_price[]" id="product_price" chk_param="product_price" package_id="<?PHP echo $price->Id; ?>" value="<?PHP echo $price->Price; ?>" style="width:17%">
                  <?PHP
					}
					$Price_cnt++;
				}
                  ?>
                  <a class="add_more_edit" ide="product_price">Add More</a>
                 <?PHP
				 $Price_cnt=0;
				 foreach( $Proces->result() as $price)
				{
					if($Price_cnt>0)
					{
				 
				 ?>
                            <div style='position:relative;display:inline-block; width:8%; margin-right:5px '>
                            <input type="text" name="product_price[]" package_id="<?PHP echo $price->Id; ?>" chk_param="product_price" class="product_priceMore" value="<?PHP echo $price->Price; ?>" style="width:100%; margin-left:10px">
                            <span class='package-removal' package_id="<?PHP echo $price->Id; ?>">X</span>
                            </div>
                   <?PHP
					}
					$Price_cnt++;
				}
			
                   ?>
                   
                   
                   
                   
                <span class="err_msg product_priceErr"><?PHP echo form_error('product_price');?></span>
                </div>
                
              </div>
                <!--
                <div class="control-group">
                <label class="control-label">Product Image</label>
                <div class="controls">
                  <input type="file" name="product_image" >
                <span class="err_msg"><?PHP echo form_error('product_image');?></span>
                </div>
                
              </div>
                -->
                
                
                
              
              <div class="form-actions col-sm-12">
                <input type="button" value="Edit Product Details" prdIde="<?PHP echo $ProductId;?>" total_pkgs = "<?PHP echo $neightweights->num_rows(); ?>" class="btn btn-success col-sm-5" name="edit_Product_details" id="edit_Product_details">
               <div id="update_msg"> </div>
              </div>
              
            </form>
          </div>
          
          
          <!-- edit_details ends here -->
          
          <!-- edit_img ends here -->
          <div id="edit_img" class="widget-content nopadding tab-pane fade <?PHP if( $this->session->flashdata('checkProductImg')!=""){ echo "in active"; } ?>">
          <?PHP echo $this->session->flashdata('checkProductImg');?>
          <form class="form-horizontal" method="post" enctype="multipart/form-data" name="">
          		<div class="col-sm-12">
                 <div class="col-sm-6">
                    <label class="control-label">Product Image</label>
                    <div class="controls">
                      <input type="file" name="product_image" >
                    <span class="err_msg"><?PHP echo form_error('product_image');?></span>
                    </div>
                    
                    <div class="controls">
                	<input type="submit" class="btn btn-info" value="Upload"  name="Edit_Product_Btn"/>
	                </div>
              	</div>
                
                <div class="col-sm-4">
                	
                    <?PHP
					foreach($product->result() as $img)
					{
						$image_src = $img->ProductImage;
					}	
					?>
                    <div style="max-width:250px; height:auto; margin:0 0 15px 0;">
                    <img src="<?PHP echo $image_src; ?>" class="img-responsive"  />
                    </div>
                </div>
                
                <div class="clearfix"></div>
                </div>
                
               <div class="clearfix"></div>
          </form>
          </div>
          <!-- edit_img ends here -->
          
          </div>
          <!-- tabs code starts here -->
          
        </div>
      </div>
    </div>
    
    
  </div>
</div>