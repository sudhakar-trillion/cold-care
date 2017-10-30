<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a class="anchor_feel">Manage brands</a> <a href="<?PHP echo base_url('admin-add-brand');?>">Add brand</a>  <a href="<?PHP echo base_url('admin-view-brands');?>">View brands</a>  <a  class=" anchor_feeel current">Edit brand</a> </div>
    
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Brand</h5>
          </div>
          <div class="widget-content nopadding">
          <?PHP echo $this->session->flashdata('Brand_update_status');?>
           <?PHP echo $this->session->flashdata('file_eror');?>
          
          
<?PHP
	if($this->input->post('Edit_Brand_Btn'))
	{
		$brandName = $this->input->post('edit_brand_name');
		$brand_status = $this->input->post('brand_status');
	}
	else
	{
		$CI=&get_instance();
		
		$cond = array();
		$cond['BrandId'] = $this->uri->segment(2);
		$table='brands';
		
//		$CI->db->where($cond)
		$data = $CI->Commonmodel->get_single_row($table,$cond,$order_by='',$order_by_field='',$limit='');
		if($data=='0')
		{
			echo "<h2> No data exists </h2>";
		}
		else
		{
          foreach($data->result() as $brand)
		  {
			  $brandName = $brand->BrandName;
			  $brand_status=$brand->Status;
			  $brand_logo = $brand->LogoPath;
		  }
		}
	}
          ?>
            <form class="form-horizontal" method="post" action="" name="edit_brand"  novalidate="novalidate" enctype="multipart/form-data">
              <div class="control-group">
                <label class="control-label">Brand Name</label>
                <div class="controls">
                  <input type="text" name="edit_brand_name" id="edit_brand_name" value="<?PHP echo $brandName; ?>">
                  <input type="hidden" name="BrandId" value="<?PHP echo $this->uri->segment(2); ?>" />
                <span class="err_msg"><?PHP echo form_error('edit_brand_name');?></span>
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Change Status</label>
                <div class="controls">
                  <select name="brand_status">
                  <option value="0">Change Status</option>
                  <option value="Active" <?PHP if($brand_status=='Active'){ echo 'selected'; } ?>>Active </option>
                  <option value="Inactive"  <?PHP if($brand_status=='Inactive'){ echo 'selected'; } ?>>Inactive </option>
                  </select>
                <span class="err_msg"><?PHP echo form_error('brand_status');?></span>
                </div>
                
                <div class="control-group">
                <label class="control-label">Choose brand logo</label>
                <div class="controls">
                  <input type="file" name="edit_brandlogo" id="edit_brandlogo" />
                  <span class="err_msg"><?PHP echo form_error('edit_brandlogo');?></span>
                </div>
              </div>
              
              <div class="control-group">
               
                <div class="controls" style="width:220px">
               <img src="<?PHP echo $brand_logo;?>" class="image-responsive" />
                </div>
              </div>
                
              </div>
              
              <div class="form-actions">
                <input type="submit" value="Edit Brand" class="btn btn-success" name="Edit_Brand_Btn">
              </div>
            </form>
         
		 
            
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>