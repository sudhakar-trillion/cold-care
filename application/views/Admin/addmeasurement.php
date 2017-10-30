<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a href="#">Manage Measurement</a> <a  class="anchor_feelcurrent">Add Measurement</a> </div>

  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add Measurement</h5>
          </div>
          <div class="widget-content nopadding">
          <?PHP echo $this->session->flashdata('user_franchise_added');?>
          
            <form class="form-horizontal" method="post" action="" name="add_category"  novalidate="novalidate" enctype="multipart/form-data">
            
                
                 <div class="control-group">
                <label class="control-label">Enter Measurement Unit</label>
                <div class="controls">
                  <input type="text" name="unit" id="unit" value="<?PHP echo set_value('unit'); ?>" />
                  <span class="err_msg"><?PHP echo form_error('unit');?></span>
                </div>
              </div>
               
              <div class="form-actions">
                <input type="submit" value="Add Measurement" class="btn btn-success" name="Add_Unit_Btn">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>