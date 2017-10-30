<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a href="#">Manage Sub-Category</a> <a  class="anchor_feelcurrent">Add Sub-Category</a> </div>

  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add Sub-Category</h5>
          </div>
          <div class="widget-content nopadding">
          <?PHP echo $this->session->flashdata('user_franchise_added');?>
          
            <form class="form-horizontal" method="post" action="" name="add_subcategory"  novalidate="novalidate" enctype="multipart/form-data">
            
             
             
              
             <div class="control-group">
             
              <label class="control-label">Select Category</label>
               <div class="controls">
               <select name="category" id="category">
               <option value="0">Select Category</option>
               <?PHP
			 
			   if($this->input->post('Add_Sub_Category') && $this->input->post('category')!='0')
			   {
					if($this->input->post('category')!='0')  
					{
						$subcateg = $this->db->get('categories');
						foreach($subcateg->result() as $subc)
						{
							?>
                            	<option value="<?PHP echo $subc->CategoryID; ?>" <?PHP if($this->input->post('category') == $subc->CategoryID) echo 'selected="selected"'; ?> ><?PHP echo $subc->Category_Name;?></option>
                            <?PHP
						}	
					}
			   }
			   else
			   {
				   $this->db->order_by('Category_Name','ASC');
				   $categ_qry = $this->db->get('categories');
				   foreach($categ_qry->result() as $catgo)
				   {
					?>
                    	<option value="<?PHP echo $catgo->CategoryID; ?>"> <?PHP echo $catgo->Category_Name; ?> </option>
                    <?PHP   
				   }
			   }
			   ?>
               </select>
                  <span class="err_msg" id="cat_err"><?PHP echo form_error('category');?></span>
               </div>
             </div>
             
              <div class="control-group">
                <label class="control-label">Enter Sub-Category</label>
                <div class="controls">
                  <input type="text" name="subcategory" id="subcategory" value="<?PHP echo set_value('subcategory'); ?>"/>
                  <span class="err_msg" id="subcat_err"><?PHP echo form_error('subcategory');?></span>
                </div>
              </div>
              
              
              
              
              <div class="form-actions">
                <input type="submit" value="Add Sub-Category" class="btn btn-success" name="Add_Sub_Category" id="Add_Sub_Category">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>