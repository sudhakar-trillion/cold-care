<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a href="#">Manage Products</a>
        <a href="<?PHP echo base_url('admin-view-products'); ?>">View Products</a><a  class="current">Add Product</a> </div>
    
    
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add Product</h5>
          </div>
          <div class="widget-content nopadding">
          <?PHP echo $this->session->flashdata('add_product_status');?>
        
              <?PHP
              $brand=0;
              
              if($this->input->post('Add_Product_Btn'))
              {
                  //check whether brand selected or not
                  if($this->input->post('brand')!='0')
                  {
                      $brand = $this->input->post('brand');
                      
                  }
                  
              }
              
                ?>
              
              
              
          
            <form class="form-horizontal" method="post" action="" name="add_product"  novalidate="novalidate" enctype="multipart/form-data" autocomplete='off'>
              
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
                                <option value="0" <?PHP if($brand=="0"){ echo 'selected'; } ?>>Select Brand</option>
                                <option value="<?PHP echo $brands->BrandId;?>" <?PHP if($brand==$brands->BrandId){ echo 'selected'; } ?>><?PHP echo $brands->BrandName;?></option>
                            <?PHP
                        }
                        else
                        {
                        ?>
                            <option value="<?PHP echo $brands->BrandId;?>" <?PHP if($brand==$brands->BrandId){ echo 'selected'; } ?> ><?PHP echo $brands->BrandName;?></option>
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
                <span class="err_msg brnd_error"><?PHP echo form_error('brand');?></span>
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
                                <option value="<?PHP echo $catego->CategoryID; ?>"><?PHP echo $catego->Category_Name; ?> </option>
                                <?PHP	
							}
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
                      ?>
                    </select>
                <span class="err_msg"></span>
                </div>
                
              </div>
              
                     <div class="control-group">
                <label class="control-label">Product Name</label>
                <div class="controls">
                  <input type="text" name="product_name" id="product_name" value="<?PHP echo set_value('product_name'); ?>">
                <span class="err_msg"><?PHP echo form_error('product_name');?></span>
                </div>
                
              </div>
              <div class="control-group">
                <label class="control-label">Product Description</label>
                <div class="controls">
                <textarea name="prdct_desc" id="prdct_desc"><?PHP echo set_value('prdct_desc'); ?></textarea>

                </div>
              
              <div class="control-group">
                <label class="control-label">Add a Type</label>
                <div class="controls">
					<input type="text" name="subcategoryType" id="subcategoryType" value="<?PHP echo set_value('subcategoryType');?>" />
                  
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
                
                  <input type="radio" name="readyto" id="readyto" value="NA" <?PHP if( $readyto == "NA" ){ echo 'checked="checked"'; } ?>  >Not Applicable
                    <input type="radio" name="readyto" id="readyto" value="Eat" <?PHP if( $readyto == "Eat" ){ echo 'checked="checked"'; } ?>  >Eat
                      <input type="radio" name="readyto" id="readyto" value="Cook" <?PHP if( $readyto == "Cook" ){ echo 'checked="checked"'; } ?>  >Cook
                      
               
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
				 else
				 	$prdstatus='Active';
				
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
                                <option value="0"<?PHP if($UNITS=="0") { echo 'selected'; }?> >Select Measurement</option>
                                <option value="<?PHP echo $unit->MeasurementId;?>" <?PHP if($UNITS==$unit->MeasurementId) { echo 'selected'; }?>><?PHP echo $unit->MeasurementUnit;?></option>
                            <?PHP
                        }
                        else
                        {
                        ?>
                            <option value="<?PHP echo $unit->MeasurementId;?>" <?PHP if($UNITS==$unit->MeasurementId) { echo 'selected'; }?> ><?PHP echo $unit->MeasurementUnit;?></option>
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
					 if($this->input->post('Add_Product_Btn') && $this->input->post('baseuom')!='0' )
					 {
						 $sel_baseuom= $this->input->post('baseuom');
					 }
					else
						$sel_baseuom= "0";
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
                                    	<option value="0" <?PHP if($sel_baseuom==0) echo 'selected="selected"'; ?>  >Select BaseUOM </option>
                                <?PHP
								}
								?>
                                	<option value="<?PHP echo  $baseuom->baseid;?>" <?PHP if($sel_baseuom==$baseuom->baseid) echo 'selected="selected"'; ?>   > <?PHP echo  $baseuom->Baseuom;?> </option>
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
              
              
              <div class="control-group" >
                <label class="control-label">Net Weight</label>
                <div class="controls" id="netweightObj">
                <?PHP
				if($this->input->post('Add_Product_Btn'))
					{
						$netweight_arr = $this->input->post('netweight');
						if( sizeof($netweight_arr)>0)
						{
							$netweight_zero = 	$netweight_arr[0];
						}
					}
				else
				{
					$netweight_zero='';
				}
				?>
                  <input type="text" name="netweight[]" id="netweight" value="<?PHP echo $netweight_zero; ?>" style="width:17%">
                  <a class="add_more" ide="netweight">Add More</a>
                  
                  <?PHP
				  if($this->input->post('Add_Product_Btn'))
					{
						$netweight_arr = $this->input->post('netweight');
						if($netweight_arr>1)
						{
							for($i=1;$i<sizeof($netweight_arr); $i++)
							{
								?>
                                <div style='position:relative;display:inline-block; width:8%; margin-right:5px '>
                                <input type ='text' name='netweight[]' class='netweightMore' value="<?PHP echo $netweight_arr[$i]; ?>"  style='width:100%; margin-left:10px' /><span class='package-removal'>X</span>
                                </div>
                                <?PHP	
								
							}
						}
							
					}
				  
                  ?>
                  
                <span class="err_msg netweightErr"><?PHP echo form_error('netweight');?></span>
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Gross Weight</label>
                <div class="controls"  id="grossweightObj">
                <?PHP
				if($this->input->post('Add_Product_Btn'))
					{
						$grossweight_arr = $this->input->post('grossweight');
						if( sizeof($grossweight_arr)>0)
						{
							$grossweight_zero = 	$grossweight_arr[0];
						}
					}
				else
				{
					$grossweight_zero='';
				}
				?>
                
                <input type="text" name="grossweight[]" id="grossweight" value="<?PHP echo $grossweight_zero; ?>" style="width:17%">
                   <a class="add_more" ide="grossweight">Add More</a>
                   
                    <?PHP
				  if($this->input->post('Add_Product_Btn'))
					{
						$grossweightarr = $this->input->post('grossweight');
						if($grossweightarr>1)
						{
							for($i=1;$i<sizeof($grossweightarr); $i++)
							{
								?>
                                 <div style='position:relative;display:inline-block; width:8%; margin-right:5px '>
                                <input type ='text' name='grossweight[]' class='grossweightMore' value="<?PHP echo $grossweightarr[$i]; ?>"  style='width:100%; margin-left:10px' /><span class='package-removal'>X</span>
                                </div>
                                <?PHP	
								
							}
						}
							
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
				if($this->input->post('Add_Product_Btn'))
					{
						$quantity_arr = $this->input->post('quantity');
						if( sizeof($quantity_arr)>0)
						{
							$quantit_zero = 	$quantity_arr[0];
						}
					}
				else
				{
					$quantit_zero='';
				}
				?>
                
                
                
                  <input type="text" name="quantity[]" id="quantity" value="<?PHP echo $quantit_zero; ?>" style="width:17%">
                   <a  class="add_more" ide="quantity">Add More</a>
                    <?PHP
				   	
					if($this->input->post('Add_Product_Btn'))
					{
						$quantity_arr = $this->input->post('quantity');
						if( sizeof($quantity_arr)>1 )
						{
						
							for($i=1;$i<sizeof($quantity_arr); $i++)	
							{
							?>
                              <div style='position:relative;display:inline-block; width:8%; margin-right:5px '>
                            <input type="text" name="quantity[]" id="quantity" class="quantityMore" value="<?PHP echo $quantity_arr[$i]; ?>" style="width:100%; margin-left:10px">
                            <span class='package-removal'>X</span>
                            </div>
                            <?PHP
							
							}
						}
					}
                   ?>
                   
                   
                   
                   
                   
                <span class="err_msg quantityErr"><?PHP echo form_error('quantity');?></span>
                </div>
                
              </div>
                <div class="control-group">
                <label class="control-label">Price&nbsp;<b>Rs.</b></label>
                <div class="controls" id="priceObj">
                 <?PHP
				if($this->input->post('Add_Product_Btn'))
					{
						$price_arr = $this->input->post('product_price');
						if( sizeof($price_arr)>0 && trim($price_arr[0]!='') )
						{
							$price_zero = 	$price_arr[0];
						}
						else
							$price_zero='';
						
					}
				else
				{
					$price_zero='';
				}
				?>
                  <input type="text" name="product_price[]" id="product_price" value="<?PHP echo $price_zero; ?>" style="width:17%">
                  <a class="add_more" ide="product_price">Add More</a>
                  <?PHP
				   	
					if($this->input->post('Add_Product_Btn'))
					{
						$pricearr = $this->input->post('product_price');
						if( sizeof($pricearr)>1 )
						{
						
							for($i=1;$i<sizeof($pricearr); $i++)	
							{
							?>
                            
                            <div style='position:relative;display:inline-block; width:8%; margin-right:5px '>
                            <input type="text" name="product_price[]" id="product_price" class="product_priceMore" value="<?PHP echo $pricearr[$i]; ?>" style="width:100%; margin-left:10px">
                            <span class='package-removal'>X</span>
                            </div>
                            <?PHP
							
							}
						}
					}
                   ?>
                   
                   
                   
                   
                <span class="err_msg product_priceErr"><?PHP echo form_error('product_price');?></span>
                </div>
                
              </div>
                
                <div class="control-group">
                <label class="control-label">Product Image</label>
                <div class="controls">
                  <input type="file" name="product_image" >
                <span class="err_msg"><?PHP echo form_error('product_image');?></span>
                </div>
                
              </div>
                
                
                
                
              
              <div class="form-actions">
                <input type="submit" value="Add Product" class="btn btn-success" name="Add_Product_Btn">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>