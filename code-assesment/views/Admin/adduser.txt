<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a href="#">Manage users</a> <a href="#" class="current">Add user</a> </div>
    <h1>Add user/Franchise</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>User/Franchise</h5>
          </div>
          <div class="widget-content nopadding">
          <?PHP echo $this->session->flashdata('user_franchise_added');?>
          
            <form class="form-horizontal" method="post" action="" name="add_user"  novalidate="novalidate">
              <div class="control-group">
                <label class="control-label">User Login Id</label>
                <div class="controls">
                  <input type="text" name="user_name" id="user_name" value="<?PHP echo set_value('user_name'); ?>">
                <span class="err_msg"><?PHP echo form_error('user_name');?></span>
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Login Password</label>
                <div class="controls">
                  <input type="password" name="password" id="password">
                <span class="err_msg"><?PHP echo form_error('password');?></span>
                </div>
                
              </div>
              
              <!--
              	<div class="control-group">
                <label class="control-label">Select brand</label>
                <div class="controls">
                 <select name="brandname">
                 	
                    <?PHP 
					$CI=&get_instance();
					
					$table='brands';					
					$cond=array();
					
					$order_by='BrandName';
					$order_by_field='ASC';
					$limit='';
					
					$brands = $CI->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
					
					if($brands!='0')
					{
						if($CI->input->post('Add_User_Btn'))
						{
							$selected_brand = $CI->input->post('brandname');	
						}
						else
							$selected_brand = '0';	
							
						$cnt=0	;	
						foreach($brands->result() as $brand)	
						{
							if($cnt==0)
							{
							?>
                            <option value="0" <?PHP if($selected_brand=="0"){ echo 'selected'; } ?>>Select Brand</option>
                            	<option value="<?PHP echo $brand->BrandId; ?>" <?PHP if($selected_brand==$brand->BrandId){ echo 'selected'; } ?>><?PHP echo $brand->BrandName; ?> </option>
                            <?PHP	
							}
							else
							{
								?>
                                <option value="<?PHP echo $brand->BrandId; ?>" <?PHP if($selected_brand==$brand->BrandId){ echo 'selected'; } ?>><?PHP echo $brand->BrandName; ?> </option>
                                <?PHP
							}
							$cnt++;
						}
					}
					
					
					?>
                 </select>
                <span class="err_msg"><?PHP echo form_error('brandname');?></span>
                </div>
                
              </div>
              -->
              
              <div class="control-group">
                <label class="control-label">Select City</label>
                <div class="controls">
                 
                 <select name="City">
                 <option value="Hyderabad">Hyderabad</option>
                 </select>
                <span class="err_msg"><?PHP echo form_error('City');?></span>
                </div>
                
              </div>
              
              <div class="control-group">
                <label class="control-label">Store Name</label>
                <div class="controls">
                  <input type="text" name="owner_name" id="owner_name" value="<?PHP echo set_value('owner_name'); ?>">
                      <span class="err_msg"><?PHP echo form_error('owner_name');?></span>
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label">User/Franchise Email</label>
                <div class="controls">
                  <input type="text" name="email" id="email" value="<?PHP echo set_value('email'); ?>">
                    <span class="err_msg"><?PHP echo form_error('email');?></span>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">User/Franchise Phone</label>
                <div class="controls">
                  <input type="text" name="phone" id="phone" value="<?PHP echo set_value('phone');?>">
                     <span class="err_msg"><?PHP echo form_error('phone');?></span>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Store Address</label>
                <div class="controls">
                  <textarea class="" name="store_addr" id="store_addr"><?PHP echo set_value('store_addr');?></textarea>
                     <span class="err_msg"><?PHP echo form_error('store_addr');?></span>
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label">Store Location</label>
                <div class="controls">
                  <input type="text" name="location" id="location" value="<?PHP echo set_value('location'); ?>" />
                  <span class="err_msg"><?PHP echo form_error('location');?></span>
                </div>
              </div>
              
              <div class="form-actions">
                <input type="submit" value="Add User" class="btn btn-success" name="Add_User_Btn">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>