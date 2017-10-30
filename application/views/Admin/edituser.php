<div id="content" ng-app="myApp">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?PHP echo base_url('admin-dashboard')?>" title="Go to dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <a class="anchor_feel">Manage users</a><a href="<?PHP echo base_url('admin-add-user'); ?>">Add user</a> <a href="<?PHP echo base_url('admin-view-user'); ?>">View users</a> <a  class="anchor_feel current">Edit User</a> </div>
    <h1>Edit user/Franchise</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>User/Franchise</h5>
          </div>
          <div class="widget-content nopadding"  ng-controller="ecomCtrl" ng-init="getusers(<?PHP echo $this->uri->segment(2);?>)" ng-cloak >
          <?PHP echo $this->session->flashdata('user_franchise_added');?>
          
          <?PHP
		  
		  
		  if($this->input->post('Edit_User_Btn'))
		  {
			  	$edit_user_name = $this->input->post('edit_user_name');
				$edit_owner_name = $this->input->post('edit_owner_name');
				$edit_email=$this->input->post('edit_email');
				$edit_phone=$this->input->post('edit_phone');
				$edit_store_addr=$this->input->post('edit_store_addr');
				$edit_location =$this->input->post('edit_location');
				$edit_city =$this->input->post('edit_city');
				
				
				$edit_Brand_Id = $this->input->post('brandname');
				$edit_store_status = $this->input->post('edit_store_status');
				
				
				
		  }
		  else
		  {
		  		$edit_user_name = "{{UserFranchise[0].USERNAME}}";
				$edit_owner_name = "{{UserFranchise[0].Owner_Name}}";
				$edit_email="{{UserFranchise[0].Email}}";
				$edit_phone="{{UserFranchise[0].Phone}}";
				$edit_store_addr="{{UserFranchise[0].Address}}";
				$edit_location ="{{UserFranchise[0].Location}}";
				$edit_city = "{{UserFranchise[0].City}}";
				$edit_store_status ="{{UserFranchise[0].Status}}";
				
		  }
		  
		  $CI=&get_instance();
			  
			 	 $CI->db->select('us.Status as Status,usd.BrandId as BrandId');
					$CI->db->from('users as us');
					$CI->db->join('userdetails as usd','us.SLNO=usd.SLNO');
					$CI->db->where('usd.SLNO',$this->uri->segment(2));
					$qry=$CI->db->get();
					
					
					foreach($qry->result() as $stat_brand)
					{
						$edit_Brand_Id = $stat_brand->BrandId;
						$edit_store_status = $stat_brand->Status;
					}
		  
		  echo $this->session->flashdata('update_msg');
		 
		  ?>
          
          
            <form class="form-horizontal" method="post" action="" name="edit_user"  novalidate="novalidate" >
              <div class="control-group">
                <label class="control-label">User Login Id</label>
                <div class="controls">
                  <input type="text" name="edit_user_name" id="edit_user_name" value="<?PHP echo $edit_user_name; ?>">
               
               			<span class="err_msg"><?PHP echo form_error('edit_user_name');?></span>
                
                </div>
                
              </div>
              
              <div class="control-group">
            
                <label class="control-label">Select City</label>
                <div class="controls">
                 <select name="edit_city">

                 <option value="Hyderabad"  >Hyderabad</option>                 
                 
                 </select>
                 
                <span class="err_msg"><?PHP echo form_error('brandname');?></span>
                </div>
                
              </div>
              
              <!--<div class="control-group">
            
                <label class="control-label">Select brand</label>
                <div class="controls">
                 <select name="brandname">
                 	
                    <?PHP 
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
							
						$cnt=0;
						foreach($brands->result() as $brand)	
						{
							if($cnt==0)
							{
							?>
                            <option value="0" >Select Brand</option>
                            	<option value="<?PHP echo $brand->BrandId; ?>" <?PHP if($edit_Brand_Id==(int)$brand->BrandId){ echo "selected=selected"; } ?>><?PHP echo $brand->BrandName; ?> </option>
                            <?PHP	
							}
							else
							{
								?>
                                <option value="<?PHP echo $brand->BrandId; ?>" <?PHP if($edit_Brand_Id==(int)$brand->BrandId){ echo "selected=selected"; } ?>><?PHP echo $brand->BrandName; ?> </option>
                                <?PHP
							}
							$cnt++;
						}
					}
					
					
					?>
                 </select>
                <span class="err_msg"><?PHP echo form_error('brandname');?></span>
                </div>
                
              </div>-->
              
            
              <div class="control-group">
                <label class="control-label">Store Name</label>
                <div class="controls">
                  <input type="text" name="edit_owner_name" id="edit_owner_name" value="<?PHP echo $edit_owner_name; ?>">
                      <span class="err_msg"><?PHP echo form_error('edit_owner_name');?></span>
                      
            	
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label">User/Franchise Email</label>
                <div class="controls">
                  <input type="text" name="edit_email" id="edit_email" value="<?PHP echo $edit_email; ?>">
                    <span class="err_msg"><?PHP echo form_error('edit_email');?></span>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">User/Franchise Phone</label>
                <div class="controls">
                  <input type="text" name="edit_phone" id="edit_phone" value="<?PHP echo $edit_phone; ?>">
                     <span class="err_msg"><?PHP echo form_error('edit_phone');?></span>
                     <input type="hidden" id="employeeSLNO" name="employeeSLNO" value="{{UserFranchise[0].UserId}}" />
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Store Address</label>
                <div class="controls">
                  <textarea class="" name="edit_store_addr" id="edit_store_addr"><?PHP echo $edit_store_addr;?></textarea>
                    <span class="err_msg"><?PHP echo form_error('edit_store_addr');?></span>
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label">Store Location</label>
                <div class="controls">
                  <input type="text" name="edit_location" id="edit_location" value="<?PHP echo $edit_location; ?>"/>
                  <span class="err_msg"><?PHP echo form_error('edit_location');?></span>
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label">Store Status </label>
                <div class="controls">
                  <select name="edit_store_status">
                  	<option value="0">Change Status</option>
                  	<option value="Inactive" <?PHP if(trim($edit_store_status) == "Inactive"){ echo "selected"; }?>  >Inactive</option>
                  	<option value="Active" <?PHP if(trim($edit_store_status) == "Active"){ echo "selected"; }?>  >Active</option>
                    
                  </select>
                  <span class="err_msg"><?PHP echo form_error('edit_store_status');?></span>
                  
                </div>
              </div>
              
              <div class="form-actions">
                <input type="submit" value="Edit User" class="btn btn-success" name="Edit_User_Btn"  ng-click="submitted=true">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
  </div>
</div>