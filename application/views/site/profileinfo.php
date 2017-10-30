<?PHP

$Loginid = '';
$Brand = '';
$OwnerName = '';

$storeEmail= '';
$AuthorisedEmail = '';
$Phone = '';

$Address = '';
$Location = '';

//$communication is what we had send from the controller method to this view


foreach($communication->result() as $comm_data)
{

	$Loginid = $comm_data->UserName;
	//$Brand = $comm_data->BrandName;
	$OwnerName = $comm_data->Owner_Name;
	
	$storeEmail= $comm_data->Email;
	$AuthorisedEmail = $comm_data->AuthorisedEmail;
	$Phone = $comm_data->Phone;
	
	$Address = $comm_data->Address;
	$Location = $comm_data->Location;
}

?>      
<!--------------------------------------------------------------------------- 
			Brands and Categories view in Index page
---------------------------------------------------------------------------->

            <div id="center_column" class="center_column col-xs-12 col-sm-12">
              	<div class="clearfix profile-colm">
                <!--	<h2 >Profile info</h2>-->
                
                
                 <div class="col-sm-12 col-xs-12 breadcrumb_colm">
                	<ol class="breadcrumb">
                        <li><a href="<?PHP echo base_url();?>">Home</a></li>
                        <li class="active"><?PHP echo $this->uri->segment(1);?></li>
                        
                      </ol>
                </div>
                <div class="clearfix"></div>
                     <?PHP
						if($AuthorisedEmail=='')	
						{
						?>
                        <div class="alert alert-danger"> Pleased provide authorized email in your profile </div>
                         <?PHP	
						}
						
						?>

                    <div class="row">
              
                    
                    <div class="col-sm-6">
                    <div class="profile-info">
                    	<h3>Profile Info</h3>
                        <div class="succ_msg">
                       
                         </div>
                        
                    	<div class="form-group">
                            <label>Login Id</label>
                            <div class="controls">
                              <input type="text" class="form-class" name="edit_user_name" id="edit_user_name" disabled="disabled" value="<?PHP echo $Loginid;?>">
                              <span class="err_msg"></span>                            
                            </div>                
                        </div>
                        
                        <!--<div class="form-group">
           
                            <label class="control-label">Select brand</label>
                            <div class="controls">
                            <input name="brandname" type="text" class="form-class" id="brandname" disabled="disabled" value="MCD">
                            
                            <span class="err_msg"></span>
                            </div>
                        </div>-->
                        
                        <div class="form-group">
                            <label>Change Password</label>
                            <div class="controls">
                              <input type="text" class="form-class" name="edit_password" id="edit_password" value="">
                              
                            </div>                
<div class="err_msg text-center user_name_err" style="color:red"></div>                                
                        </div>
                        
                        
                        <div class="form-group">
                            <label>Store name</label>
                            <div class="controls">
                              <input type="text" class="form-class" name="edit_store_name" id="edit_store_name" value="<?PHP echo $OwnerName; ?>">
                              
                            </div>                
<div class="err_msg text-center user_name_err" style="color:red"></div>                                
                        </div>
                        
                        <div class="form-group">
                            <label>Store email</label>
                            <div class="controls">
                              <input type="text" class="form-class" name="edit_store_email" id="edit_store_email" value="<?PHP echo $storeEmail; ?>">

                            </div>                
<div class="err_msg text-center store_err" style="color:red"></div>
                        </div>
                        
                        <div class="form-group">
                            <label>Authorised email</label>
                            <div class="controls">
                              <input type="text" class="form-class" name="edit_authorised_email" id="edit_authorised_email" value="<?PHP echo $AuthorisedEmail; ?>"> 
                               <span class="err_msg authorised_err" style="color:red"></span>   
                               
                              </div>            
                                
                         
                        </div>
                        
                        <div class="form-group">
                            <label>Store phone</label>
                            <div class="controls">
                              <input type="text" class="form-class" name="edit_phone" id="edit_phone" value="<?PHP echo $Phone;?>">

                            </div>                
<div class="err_msg text-center phone_err" style="color:red"></div>                                                        
                        </div>
                        
                        <div class="form-group">
                            <label>Store address</label>
                            <div class="controls">
                              <textarea class="form-class" name="edit_store_addr" id="edit_store_addr"><?PHP echo $Address; ?></textarea>
				
                            </div>                
<div class="err_msg text-center address_err" style="color:red"></div>                                                        
                        </div>
                        
                        <div class="form-group">
                            <label>Store location</label>
                            <div class="controls">
                              <input type="text" class="form-class" name="edit_location" id="edit_location" value="<?PHP echo $Location; ?>">
                            </div>                
<div class="err_msg text-center location_err" style="color:red"></div>                                                                                    
                        </div>
                        
                        <div class="form-group">
                        	<div class="col-sm-4"></div>
                            <button type="button" class="btn btn-success profile_edit" name="pers_info">Edit Details</button>
                        </div>
                        
                    </div>
                    </div>
                    
                    <div class="col-sm-6">
                    <div class="profile-info">
                    	<h3>Communication details</h3>
                    	<div class="form-group">
                            <label><strong>Address</strong> </label>
                            <div class="controls">
                              <span class="form-class edit_store_addr"><?PHP echo $Address;?></span>
                            </div>                
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label"><strong>Phone Number</strong></label>
                            <div class="controls">
                             <span class="form-class edit_phone"><?PHP echo $Phone;?></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label"><strong>Authorised Email</strong></label>
                            <div class="controls">
                             <span class="form-class authorisedemail"><?PHP if($AuthorisedEmail!=''){ echo $AuthorisedEmail; } else echo 'Not given';?></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label"><strong>Email Id</strong></label>
                            <div class="controls">
                             <span class="form-class emailide"><a href="javascript:void(0)"><?PHP echo $storeEmail;?></a></span>
                            </div>
                        </div>
                        
                    </div>
                    </div>
                    
                    </div>
                </div>                
              </div>
          
<!--------------------------------------------------------------------------- 
			Brands and Categories view code ends here in Index page
---------------------------------------------------------------------------->
            <div class="clearfix"></div>
            
			</div>
          
        </div>
      </div>
    </div>
  </div>
              