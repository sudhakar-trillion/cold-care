<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a href="#">Manage brands</a> <a href="#" class="current">Add brand</a> </div>
    
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add Brand</h5>
          </div>
          <div class="widget-content nopadding">
          <?PHP echo $this->session->flashdata('user_franchise_added');?>
          
            <form class="form-horizontal" method="post" action="" name="add_brand"  novalidate="novalidate" enctype="multipart/form-data">
              <div class="control-group">
                <label class="control-label">Brand Name</label>
                <div class="controls">
                  <input type="text" name="add_brand_name" id="add_brand_name" value="<?PHP echo set_value('add_brand_name'); ?>">
                <span class="err_msg"><?PHP echo form_error('add_brand_name');?></span>
                </div>
                
              </div>
              <div class="control-group">
                <label class="control-label">Choose brand logo</label>
                <div class="controls">
                  <input type="file" name="brandlogo" id="brandlogo" />
                  <span class="err_msg"><?PHP echo form_error('brandlogo');?></span>
                </div>
              </div>
              
              
              
              <div class="form-actions">
                <input type="submit" value="Add Brand" class="btn btn-success" name="Add_Brand_Btn">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>