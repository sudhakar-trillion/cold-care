<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a class="anchor_feelcurrent">Manage Sub-Category</a>  <a href="<?PHP echo base_url('admin-view-subcategories')?>">View Sub-Categories</a>  <a  class="anchor_feelcurrent">Add Sub-Category</a> </div>

  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add Sub-Category</h5>
          </div>
          <div class="widget-content nopadding">
          <?PHP echo $this->session->flashdata('subcat_edit_status');
		  
		  foreach( $data->result() as $dat )
		  {
				//$BrandId =   $dat->BrandId;
				$CategId =   $dat->CategId;
				$SubCategory =   $dat->SubCategory;
				$Sub_CatId =   $dat->Sub_CatId;
		  }
		  ?>
          
            <form class="form-horizontal" method="post" action="" name="add_subcategory"  novalidate="novalidate" enctype="multipart/form-data">
            <input type="hidden" name="subcatid" value="<?PHP echo $Sub_CatId?>" />
             
             <?PHP
					$CI=&get_instance();
			 ?>
              
             <div class="control-group">
             
              <label class="control-label">Select Category</label>
               <div class="controls">
               <select name="category" id="category">
               <?PHP
			   			$subcateg = $CI->db->get('categories');
						foreach($subcateg->result() as $subc)
						{
							?>
                            	<option value="<?PHP echo $subc->CategoryID; ?>" <?PHP if( $CategId == $subc->CategoryID) echo 'selected="selected"'; ?> ><?PHP echo $subc->Category_Name;?></option>
                            <?PHP
						}	
					
			   ?>
               </select>
                  <span class="err_msg" id="cat_err"></span>
               </div>
             </div>
             
              <div class="control-group">
                <label class="control-label">Enter Sub-Category</label>
                <div class="controls">
                  <input type="text" name="subcategory" id="subcategory" value="<?PHP echo $SubCategory;  ?>"/>
                  <span class="err_msg" id="subcat_err"><?PHP echo form_error('subcategory');?></span>
                </div>
              </div>
              
              
              
              
              <div class="form-actions">
                <input type="submit" value="Edit Sub-Category" class="btn btn-success" name="Edit_Sub_Category" id="Add_Sub_Category">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>