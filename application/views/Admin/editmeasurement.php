<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a class="anchor_feel">Manage measurements</a> <a href="<?PHP echo base_url('admin-add-measurement');?>">Add Measurement </a> <a href="<?PHP echo base_url('admin-view-measurements');?>">View measurements </a>  <a  class=" anchor_feeel current">Edit Measurement Unit</a> </div>
    
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Brand</h5>
          </div>
          <div class="widget-content nopadding">
          <?PHP echo $this->session->flashdata('Unit_updated_status');?>
           
<?PHP
	if($this->input->post('Edit_Brand_Btn'))
	{
		$edit_measurement  = $this->input->post('edit_measurement');
		$unit_status       = $this->input->post('unit_status');
	}
	else
	{
		$CI=&get_instance();
		
		$cond = array();
		$cond['MeasurementId'] = $this->uri->segment(2);
		$table='measurements';
		
//		$CI->db->where($cond)
		$data = $CI->Commonmodel->get_single_row($table,$cond,$order_by='',$order_by_field='',$limit='');
		if($data=='0')
		{
			echo "<h2> No data exists </h2>";
		}
		else
		{
          foreach($data->result() as $unit)
		  {
			  $edit_measurement  = trim($unit->MeasurementUnit);
		      $unit_status       = trim($unit->Status);
		  }
		}
	}
          ?>
            <form class="form-horizontal" method="post" action="" name="edit_brand"  novalidate="novalidate" enctype="multipart/form-data">
              <div class="control-group">
                <label class="control-label">Measurement</label>
                <div class="controls">
                  <input type="text" name="edit_measurement" id="edit_measurement" value="<?PHP echo $edit_measurement; ?>">
                  <input type="hidden" name="measurementid" value="<?PHP echo $this->uri->segment(2); ?>" />
                <span class="err_msg"><?PHP echo form_error('edit_measurement');?></span>
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Change Status</label>
                <div class="controls">
                  <select name="unit_status">
                  <option value="0">Change Status</option>
                  <option value="Active" <?PHP if($unit_status=='Active'){ echo 'selected'; } ?>>Active </option>
                  <option value="Inactive"  <?PHP if($unit_status=='Inactive'){ echo 'selected'; } ?>>Inactive </option>
                  </select>
                <span class="err_msg"><?PHP echo form_error('unit_status');?></span>
                </div>
                
               
              
             
              
              <div class="form-actions">
                <input type="submit" value="Edit Measurement" class="btn btn-success" name="Edit_unit_Btn">
              </div>
            </form>
         
		 
            
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>