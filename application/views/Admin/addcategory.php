<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a href="#">Manage category</a> <a  class="anchor_feelcurrent">Add category</a> </div>

  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add Category</h5>
          </div>
          <div class="widget-content nopadding">
          <?PHP echo $this->session->flashdata('user_franchise_added');?>
          
            <form class="form-horizontal" method="post" action="" name="add_category"  novalidate="novalidate" enctype="multipart/form-data">
              
              
              
              
              
              <div class="control-group">
                <label class="control-label">Enter Category</label>
                <div class="controls">
                  <input type="text" name="category" id="category" value="<?PHP echo set_value('category'); ?>" />
                  <span class="err_msg"><?PHP echo form_error('category');?></span>
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label">Choose category logo</label>
                <div class="controls">
                  <input type="file" name="categorylogo" id="categorylogo" />
                  <span class="err_msg"><?PHP echo form_error('categorylogo');?></span>
                </div>
              </div>
              
              <div class="form-actions">
                <input type="submit" value="Add Category" class="btn btn-success" name="Add_Category_Btn">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>