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
          <div class="widget-content nopadding">
          <?PHP echo $this->session->flashdata('update_product_status');?>
             <?PHP echo $this->session->flashdata('checkProductImg');?>
        
              <?PHP
              $brand=0;
              
              if($this->input->post('Edd_Product_Btn'))
              {
                  //check whether brand selected or not
                  if($this->input->post('brand')!='0')
                  {
                      
					$Brand 			= 	$this->input->post('brand');
					$Category_Id	= 	$this->input->post('category');
					$Sub_CatId 		= 	$this->input->post('subcategory');
					
					$ProductName 	= 	$this->input->post('product_name');
					$ProductDesc 	= 	$this->input->post('prdct_desc');
					$ProductPrice 	= 	$this->input->post('product_price');
					$Type			= 	$this->input->post('subcategoryType');
					
					$MeasurementUnit = 	$this->input->post('unit');
					$BaseUOM		 = 	$this->input->post('baseuom');
					$NetWeight 		 = 	$this->input->post('netweight');
					
					
					$GrossWeight 	 = 	$this->input->post('grossweight');
					$Qty 			 = 	$this->input->post('quantity');
					$ReadyTo 		 = 	$this->input->post('readyto');
					
					$ProductImage 	 = 	$this->input->post('img');
                      
                  }
                  
              }else
			  {
				
				//get the product details
				//print_r($product->result());
				foreach($product->result() as $prdct)
				{
					$Brand = 	$prdct->BrandId;
					$Category_Id = 	$prdct->Category_Id;
					$Sub_CatId = 	$prdct->Sub_CatId;
					$Type			= $prdct->Type;
					
					$ProductName = 	$prdct->ProductName;
					$ProductDesc = 	$prdct->ProductDesc;
					$ProductPrice = 	$prdct->ProductPrice;
					
					$MeasurementUnit = 	$prdct->MeasurementUnit;
					$BaseUOM = 	$prdct->BaseUOM;
					$NetWeight = 	$prdct->NetWeight;
					
					
					$GrossWeight = 	$prdct->GrossWeight;
					$Qty = 	$prdct->Qty;
					$ReadyTo = 	$prdct->ReadyTo;
					
					$ProductImage = 	$prdct->ProductImage;
					
				}
				  
			  }
              
                ?>
              
              
              
          
            <form class="form-horizontal" method="post" action="" name="add_product"  novalidate="novalidate" enctype="multipart/form-data">
              
            <div class="control-group">
                
                <label class="control-label">Select Brand </label>
                <div class="controls">
                <input type="hidden" name="img" value="<?PHP echo $ProductImage?>" />
                <select name="brand" id="brand">
                <?PHP if( sizeof($brand_data)>0) { 
                $brnd_cnt=0;
                foreach($brand_data->result() as $brands)
                    {
                        if($brnd_cnt==0)
                        {
                            ?>
                                <option value="0">Select Brand</option>
                                <option value="<?PHP echo $brands->BrandId;?>" <?PHP if($Brand==$brands->BrandId){ echo 'selected="selected"'; } ?> ><?PHP echo $brands->BrandName;?></option>
                            <?PHP
                        }
                        else
                        {
                        ?>
                            <option value="<?PHP echo $brands->BrandId;?>" <?PHP if($Brand==$brands->BrandId){ echo 'selected'; } ?> ><?PHP echo $brands->BrandName;?></option>
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
                <span class="err_msg"><?PHP echo form_error('brand');?></span>
                </div>

            </div>
                
                <div class="control-group">
                <label class="control-label">Select Category</label>
                <div class="controls">
                   
                  <select name="category" id="category">
                 <?PHP
				 		//$this->db->where('BrandId',$Brand);
						$categs = $this->db->get("categories");
						$categ_cnt=0;
						foreach($categs->result() as $categ)
						{
							if($categ_cnt == 0)
							{
							?>
                            <option value="0">Select Category</option>
                            <?PHP	 
							}
						?>
                        <option value="<?PHP echo $categ->CategoryID; ?>" <?PHP if($categ->CategoryID == $Category_Id){ echo ' selected="selected"'; } ?>><?PHP echo $categ->Category_Name; ?></option>
                        <?PHP	
						$categ_cnt++;
						}
				 ?>
                    </select>
                <span class="err_msg"><?PHP echo form_error('category');?></span>
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Select SubCategory</label>
                <div class="controls">
                                    
                  <select name="subcategory" id="subcategory" class="subcategorie">
                <?PHP
					
					if($Sub_CatId>0)
					{
						$this->db->where('CategId',$Category_Id);
						//$this->db->where('BrandId',$Brand);
						
						$subcategs = $this->db->get('subcategories');
						$subcateg_cnt=0;
						foreach($subcategs->result() as $subcateg)
						{
							if($subcateg_cnt==0)
							{
							?>
                            <option value="0" >Select Subcategory</option>
                            <?PHP	
							}
							
						?>
                        <option value="<?PHP echo $subcateg->Sub_CatId;?>" <?PHP if( $subcateg->Sub_CatId == $Sub_CatId){ echo 'selected="selected"'; }?> > <?PHP echo $subcateg->SubCategory;?> </option>
                        <?PHP	
						$subcateg_cnt++;
						}
					}
				
				?>
                
                  </select>
                <span class="err_msg"></span>
                </div>
                
              </div>
                
              <div class="control-group">
                <label class="control-label">Add a Type</label>
                <div class="controls">
					<input type="text" name="subcategoryType" id="subcategoryType" value="<?PHP echo $Type; ?>" />
                  
                <span class="err_msg"></span>
                </div>
                
              </div>  
                
                
                
                
              <div class="control-group">
                <label class="control-label">Measurement Unit</label>
                <div class="controls">
                  <select name="unit" id="unit">
                     <?PHP if( sizeof($units_data)>0) { 
                  
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
                <span class="err_msg"><?PHP echo form_error('unit');?></span>
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
                <span class="err_msg"></span>
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
                      
               
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Product Name</label>
                <div class="controls">
                  <input type="text" name="product_name" id="product_name" value="<?PHP echo $ProductName; ?>">
                <span class="err_msg"><?PHP echo form_error('product_name');?></span>
                </div>
                
              </div>
              <div class="control-group">
                <label class="control-label">Product Description</label>
                <div class="controls">
                <textarea name="prdct_desc" id="prdct_desc"><?PHP echo $ProductDesc; ?></textarea>

                </div>
                
              </div>
            
            <div class="control-group">
                <label class="control-label">Net Weight</label>
                <div class="controls">
                  <input type="text" name="netweight" id="netweight" value="<?PHP echo $NetWeight; ?>">
                <span class="err_msg"><?PHP echo form_error('netweight');?></span>
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Gross Weight</label>
                <div class="controls">
                  <input type="text" name="grossweight" id="grossweight" value="<?PHP echo $GrossWeight; ?>">
                <span class="err_msg"><?PHP echo form_error('grossweight');?></span>
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Quantity</label>
                <div class="controls">
                  <input type="text" name="quantity" id="quantity" value="<?PHP echo $Qty; ?>">
                <span class="err_msg"><?PHP echo form_error('quantity');?></span>
                </div>
                
              </div>
                <div class="control-group">
                <label class="control-label">Price&nbsp;<b>Rs.</b></label>
                <div class="controls">
                  <input type="text" name="product_price" id="product_price" value="<?PHP echo $ProductPrice; ?>">
                <span class="err_msg"><?PHP echo form_error('product_price');?></span>
                </div>
                
              </div>
                
                <div class="control-group">
                <label class="control-label">Product Image</label>
                <div class="controls">
                  <input type="file" name="product_image" >
                <span class="err_msg"><?PHP echo form_error('product_image');?></span>
                </div>
                
              </div>
              
              <!--load trhe image here -->
               <div class="control-group span4 pull-right" >
<img src="<?PHP echo $ProductImage;  ?>" class="img-responsive " />
               
               </div> 
               <div style="clear:both"></div>
                
                
                
              
              <div class="form-actions">
                <input type="submit" value="Edit Product" class="btn btn-success" name="Edit_Product_Btn">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>