<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a class="anchor_feel">Manage category</a> 
    <a  href="<?PHP echo base_url('admin-add-category'); ?>">Add Category</a>
        <a  href="<?PHP echo base_url('admin-view-categories'); ?>">View categories</a>
        <a  class="anchor_feelcurrent">Edit category</a> </div>

  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Category</h5>
          </div>
          <div class="widget-content nopadding">
          <?PHP echo $this->session->flashdata('category_upd_status');?>
          
          <?PHP
		  $categ_img='';
		  if($this->input->post('Edit_Category_Btn'))
		  {
				  	$editcategory = $this->input->post('editcategory');
					$edit_id = $this->input->post('edit_brandname');
					$categ_id=$this->input->post('categ_id');
					$categ_status=$this->input->post('categ_status');
                    
                    
					
		  }
		  else
		  {
			  if($data!='0')
			  {
				  foreach($data->result() as $categ)
				  {
						$editcategory = $categ->Category_Name;
						//$edit_id = $categ->BrandId;
						$categ_id=$categ->CategoryID;
						$categ_status=$categ->Status;
                        $categ_img=$categ->LogoPath;
						
				  }

			  }
			  else
			  {
					  
			  }
			 // foreach()
		  }
		  ?>
          
            <form class="form-horizontal" method="post" action="" name="edit_category"  novalidate="novalidate" enctype="multipart/form-data">
              
              
              
              
              
              
              <div class="control-group">
                <label class="control-label">Enter Category</label>
                <div class="controls">
                  <input type="text" name="editcategory" id="" value="<?PHP echo $editcategory; ?>" />
                  <input type="hidden" name="categ_id" value="<?PHP echo $categ_id; ?>"  />
                  <span class="err_msg"><?PHP echo form_error('editcategory');?></span>
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label">Change Status</label>
                <div class="controls">

					<select name="categ_status">
                    	<option value="0">Select Status</option>
                        <option value="Active" <?PHP if($categ_status=="Active"){ echo "selected";}?>>Active</option>
                        <option value="inactive" <?PHP if($categ_status=="Inactive"){ echo "selected";}?>>Inactive</option>
                    </select>
                  <span class="err_msg"><?PHP echo form_error('categ_status');?></span>
                </div>
              </div>
                
                 <div class="control-group">
                <label class="control-label">Choose category logo</label>
                <div class="controls">
                  <input type="file" name="editcategorylogo" id="editcategorylogo" />
                  <span class="err_msg"><?PHP echo form_error('editcategorylogo');?></span>
                </div>
              </div>
                
                <div class="control-group">
                <img src="<?PHP echo $categ_img;?>">
              </div>
              
              <div class="form-actions">
                <input type="submit" value="Edit Category" class="btn btn-success" name="Edit_Category_Btn">
              </div>
            </form>
         
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>