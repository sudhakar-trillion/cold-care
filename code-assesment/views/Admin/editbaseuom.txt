<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a class="anchor_feelcurrent">Manage Base UOM</a> <a href="<?PHP echo base_url('admin-add-base-uom')?>">Add Base UOM</a><a  class="anchor_feelcurrent">Edit Base UOM</a> </div>

  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add Base UOM</h5>
          </div>
          <div class="widget-content nopadding">
          <?PHP echo $this->session->flashdata('baseuom_updated');?>
                   
          <?PHP
		 
		  if( $this->input->post('Edit_Base_UOM') )
		  {
			  $baseoum = $this->input->POST('Base_UOM');
		  }
		  else
		  {
				foreach($res->result() as $data)
				{
					$baseoum = $data->Baseuom;
				}
		  }
		  
		  ?>
          
            <form class="form-horizontal" method="post" action="" name="Add_Base_UOM_Form"  novalidate="novalidate" enctype="multipart/form-data">
            
                
                 <div class="control-group">
                <label class="control-label"> Enter Base UOM </label>
                <div class="controls">
                  <input type="text" name="Base_UOM" id="Base_UOM" value="<?PHP echo $baseoum; ?>" />
                  <input type="hidden" name="base_uom_id" value="<?PHP echo $this->uri->segment(2); ?>" />
                  <span class="err_msg"><?PHP echo form_error('Base_UOM');?></span>
                </div>
              </div>
               
              <div class="form-actions">
                <input type="submit" value="Edit Base UOM" class="btn btn-success" name="Edit_Base_UOM">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>