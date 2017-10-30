<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Admin extends CI_Controller {

	 public function __construct()
		{
			parent::__construct();
			date_default_timezone_set("Asia/Kolkata");
			define('HEADER','Admin/header');
			define('FOOTER','Admin/footer');
			define('SUBCATEGORIES','subcategories');
			$this->load->model('Commonmodel');
				if( $this->session->userdata('username')=='' || $this->session->userdata('userslno')=='')
				{
					redirect(base_url('Adminlogin'));				
				}
				
				
				//smtp details
				
				$smtpdetails = $this->Commonmodel->getsmtpdetails();

				if( $smtpdetails!='0')
				{
					foreach($smtpdetails->result() as $details)
					{
						$this->smtp_user_name = $details->user;	
						$this->smtp_password = $details->password;	
					}
				}
				
				
				// upload brand path details
				$cond= array();
				
				$cond['UploadFor'] ='brand';
				$pathdetails = $this->Commonmodel->getpathdetails($cond);
				
				if( $pathdetails!='0' )
				{
					foreach($pathdetails->result() as $details)
					{
						$this->uploadbrandPath = $details->Path;	

					}	
				}

			// upload category path details
			
				$cond= array();
				
				$cond['UploadFor'] ='category';
				$pathdetails = $this->Commonmodel->getpathdetails($cond);
				
				if( $pathdetails!='0' )
				{
					foreach($pathdetails->result() as $details)
					{
						$this->uploadcategoryPath = $details->Path;	

					}	
				}
				
				
			// upload product path details
			
				$cond= array();
				
				$cond['UploadFor'] ='product-image';
				$pathdetails = $this->Commonmodel->getpathdetails($cond);
				
				if( $pathdetails!='0' )
				{
					foreach($pathdetails->result() as $details)
					{
						$this->uploadproductPath = $details->Path;	

					}	
				}	
				
			// get the encrytion key for the cofig variable encryption_key
				
				$cond= array();
				
				$cond['KeyFor'] ='congif-encryption-key';
				$keydetails = $this->Commonmodel->getkeydetails($cond);
				
				if( $keydetails!='0' )
				{
					foreach($keydetails->result() as $details)
					{
						$this->congifencryptionkey = $details->EncKey;	

					}	
				}
				
				$this->config->set_item('encryption_key',$this->congifencryptionkey);

				
		}

public function logout()
{
	$this->session->set_userdata('username','');
	$this->session->set_userdata('userslno','');
	$this->session->set_userdata('userrole','');
	
	redirect(base_url('Adminlogin'));
}
		
	public function dashboard()
	{
		$this->load->view(HEADER);
			$this->load->view('Admin/dashboard');
		$this->load->view(FOOTER);
	}

###########################################################################################################
###########################################################################################################

/*  Mangaing users starts here */

###########################################################################################################
###########################################################################################################	

	public function adduser()
	{
		
		
		$this->load->view(HEADER);
		if($this->input->post('Add_User_Btn'))
		{	

		
			$this->form_validation->set_rules($this->config->item('add_user_franchise'));
			if($this->form_validation->run()===false)
			{ 
				//echo validation_errors(); exit; 
				$this->load->view('Admin/adduser');
			}
			else
				{

					$table1 = '';
					$table2 = '';
					
					$table1 = 'users';
					$table2 = 'userdetails';

					$data = array();
					
					$data['UserName'] = $this->input->post('user_name');
					$pwd = trim($this->input->post('password'));
					
					$Pwd = $this->saltedpassword->makeITcrypt($pwd);

					$data['Password']		= $Pwd['hashpassword'];
					$data['Salt'] 			= $Pwd['salt'];
					
					$data['Status']			= 'Active';
					$data['LastLogin'] 		= '';
					
					$data['LastUpdated']	= time();
					$data['Role']			= '2';
					
					$table=$table1;
					$inserted_Id = $this->Commonmodel->insertdata($table,$data);
					
					if($inserted_Id>0)
					{
						$data = array();
						
						$data['SLNO'] = $inserted_Id;
						$data['Owner_Name'] = trim($this->input->post('owner_name'));
						
						$data['Email'] = trim($this->input->post('email'));
						$toemail	   = trim($this->input->post('email'));
						
						
						$data['Phone'] = trim($this->input->post('phone'));
						
						$data['Address'] = trim($this->input->post('store_addr'));
						$data['Location'] = trim($this->input->post('location'));
						$data['City'] = trim($this->input->post('City'));
						
						$data['LastUpdated'] = date('Y-m-d H:i:s');

						$inserted_Id = '';
						$table=$table2;
						
						$inserted_Id = $this->Commonmodel->insertdata($table,$data);
						
						if($inserted_Id>0)
						{
							
							$subject = "Registration";
							$uid_encoded = base64_encode($inserted_Id);
						
						$template = ' <div style="margin:0px; padding:0px; font-family:calibri; font-size:14px;"> <div style="width:700px;  margin:auto; background:#79ad29; padding:27px 0px 27px 0px;"> <div style="width:590px; border-bottom:none;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6;"> <div style="width:239px; height:64px; float:left;"> <img src="'.base_url().'resources/site/img/demo-store-1401086283.jpg" /> </div> <div style="width:190px; float:right; height:64px;"> <p style="font-family:calibri; float:right; font-size:16px; font-style:italic; color:#122856;"><a href="javascript:void(0)" style="text-decoration:none; color:#6da218; line-height:64px; height:64px; float:left;" target="_blank">www.website.com</a></p> </div> <div style="clear:both"></div> </div><div style="width:590px;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6; border-top:0px;"><p style="margin-bottom:15px; font-size:14px;">Registration successful below are your login credentials:</p><div class="order-colm row" style="width:540px;padding: 25px;border: 1px solid #eee;box-shadow: 0 0 5px #ccc;margin-bottom: 15px;"><h3 class="text-left" style="border-bottom: 1px solid #eee;padding: 0 0 15px;margin-bottom: 15px;color: #212121;    font-weight: 500;line-height: 1.1; margin-top:19px; font-size:30px;">Login Credential Details</h3><div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;"><div class="row"><span style="font-weight: 600;color: #000;width:225px;float:left; font-size:14px;">UserId</span><span style="font-weight: 600;color: #000;width:112px;float:left; font-size:14px; text-align:center;">Password</span></div></div>';
						
						
						$template.='<div style="width:530px;display:table;height:auto;"> <div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;">  <div class="row">  <div  style="font-weight: 400;color: #000;width:225px;float:left; font-size:14px;"> <span style="overflow: hidden; max-width: 160px; white-space: pre; text-overflow: ellipsis; float: left; display: inline-block; margin-right: 5px; float:left;">'.trim($this->input->post('user_name')).'</span></div> <span style="font-weight: 400;color: #000;width:112px;float:left; font-size:14px; text-align:center;">'.trim($this->input->post('password')).'</span></div></div></div>';	
						
						
						$template.= '<div style="width:530px;display:table;height:auto;">
						<div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;">
						<span style="font-weight: 600;color: #000;width:337px;float:left; font-size:14px;"></span>
						<span style="font-weight: 600;color: #000;width:112px;float:right; font-size:14px;text-align:right;"></span>
						</div>
						</div>
						
						<a href="'.base_url('confirm-registration/'.$uid_encoded).'" style="width:200px; height:60px; line-height:60px; font-size:20px; margin:15px 0 0; float:right; overflow:hidden; text-align:center;color: white;background-color: #7ebb1e;border-color: #7ebb1e; text-decoration:none;">
						Confirmation registration
						</a>
						<div style="clear:both;"></div>
						</div>
						
						</div>
						<div style="width:590px; background:#fff;color:#222; padding: 26px 26px 16px; margin:auto;  border:1px solid #d6d5d6; border-top:none;  background:#eee;">
						<p style="color:rgb(51,51,51); font-size:13px; text-align:center;margin-bottom:5px;"> Ecom Food &ensp; &ensp; Email : <a href="javascript:void(0)" style="text-decoration:none; color:rgb(51,51,51);">emailid@website.com </a></p>
						</div>
						</div>
						
						</div>';
							
							$toemail = trim($this->input->post('email'));
							
							$this->sendEmail($toemail,$subject,$template);				
							
							
							$msg = "<div class='alert alert-success'>Successfully added a user/franchise</div>";
							$this->session->set_flashdata('user_franchise_added',$msg);
							redirect(base_url('admin-view-user'));
						}
						else
						{
							$msg = "<div class='alert alert-danger'>Unable to adduser/franchise</div>";
							$this->session->set_flashdata('user_franchise_added',$msg);
							redirect(base_url('admin-add-user'));
						}
						
						
					}
					else
					{
							$msg = "<div class='alert alert-danger'>Unable to add user</div>";
							$this->session->set_flashdata('user_franchise_added',$msg);
							redirect(base_url('admin-add-user'));
					}
					
					
				}
		}
		else
		{
			$this->load->view('Admin/adduser');
		}
		$this->load->view(FOOTER);
	
	
	}//assuser ends here
	

	public function edituser($userid)
	{
		
		
		$this->load->view(HEADER);
		
		if($this->input->post('Edit_User_Btn'))
		{
			
			$this->form_validation->set_rules($this->config->item('edit_user_franchise'));
			
			if( $this->form_validation->run()===false)
			{
				
				$this->load->view('Admin/edituser');	
			}
			else
			{
				
				
				$setData['UserName'] 		=	trim($this->input->post('edit_user_name'));
				$setData['Status']			=	trim($this->input->post('edit_store_status'));
				$setData['LastUpdated']		=	time();
				$setData['LastLogin']		= 	date('Y-m-d H:i:s');
				
				
				$setData1['Owner_Name']		= 	trim($this->input->post('edit_owner_name'));
				$setData1['Email']			=	trim($this->input->post('edit_email'));
				$setData1['Phone']			=	trim($this->input->post('edit_phone'));
				$setData1['Address']		=	trim($this->input->post('edit_store_addr'));
				$setData1['Location'] 		=	trim($this->input->post('edit_location'));
				$setData1['City'] 		=	trim($this->input->post('edit_city'));
				//$setData1['BrandId'] 		=	trim($this->input->post('brandname'));
				
				$setData1['LastUpdated']	=	date('Y-m-d H:i:s');
				
				$cond['SLNO']				= 	trim($this->input->post('employeeSLNO'));
				
				$table1="users";
				$table2="userdetails";
				
				//check whether the user is inactive and user has not yet logged in yet means new user registrations
				
				$qrey = $this->Commonmodel->getrows($table1,$cond,$order_by='',$order_by_field='',$limit='');
				
				foreach($qrey->result() as $data)
				{
					$LastLogin 	= 	$data->LastLogin;
					$Status 	= 	$data->Status;
					$UserName 	=	$data->UserName; 
				}
				
				if( $this->Commonmodel->updatedata($table1,$setData,$cond) )
				{
					// send an email to the user
					//check whether the user is inactive and user has not yet logged in yet means new user registrations
					
					//if($LastLogin=='0000-00-00 00:00:00' && $Status=='New')
					//if($Status=='New')
					if($LastLogin=='0000-00-00 00:00:00' && $Status=='New')
					{
						
						
						$subject = "Account Approved";
							
						
						$template = ' <div style="margin:0px; padding:0px; font-family:calibri; font-size:14px;"> <div style="width:700px;  margin:auto; background:#79ad29; padding:27px 0px 27px 0px;"> <div style="width:590px; border-bottom:none;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6;"> <div style="width:239px; height:64px; float:left;"> <img src="'.base_url().'resources/site/img/demo-store-1401086283.jpg" /> </div> <div style="width:190px; float:right; height:64px;"> <p style="font-family:calibri; float:right; font-size:16px; font-style:italic; color:#122856;"><a href="javascript:void(0)" style="text-decoration:none; color:#6da218; line-height:64px; height:64px; float:left;" target="_blank">www.website.com</a></p> </div> <div style="clear:both"></div> </div><div style="width:590px;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6; border-top:0px;"><p style="margin-bottom:15px; font-size:14px;">Your account has been approved by Cold Care, you can login with your login credentials:</p><div class="order-colm row" style="width:540px;padding: 25px;border: 1px solid #eee;box-shadow: 0 0 5px #ccc;margin-bottom: 15px;"><h3 class="text-left" style="border-bottom: 1px solid #eee;padding: 0 0 15px;margin-bottom: 15px;color: #212121;    font-weight: 500;line-height: 1.1; margin-top:19px; font-size:30px;">Login Credential Details</h3><div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;"><div class="row"><span style="font-weight: 600;color: #000;width:225px;float:left; font-size:14px;">UserId</span><span style="font-weight: 600;color: #000;width:112px;float:left; font-size:14px; text-align:center;">Password</span></div></div>';
						
						
						$template.='<div style="width:530px;display:table;height:auto;"> <div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;">  <div class="row">  <div  style="font-weight: 400;color: #000;width:225px;float:left; font-size:14px;"> <span style="overflow: hidden; max-width: 160px; white-space: pre; text-overflow: ellipsis; float: left; display: inline-block; margin-right: 5px; float:left;">'.$UserName.'</span></div> <span style="font-weight: 400;color: #000;width:112px;float:left; font-size:14px; text-align:center;">**************</span></div></div></div>';	
						
						
						$template.= '<div style="width:530px;display:table;height:auto;">
						<div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;">
						<span style="font-weight: 600;color: #000;width:337px;float:left; font-size:14px;"></span>
						<span style="font-weight: 600;color: #000;width:112px;float:right; font-size:14px;text-align:right;"></span>
						</div>
						</div>
						
						
						<div style="clear:both;"></div>
						</div>
						
						</div>
						<div style="width:590px; background:#fff;color:#222; padding: 26px 26px 16px; margin:auto;  border:1px solid #d6d5d6; border-top:none;  background:#eee;">
						<p style="color:rgb(51,51,51); font-size:13px; text-align:center;margin-bottom:5px;"> Ecom Food &ensp; &ensp; Email : <a href="javascript:void(0)" style="text-decoration:none; color:rgb(51,51,51);">emailid@website.com </a></p>
						</div>
						</div>
						
						</div>';
							
							$toemail = trim($this->input->post('edit_email'));
							//echo $toemail;
							//echo "<br>".$template;
							// exit; 
							$this->sendEmail($toemail,$subject,$template);	
							
					
					}					
					
					
					if( $this->Commonmodel->updatedata($table2,$setData1,$cond) )
					{
						$msg= "<div class='alert alert-success'>user details updated successfully</div>";
						$this->session->set_flashdata('update_msg',$msg);
					}
					else
					{
						$msg= "<div class='alert alert-danger'>Unable to update user details</div>";
						$this->session->set_flashdata('update_msg',$msg);							
					}
					redirect(base_url('admin-edit-user/').$this->uri->segment(2));
				}
				else
				{
					$msg= "<div class='alert alert-danger'>Unable to update the form data</div>";
					$this->session->set_flashdata('update_msg',$msg);	
					redirect(base_url('admin-edit-user/').$this->uri->segment(2));				
				}
				
				
				
			
			}
		}
		else
			$this->load->view('Admin/edituser');
		
		$this->load->view(FOOTER);
	
	
	}
	



###########################################################################################################
###########################################################################################################

/*  Mangaing users ends here */

###########################################################################################################
###########################################################################################################


###########################################################################################################
###########################################################################################################





###########################################################################################################
###########################################################################################################

/*  Mangaing brands starts here */

###########################################################################################################
###########################################################################################################	


public function addbrand()
{
	
	
	$this->load->view(HEADER);
	if($this->input->post('Add_Brand_Btn'))
	{
		$this->form_validation->set_rules($this->config->item('Add_brand'));
		
		if( $this->form_validation->run() === false)
			{
				$this->load->view('Admin/addbrand');		
			}
		else
			{
				$table='brands';
				$insertData = array();
				
				//$file_name="resources/brand-logos/".$this->input->post('add_brand_name')."-".str_replace(" ","-",$_FILES['brandlogo']['name']);
				//$this->uploadPath
				
				
				$file_name=$this->uploadbrandPath.$this->input->post('add_brand_name')."-".str_replace(" ","-",$_FILES['brandlogo']['name']);

				move_uploaded_file($_FILES['brandlogo']['tmp_name'],$file_name);
				
				$insertData['BrandName']	= trim($this->input->post('add_brand_name'));
				$insertData['LastUpdated'] 	= time();
				$insertData['LogoPath'] 	= $file_name;
				$insertData['Status'] 		= 'Active';
				
				if( $this->Commonmodel->insertdata($table,$insertData) )
				{
					$msg = "<div class='alert alert-success'>New brand added successfully</div>";
					$this->session->set_flashdata('brand_add_status',$msg);
				}
				else
				{
					$msg = "<div class='alert alert-success'>New brand added successfully</div>";
					$this->session->set_flashdata('brand_add_status',$msg);
				}
				
				redirect(base_url('admin-view-brands'));
				
			}
	}
	else
		$this->load->view('Admin/addbrand');
		
	$this->load->view(FOOTER);
}


public function editbrand()
{
	$this->load->view(HEADER);
	if($this->input->post('Edit_Brand_Btn'))
	{
		$this->form_validation->set_rules($this->config->item('Edit_brand'));

		if( $this->form_validation->run() === false)
		{
			$this->load->view('Admin/editbrand');		
		}
		else
		{
			$cond = array();
			$cond['BrandId'] = trim($this->input->post('BrandId'));
			$setdata=array();
			
		if(is_uploaded_file($_FILES['edit_brandlogo']['tmp_name']))
		{	
			$file_type = $_FILES['edit_brandlogo']['type'];
			
			if($file_type=="image/jpg" || $file_type=="image/jpeg" || $file_type==="image/png")
			{
				$file_size = $_FILES['edit_brandlogo']['size'];
				$max_size = 1014*1024*2;
				if( $max_size>=$file_size)
				{
					//$file_name="resources/brand-logos/".$this->input->post('edit_brand_name')."-".str_replace(" ","-",$_FILES['edit_brandlogo']['name']);
					
					$file_name=$this->uploadbrandPath.$this->input->post('edit_brand_name')."-".str_replace(" ","-",$_FILES['edit_brandlogo']['name']);
					
					move_uploaded_file($_FILES['edit_brandlogo']['tmp_name'],$file_name);
					$setdata['LogoPath']  =$file_name;
				}
				else
				{
					$msg = "<div class='alert alert-danger'>Upload image of size below 2MB</div>";
					$this->session->set_flashdata('file_eror',$msg);
					redirect(base_url('admin-edit-brand/').$this->input->post('BrandId'));
				}
			
			}
			else
			{
				$msg = "<div class='alert alert-danger'>Select Jpeg or png type</div>";
				$this->session->set_flashdata('file_eror',$msg);
				redirect(base_url('admin-edit-brand/').$this->input->post('BrandId'));
			}
			
		}
			
			$setdata['BrandName']  = str_replace(" ","-",ucwords(trim(strtolower($this->input->post('edit_brand_name')))));
			
			$setdata['Status']  = trim($this->input->post('brand_status'));
			$setdata['LastUpdated']  = time();
			
			$table='brands';
			
			if( $this->Commonmodel->updatedata($table,$setdata,$cond) )
			{
				$msg = "<div class='alert alert-success'>Brand Name updated successfully </div>";
				$this->session->set_flashdata('Brand_update_status',$msg);
			}
			else
			{
				$msg = "<div class='alert alert-danger'>Unable to update brand name</div>";
				$this->session->set_flashdata('Brand_update_status',$msg);
			}
			redirect(base_url('admin-edit-brand/').$this->uri->segment(2));
		}
	}
	else
	$this->load->view('Admin/editbrand');
	
	$this->load->view(FOOTER);
}


###########################################################################################################
###########################################################################################################

/*  Mangaing brands ends here */

###########################################################################################################
###########################################################################################################	



	
	
	
	
###########################################################################################################
###########################################################################################################

/*  Add category starts here */

###########################################################################################################
###########################################################################################################	
	
	
public function addcategory()
{
	$this->load->view(HEADER);
	if($this->input->post('Add_Category_Btn'))
	{
			$this->form_validation->set_rules($this->config->item('Add_Category'));

			if( $this->form_validation->run()=== false )
			{
				//echo validation_errors(); exit; 
				$this->load->view('Admin/addcategory');		
			}
			else
			{
				$insertdata = array();
				$table='categories';
                
                
                //$file_name="resources/category-logos/".str_replace(" ","-",$this->input->post('category'))."-".str_replace(" ","-",$_FILES['categorylogo']['name']);
				
				
				$file_name=$this->uploadcategoryPath.str_replace(" ","-",$this->input->post('category'))."-".str_replace(" ","-",$_FILES['categorylogo']['name']);
				move_uploaded_file($_FILES['categorylogo']['tmp_name'],$file_name);
                
				
				$insertdata['Category_Name'] = trim($this->input->post('category'));
			//	$insertdata['BrandId'] = trim($this->input->post('brandname'));		
				$insertdata['LogoPath'] = $file_name;
                $insertdata['Status'] = 'Active';		
				$insertdata['LastUpdated'] = time();
				
				if( $this->Commonmodel->insertdata($table,$insertdata) )
				{
					$msg = "<div class='alert alert-success'>Category added succesfully</div>";
					$this->session->set_flashdata('category-add-status',$msg);
				}
				else
				{
					$msg = "<div class='alert alert-danger'>Failed to add category </div>";
					$this->session->set_flashdata('category-add-status',$msg);
				}
				
				redirect(base_url('admin-view-categories'));
			}
	}
	else
		$this->load->view('Admin/addcategory');
	
	$this->load->view(FOOTER);
}

public function editcategory()
{
	$this->load->view(HEADER);
	
	$cond=array();
	$cond['CategoryID']= $this->uri->segment(2);
	$result['data']= $this->Commonmodel->getcategories($cond);

	if($this->input->post('Edit_Category_Btn'))
	{
			$this->form_validation->set_rules($this->config->item('Edit_Category'));
			
			if($this->form_validation->run() ===  false)
			{
				$this->load->view('Admin/editcategory',$result);
			}
			else
			{
				$cond=array();
				$cond['CategoryID'] = $this->input->post('categ_id');
				
				$setdata = array();
                
            if(is_uploaded_file($_FILES['editcategorylogo']['tmp_name']))
		      {
				  	
                $file_type = $_FILES['editcategorylogo']['type'];

                if($file_type=="image/jpg" || $file_type=="image/jpeg" || $file_type==="image/png")
                {
                    $file_size = $_FILES['editcategorylogo']['size'];
                    $max_size = 1014*1024*2;
                    if( $max_size>=$file_size)
                    {
                        //$file_name="resources/category-logos/".$this->input->post('editcategory')."-".str_replace(" ","-",$_FILES['editcategorylogo']['name']);
						
						$file_name=$this->uploadcategoryPath.$this->input->post('editcategory')."-".str_replace(" ","-",$_FILES['editcategorylogo']['name']);
                        move_uploaded_file($_FILES['editcategorylogo']['tmp_name'],$file_name);
                        $setdata['LogoPath']  =$file_name;
                    }
                    else
                    {
                        $msg = "<div class='alert alert-danger'>Upload image of size below 2MB</div>";
                        $this->session->set_flashdata('file_eror',$msg);
                        redirect(base_url('admin-edit-brand/').$this->uri->segment(2));
                    }

                }
                else
                {
                    $msg = "<div class='alert alert-danger'>Select Jpeg or png type</div>";
                    $this->session->set_flashdata('file_eror',$msg);
                    redirect(base_url('admin-edit-brand/').$this->uri->segment(2));
                }
			
		
			  }
           
				$setdata['Category_Name'] = $this->input->post('editcategory');
				$setdata['Status'] = $this->input->post('categ_status');
				$setdata['LastUpdated'] = time();
				
				$table= 'categories';
				
				
				if($this->Commonmodel->updatedata($table,$setdata,$cond))
				{
					$msg="<div class='alert alert-success'>Category updated successfully</div>";
					$this->session->set_flashdata('category_upd_status',$msg);
				}
				else
				{
					$msg="<div class='alert alert-danger'>Category updated successfully</div>";
					$this->session->set_flashdata('category_upd_status',$msg);
				}
				redirect(base_url('admin-edit-category/').$this->input->post('categ_id'));
				
			}
	}
	else
		$this->load->view('Admin/editcategory',$result);
	
	$this->load->view(FOOTER);
}
	
	
	
	
	
###########################################################################################################
###########################################################################################################

/*  Add category ends here */

###########################################################################################################
###########################################################################################################		


#######################################################################################################################
#######################################################################################################################

/* Add subcategpry starts here*/

#######################################################################################################################
#######################################################################################################################


public function addsubcategory()
{
	$this->load->view(HEADER);
	if($this->input->post('Add_Sub_Category'))
	{
		$this->form_validation->set_rules($this->config->item('AddSubcateg'));
			
			if($this->form_validation->run() ===  false)
			{
				$this->load->view('Admin/addsubcategory');
			}
			else
			{
				$table = SUBCATEGORIES;
				$insertdata = array();
				
				//$insertdata['BrandId'] = $this->input->post('brand');
				$insertdata['CategId'] = $this->input->post('category');
				$insertdata['SubCategory'] = $this->input->post('subcategory');
				$insertdata['Status'] = 'Active';
				$insertdata['LastUpdated'] = time();
				
				if( $this->Commonmodel->insertdata($table,$insertdata))
				{
					$msg = "<div class='alert alert-success'>Subcategory added successfully</div>";
               		 $this->session->set_flashdata('subcat_added_status',$msg);
				}
				else
				{
					$msg = "<div class='alert alert-danger'>Failed to add subcategory</div>";
               		 $this->session->set_flashdata('subcat_added_status',$msg);
				}

				redirect(base_url('admin-view-subcategories'));
				
			}
	}
	else
		$this->load->view('Admin/addsubcategory');
		
	$this->load->view(FOOTER);
}






#######################################################################################################################
#######################################################################################################################

/* Add subcategpry starts here*/

#######################################################################################################################
#######################################################################################################################


public function editsubcategory()
{

	$this->load->view(HEADER);
	
	$this->db->where('Sub_CatId',$this->uri->segment(2));
	$qry = $this->db->get(SUBCATEGORIES);
	
	if($qry->num_rows()>0)
	{
		$res['data']=$qry;
		
		if( $this->input->post('Edit_Sub_Category') )
		{
			$table=SUBCATEGORIES;
			
			$updateData	=	array();
			$cond		=	array();	
			
			$cond['Sub_CatId'] 		=	$this->input->post('subcatid');	
		//	$updateData['BrandId'] = $this->input->post('brand');
			$updateData['CategId'] = $this->input->post('category');
			
			$updateData['SubCategory'] = $this->input->post('subcategory');
			$updateData['LastUpdated'] = time();
			
			if( $this->Commonmodel->updatedata($table,$updateData,$cond) )
			{
				$msg = "<div class='alert alert-success'>Subcategory updated successfully</div>";
               		 $this->session->set_flashdata('subcat_edit_status',$msg);
			}
			else
			{
				$msg = "<div class='alert alert-danger'>failed to update</div>";
               		 $this->session->set_flashdata('subcat_edit_status',$msg);
			}
			redirect(base_url('admin-edit-subcategory/').$this->uri->segment(2));
			
			
			
		}
		else			
			$this->load->view('Admin/editsubcategory',$res);	
		
	}
	else
	{
		redirect(base_url('admin-view-subcategories'));	
	}
		
	$this->load->view(FOOTER);
}

########################################################################################################################################
########################################################################################################################################
########################################################################################################################################

/* Add base uom starts here */

########################################################################################################################################
########################################################################################################################################
########################################################################################################################################


public function addbaseuom()
{
	$this->load->view(HEADER);
	
	if($this->input->post('Add_Base_UOM') )
	{
		$this->form_validation->set_rules($this->config->item('addbaseuom'));
			
			if($this->form_validation->run() ===  false)
			{
				$this->load->view('Admin/addbaseuom');
			}
			else
			{
				
				$table="baseuom";	
				$insertdata = array();
				
				$insertdata['Baseuom'] = $this->input->post('Base_UOM');
				$insertdata['Status']  = "Active";
				$insertdata['LastUpdated'] = time();
				
				if( $this->Commonmodel->insertdata($table,$insertdata))
				{
					$msg = "<div class='alert alert-success'>Base UOM added successfully</div>";
               		$this->session->set_flashdata('baseuom_status',$msg);
				}
				else
				{
					$msg = "<div class='alert alert-success'>Failed to add Base UOM </div>";
               		$this->session->set_flashdata('baseuom_status',$msg);
				}
				
				redirect(base_url('admin-view-base-uom'));
			}
		
		
	}
	else
		$this->load->view('Admin/addbaseuom');
	
	$this->load->view(FOOTER);
}







########################################################################################################################################
########################################################################################################################################
########################################################################################################################################

/*  Edit base uom Starts here */

########################################################################################################################################
########################################################################################################################################
########################################################################################################################################


public function editbaseuom()
{
	
	$this->load->view(HEADER);
	
	$table="baseuom";
	$cond = array();
	$cond['baseid']= $this->uri->segment(2);

	$this->db->where($cond);
	$qry = $this->db->get($table);

	if($qry!='0')
	{
		$data['res'] = $qry;
		
		if($this->input->post('Edit_Base_UOM'))
		{
			$this->form_validation->set_rules($this->config->item('editbaseuom'));
			
			if($this->form_validation->run() ===  false)
			{
				$this->load->view('Admin/editbaseuom',$data);
			}
			else
			{
				$table="baseuom";
				$cond = array();
				
				$cond['baseid'] = $this->uri->segment(2);
				
				$updateData = array();
				
				$updateData['Baseuom'] = $this->input->post('Base_UOM');
				$updateData['LastUpdated'] = time();
				
				if( $this->Commonmodel->updatedata($table,$updateData,$cond) )
				{
					$msg = "<div class='alert alert-success'>Base UOM Updated successfully</div>";
               		$this->session->set_flashdata('baseuom_updated',$msg);
				}
				else
				{
					$msg = "<div class='alert alert-danger'>Unable to update Base UOM </div>";
               		$this->session->set_flashdata('baseuom_updated',$msg);
				}
				
				redirect(base_url('admin-edit-base-uom/').$this->uri->segment(2));
				
			}
		}
		else		
		$this->load->view('Admin/editbaseuom',$data);	
	}
	else
	{
		redirect(base_url('admin-view-base-uom'));
	}
	
	
	
	$this->load->view(FOOTER);


	
}


########################################################################################################################################
########################################################################################################################################
########################################################################################################################################

/*  Edit base uom ends here */

########################################################################################################################################
########################################################################################################################################
########################################################################################################################################






    
    
####################################################################################################
####################################################################################################

/*  Add Measuement starts here */

####################################################################################################
####################################################################################################
    
public function addmeasurement()
{
   $this->load->view(HEADER) ;
    if($this->input->post('Add_Unit_Btn'))
    {
        $this->form_validation->set_rules($this->config->item('add_unit'));
        
        if($this->form_validation->run() === false)
        {
            $this->load->view('Admin/addmeasurement');            
        }
        else
        {
            $table = 'measurements';
            $insertdata = array();
            
            $insertdata['MeasurementUnit']=trim($this->input->post('unit'));
            $insertdata['Status']='Active';
            $insertdata['LastUpdated']  =time();
            
            if( $this->Commonmodel->insertdata($table,$insertdata) )
            {
                $msg = "<div class='alert alert-success'>Measurement unit added successfully</div>";
                $this->session->set_flashdata('unit_added_status',$msg);
            }
            else
            {
                $msg = "<div class='alert alert-danger'>Failed to add a mesurement unit</div>";
                $this->session->set_flashdata('unit_added_status',$msg);
            }
            redirect(base_url('admin-view-measurements'));
            
        }
    }
    else
        $this->load->view('Admin/addmeasurement');
    
    $this->load->view(FOOTER) ;

}
    
    

####################################################################################################
####################################################################################################

/*  Add Measuement ends here */

####################################################################################################
####################################################################################################    

 

        
####################################################################################################
####################################################################################################

/*  Edit Measuement starts here */

####################################################################################################
####################################################################################################  
    public function editmeasurement()
    {
        $this->load->view(HEADER);
        if($this->input->post('Edit_unit_Btn'))
        {
            $this->form_validation->set_rules($this->config->item('edit_measurement'));
            if($this->form_validation->run() === false)
            {
                 $this->load->view('Admin/editmeasurement');
            }
            else
            {
                $table = 'measurements';
                $setdata = array();
                $cond = array();
                $cond['MeasurementId'] = $this->input->post('measurementid');
                
                $setdata['MeasurementUnit'] =   $this->input->post('edit_measurement');
                $setdata['Status']          =   $this->input->post('unit_status');
                $setdata['LastUpdated']     =   time();
                
                if( $this->Commonmodel->updatedata($table,$setdata,$cond) )
                {
                    $msg = "<div class='alert alert-success'>Measurement Updated Successfully</div>";
                    $this->session->set_flashdata('Unit_updated_status',$msg);
                }
                else
                {
                    $msg = "<div class='alert alert-danger'>Failed to update </div>";
                    $this->session->set_flashdata('Unit_updated_status',$msg);
                }
                redirect(base_url('admin-edit-measurement/').$this->uri->segment(2));
            }
            
            
        }
        else
            $this->load->view('Admin/editmeasurement');
        $this->load->view(FOOTER);
    }
        
    
    
####################################################################################################
####################################################################################################

/*  Edit Measuement ends here */

####################################################################################################
####################################################################################################  
  
    
##############################################################################################    
##############################################################################################
    /* Add a product starts here */
##############################################################################################    
##############################################################################################    
    
public function addproduct()
{
    $this->load->view(HEADER);
    $cond=array();

    //calling the brands
    $table='brands';
    $brands['brand_data']= $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
    if($brands['brand_data']!='0')
    {
        
    }
    else
    {
        $brands['brand_data']=array();
    }
    //calling the brands here
    
    //caling the measurement units
    
    $table = 'measurements';
    $brands['units_data']= $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
    if($brands['units_data']!='0')
    {
        
    }
    else
    {
        $brands['units_data']=array();
    }
    //caling the measurement units ends here 
    
    if($this->input->post('Add_Product_Btn'))
    {
        $this->form_validation->set_rules($this->config->item('add_product'));
        if($this->form_validation->run() === false )
        {
            $this->load->view('Admin/addproduct',$brands);
        }
        else
        {
         //   $file_name = "resources/product-images/".time()."_".str_replace(" ","-",$_FILES['product_image']['name']);
		 
		 $file_name = $this->uploadproductPath.time()."_".str_replace(" ","-",$_FILES['product_image']['name']);
		    
            if( move_uploaded_file($_FILES['product_image']['tmp_name'],$file_name) )
            {
                $cond = array();
                $table='products';
                
                $insertdata = array();
                
                $insertdata['BrandId'] = $this->input->post('brand');
                $insertdata['Category_Id'] = $this->input->post('category');
				
				$insertdata['Sub_CatId'] = $this->input->post('subcategory');
				
				$insertdata['MeasurementUnit'] = $this->input->post('unit');
				$insertdata['BaseUOM'] = $this->input->post('baseuom');
				
                $insertdata['ProductName'] = ucwords(str_replace("-"," ",strtolower(trim($this->input->post('product_name')))));
				$insertdata['ProductDesc'] = $this->input->post('prdct_desc');
				$insertdata['Status'] = $this->input->post('prd_status');
				$insertdata['AddedBy']= $this->session->userdata('username');
				 
               $insertdata['Type'] = ucwords(str_replace("-"," ",strtolower(trim($this->input->post('subcategoryType')))));
				//$insertdata['NetWeight'] = $this->input->post('netweight');
				
			//	$insertdata['GrossWeight'] = $this->input->post('grossweight');
				//$insertdata['Qty'] = $this->input->post('quantity');
				$insertdata['ReadyTo'] = $this->input->post('readyto');
				
               // $insertdata['ProductPrice'] = $this->input->post('product_price');
                $insertdata['ProductImage'] = $file_name;
                
                $insertdata['LastUpdated'] = time();
                $insertdata['Status'] = "Active";

                $insertdata['AddedOn'] = date('Y-m-d H:i:s');
               
		#	echo "<pre>";   print_r($insertdata); exit; 
                $ide = $this->Commonmodel->insertdata($table,$insertdata);
                if($ide>0)
                {
                    $cond=array();
                   
                    $Code_char = 'ABCstuvDEFGHITabcdefgJKMNOPQhijURoprqSTUklmnVWwxzyXYZ';
                    
                    $randomString = str_shuffle($Code_char);
                    $randStr = substr($randomString,1,7);
                    
                    $productCode=$randStr.$ide;
                    
                    $cond=array();
                    $cond['ProductId']=$ide;
                    
                    $table='products';
                    
                    $setdata = array();
                    
                    $setdata['Product_Code'] = $productCode;
                    if($this->Commonmodel->updatedata($table,$setdata,$cond))
                    {
						
						//insert the packaging type for the product into the packaging table
						
						
						$NetWeight = $this->input->post('netweight');
						$GrossWeight = $this->input->post('grossweight');
						
						$Qty = $this->input->post('quantity');
						$ProductPrice = $this->input->post('product_price');
						
						$prdctid = $ide;
						
						$table='packagintypes';
						$packsinsert = array();
						
						
						for($i=0;$i<sizeof($NetWeight);$i++)
						{
							$packsinsert['Netweight'] = 	$NetWeight[$i];
							$packsinsert['Grossweight'] = 	$GrossWeight[$i];
							$packsinsert['Quantity'] = 	$Qty[$i];
							$packsinsert['Price'] = 	$ProductPrice[$i];
						
							$packsinsert['ProductId'] = $prdctid;
							$packsinsert['Lastupdated'] = time();
							
							$this->Commonmodel->insertdata($table,$packsinsert);
							
						}
						
						//insert the packaging type for the product into the packaging table ends here 
						 
						 
						
						
						
					
					//check whether the subcategory type exists in the 'subcattypes' table or not
					if( trim($this->input->post('subcategoryType')) !='')
					{
						$cond = array();
						$cond['Type'] = ucwords(str_replace("-"," ",trim($this->input->post('subcategoryType'))));
						$data = array();
						$data['Type']= ucwords(str_replace("-"," ",trim($this->input->post('subcategoryType'))));
						$data['CategoryId'] =  trim($this->input->post('category'));
						$table="subcattypes";
						
						if($this->Commonmodel->checkexists($table,$cond))
						{
							
						}
						else
						{
							$this->db->insert($table,$data);	
						}
					}
					
                    $msg="<div class='alert alert-success'>Product added successfully</div>";
                    $this->session->set_flashdata('add_product_status',$msg);
                    }
                    else
                    {
                         $msg="<div class='alert alert-danger'>Product added successfully but failed tp generate Product Code</div>";
                    $this->session->set_flashdata('add_product_status',$msg);
                    }
                     redirect(base_url('admin-view-products'));
                }
                else
                {
                    $msg="<div class='alert alert-danger'>!!!Retry, Unable to add product</div>";
                    $this->session->set_flashdata('add_product_status',$msg);
                    redirect(base_url('admin-add-product'));
                }
            }
            else
            {
                $msg="<div class='alert alert-danger'>!!!Retry, Unable to add product</div>";
                $this->session->set_flashdata('add_product_status',$msg);
                redirect(base_url('admin-add-product'));
            }
            
        }
    }
    else
        $this->load->view('Admin/addproduct',$brands);
    $this->load->view(FOOTER);
    
}
    

    
##############################################################################################    
##############################################################################################
    /* Add a product ends here */
##############################################################################################    
##############################################################################################    





##############################################################################################    
##############################################################################################
    /* Edit a product starts here */
##############################################################################################    
##############################################################################################    
    
public function editproduct()
{
    $this->load->view(HEADER);
    $cond=array();

	//get the product selected
	$table='products';
	$cond['ProductId'] = $this->uri->segment(2);
	
	$order_by='';
	$order_by_field='';
	$limit='';
	
	$data['product'] = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');

	if($data['product']=='0') //if the product is not available then it will redirect to the view products page
	{
		redirect(base_url('admin-view-products'));
	}


    //calling the brands
    $table='brands';
	 $cond=array();
    $data['brand_data']= $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
    if($data['brand_data']!='0')
    {
        
    }
    else
    {
        $data['brand_data']=array();
    }
    //calling the brands here
    
    //caling the measurement units
    
    $table = 'measurements';
	 $cond=array();
    $data['units_data']= $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
    if($data['units_data']!='0')
    {
        
    }
    else
    {
        $data['units_data']=array();
    }
    //caling the measurement units ends here 
    
    if($this->input->post('Edit_Product_Btn'))
    {
		
		//check whether the subcategory type exists in the 'subcattypes' table or not
		if( trim($this->input->post('subcategoryType')) !='')
		{
			$cond = array();
			$cond['Type'] = ucwords(str_replace("-"," ",strtolower(trim($this->input->post('subcategoryType')))));
			$data = array();
			$data['Type']= ucwords(str_replace("-"," ",strtolower(trim($this->input->post('subcategoryType')))));
			$data['CategoryId'] =  trim($this->input->post('category'));
			$table="subcattypes";
			
			if($this->Commonmodel->checkexists($table,$cond))
			{
			
			}
			else
			{
			$this->db->insert($table,$data);	
			}
		}
		
		
		
        $cond = array();
		$table='products';
		$updatedata = array();
		$file_uploaded="notuploaded";
		$file_name='';
		
		if(is_uploaded_file($_FILES['product_image']['tmp_name']))
		{
			 $file_name = "resources/product-images/".time()."_".str_replace(" ","-",$_FILES['product_image']['name']);
			 $updatedata['ProductImage'] = $file_name;
		}
		
		
						
					//update the fields 
					
					$updatedata['BrandId'] = $this->input->post('brand');
					$updatedata['Category_Id'] = $this->input->post('category');
					
					$updatedata['Sub_CatId'] = $this->input->post('subcategory');
					
					$updatedata['MeasurementUnit'] = $this->input->post('unit');
					$updatedata['BaseUOM'] = $this->input->post('baseuom');
					
					$updatedata['ProductName'] = ucwords(str_replace("-"," ",strtolower(trim($this->input->post('product_name')))));
					$updatedata['ProductDesc'] = $this->input->post('prdct_desc');
					
					$updatedata['Type'] = ucwords(str_replace("-"," ", strtolower(trim($this->input->post('subcategoryType')))));
										
					$updatedata['NetWeight'] = $this->input->post('netweight');
					
					$updatedata['GrossWeight'] = $this->input->post('grossweight');
					$updatedata['Qty'] = $this->input->post('quantity');
					$updatedata['ReadyTo'] = $this->input->post('readyto');
					
					$updatedata['ProductPrice'] = $this->input->post('product_price');
					
					
					$updatedata['LastUpdated'] = time();
					
					
		
		if(is_uploaded_file($_FILES['product_image']['tmp_name']))
		{
			$file_type = $_FILES['product_image']['type'];
			
			if($file_type=="image/jpg" || $file_type=="image/jpeg" || $file_type==="image/png")
			{
			
				$file_size = $_FILES['product_image']['size'];
				$max_size = 1014*1024*2;
				if( $max_size>=$file_size)
				{
					if(move_uploaded_file($_FILES['product_image']['tmp_name'],$file_name))
					{
						
						//if image selects
						if( $file_uploaded == "yes")
						{
							$updatedata['ProductImage']  = $file_name;
						}
						
						
						///update the fields
						$cond = array();
						$cond['ProductId'] = $this->uri->segment(2);
						
						if($this->Commonmodel->updatedata($table,$updatedata,$cond))
						{
						
						$msg = "<div class='alert alert-success'> Product edited successfully</div>";
						$this->session->set_flashdata('update_product_status',$msg);	
						redirect( base_url('admin-edit-product/').$this->uri->segment(2) );			
						
						}
						else
						{
						$msg = "<div class='alert alert-danger'> Unable to edit prodcucts </div>";
						$this->session->set_flashdata('update_product_status',$msg);	
						redirect( base_url('admin-edit-product/').$this->uri->segment(2) );					
						}
						
						
					
					}
					else
					{
						
						$msg = "<div class='alert alert-danger'> Unable to edit prodcucts Image Error </div>";
						$this->session->set_flashdata('checkProductImg',$msg);	
						redirect( base_url('admin-edit-product/').$this->uri->segment(2) );		
					}
				}//if exceeds 2 mb
				
				else
				{
					$msg = "<div class='alert alert-danger'> Upload image of size below 2MB</div>";
					$this->session->set_flashdata('checkProductImg',$msg);	
				}
			
			}//if selected type is not allowed
			else
			{
				$msg = "<div class='alert alert-danger'>Select Jpeg or png type </div>";
				$this->session->set_flashdata('checkProductImg',$msg);	
			}	
			
			redirect( base_url('admin-edit-product/').$this->uri->segment(2) );
			
		} //checks whether the pic selected for update 
		else
		{

					$cond = array();
					$cond['ProductId'] = $this->uri->segment(2);
					
					if($this->Commonmodel->updatedata($table,$updatedata,$cond))
					{
					
						$msg = "<div class='alert alert-success'> Product edited successfully</div>";
						$this->session->set_flashdata('update_product_status',$msg);	
						redirect( base_url('admin-edit-product/').$this->uri->segment(2) );			
					
					}
					else
					{
						$msg = "<div class='alert alert-danger'> Unable to edit prodcucts </div>";
						$this->session->set_flashdata('update_product_status',$msg);	
						redirect( base_url('admin-edit-product/').$this->uri->segment(2) );					
					}
			   
						
		}
		
		
		
    }
    else
        $this->load->view('Admin/editproduct',$data);
    $this->load->view(FOOTER);
    
}
    

    
##############################################################################################    
##############################################################################################
    /* Edit a product ends here */
##############################################################################################    
##############################################################################################    

	
####################################################################################################
####################################################################################################
			/* Callbacks starts here */
############################################################################################################
############################################################################################################	
public function checkUserFranchise()
{
	
	$user = trim($_POST['user_name']);
	echo $user; exit; 
	if($user!='')
	{
		$cond=array();
		$cond['UserName'] = $user;
		$table ='users';
		if( !$this->Commonmodel->checkexists($table,$cond) )
		{
			return true;
		}
		else		
			{
				$this->form_validation->set_message('checkUserFranchise','User name exists choose other');
				return false;
			}
	}
	else
		{
			$this->form_validation->set_message('checkUserFranchise','User name is required');
			return false;
		}
	
}

public function checkEditUserFranchise($user)
{
	
	
	$user = trim($user);
	if($user!='')
	{
		$cond=array();
		$cond['SLNO'] = $this->input->post('employeeSLNO');
		
		
		$table ='users';
		$res_set = $this->Commonmodel->get_single_row($table,$cond,$order_by='',$order_by_field='',$limit='');
		
		if( $res_set!='0' )
		{
			foreach($res_set->result() as $data)
			{
				$User = $data->UserName;	
			}
			if($User == $user)
			{
				return true;	
			}
			else
			{
				
				$user = trim($user);
				
				$cond=array();
				$cond['UserName'] = $user;
				$table ='users';
				if( !$this->Commonmodel->checkexists($table,$cond) )
				{
					return true;
				}
				else		
				{
					$this->form_validation->set_message('checkEditUserFranchise','User name exists choose other');
					return false;
				}
			
			}
			
		}
	}
	else
		{
			$this->form_validation->set_message('checkEditUserFranchise','User name is required');
			return false;
		}
	
}

public function checkStoreStatus($status)
{
	
	if(trim($status)=="0")
	{
		$this->form_validation->set_message('checkStoreStatus','Select Status');
		return false; 
	}
	else
		return true;
	
}

public function checkBrandName($brand)
{
	$cond = array();
	$cond = array("BrandName"=>$brand);
	
	$table='brands';
	
	if( $this->Commonmodel->checkexists($table,$cond) )
	{
		$this->form_validation->set_message('checkBrandName','Brand already exists');
		return false;
	}
	else
		return true;
}

public function checkEditBrandName($brand)
{
	
	
	$brand = trim($brand);
	if($brand!='')
	{
		$cond=array();
		$cond['BrandId'] = $this->input->post('BrandId');
		
		
		$table ='brands';
		$res_set = $this->Commonmodel->get_single_row($table,$cond,$order_by='',$order_by_field='',$limit='');
		
		if( $res_set!='0' )
		{
			foreach($res_set->result() as $data)
			{
				$Brand = $data->BrandName;	
			}
			
			if($Brand == $brand)
			{
				return true;	
			}
			else
			{
				
				$brand = trim($brand);
				
				
				
				$cond=array();
				$cond['BrandName'] = $brand;
				$table ='brands';
				if( !$this->Commonmodel->checkexists($table,$cond) )
				{
					return true;
				}
				else		
				{
					$this->form_validation->set_message('checkEditBrandName','Brand name exists choose other');
					return false;
				}
			
			}
			
		}
	}
	else
		{
			$this->form_validation->set_message('checkEditBrandName','Brand name is required');
			return false;
		}
	

}




public function CheckBrandSelect($brandId)
{
	$brandId= trim($brandId);
	if($brandId!='0')
	{
		return true;	
	}
	else
	{
		$this->form_validation->set_message('CheckBrandSelect','Select Brand Name');
		return false;	
	}
}



public function checkBrandLogo()
{
	$file_err = $_FILES['brandlogo']['error'];
	if($file_err>0)
	{
		$this->form_validation->set_message('checkBrandLogo','Select Brand Logo');	
		return false;
	}
	else
	{
		$file_type = $_FILES['brandlogo']['type'];

		if($file_type=="image/jpg" || $file_type=="image/jpeg" || $file_type==="image/png")
		{
			
			$file_size = $_FILES['brandlogo']['size'];
			$max_size = 1014*1024*2;
			if( $max_size>=$file_size)
			{
				return true;
			}
			else
			{
				$this->form_validation->set_message('checkBrandLogo','Upload image of size below 2MB');	
				return false;	
			}
			
		}
		else
		{
			$this->form_validation->set_message('checkBrandLogo','Select Jpeg or png type');	
			return false;
		}
		
	}
}

public function checkCategoryLogo()
{
        
    $file_err = $_FILES['categorylogo']['error'];
	if($file_err>0)
	{
		$this->form_validation->set_message('checkCategoryLogo','Select Category Logo');	
		return false;
	}
	else
	{
		$file_type = $_FILES['categorylogo']['type'];

		if($file_type=="image/jpg" || $file_type=="image/jpeg" || $file_type==="image/png")
		{
			
			$file_size = $_FILES['categorylogo']['size'];
			$max_size = 1014*1024*2;
			if( $max_size>=$file_size)
			{
				return true;
			}
			else
			{
				$this->form_validation->set_message('checkCategoryLogo','Upload image of size below 2MB');	
				return false;	
			}
			
		}
		else
		{
			$this->form_validation->set_message('checkCategoryLogo','Select Jpeg or png type');	
			return false;
		}
		
	}
        
    }


public function checkCategory($categ)
{
	$category = trim($categ);
	$brand = $this->input->post('brandname');
	
	$cond = array();
	$cond['BrandId']= trim($brand);
	$cond['Category_Name']= $category;
	
	$table='categories';
	
	if( $this->Commonmodel->checkexists($table,$cond) )
	{
		$this->form_validation->set_message('checkCategory','Category under this brand exists');
		return false;
	}
	else
	{
		return true;	
	}
	
}

public function checkEditCategory($editcategory)
{
	$edit_category = trim($this->input->post('editcategory'));
	$edit_brandname = trim($this->input->post('edit_brandname'));
	$edit_categ_id = trim($this->input->post('categ_id'));
	
	$cond = array();
	//$cond['BrandId'] 		= $edit_brandname;
	$cond['Category_Name'] 	= $edit_category;
	//$cond['CategoryID'] 	= $edit_categ_id;
	
	$table='categories';	 
	$res_set = $this->Commonmodel->get_single_row($table,$cond,$order_by='',$order_by_field='',$limit='');
	if($res_set!='0')
	{
//		print_r($res_set->result()); exit; 
		
		foreach($res_set->result() as $categ)
		{
			$catego= $categ->Category_Name;
			$catid = $categ->CategoryID;
		}
		if( trim($catego) == $edit_category )
		{
			if($edit_categ_id == trim($catid) )
			{
				return true;	
			}
			else
			{
				$this->form_validation->set_message('checkEditCategory','Category under this brand exists');
				return false;
			}
		}
		else
		{
			return true;
		}
		
		
	}//if user does not changes any thing then press edit button
	else
	{
		return true;			
	}// if user changes either of the field 
	
	
	
	
	
}

public function checkunitStatus($status)
{
	
	if(trim($status)=="0")
	{
		$this->form_validation->set_message('checkunitStatus','Select Measurement Unit');
		return false; 
	}
	else
		return true;
	
}    

public function checkProductImg()
{
        
    $file_err = $_FILES['product_image']['error'];
	if($file_err>0)
	{
		$this->form_validation->set_message('checkProductImg','Select Product Image');	
		return false;
	}
	else
	{
		$file_type = $_FILES['product_image']['type'];

		if($file_type=="image/jpg" || $file_type=="image/jpeg" || $file_type==="image/png")
		{
			
			$file_size = $_FILES['product_image']['size'];
			$max_size = 1014*1024*2;
			if( $max_size>=$file_size)
			{
				return true;
			}
			else
			{
				$this->form_validation->set_message('checkProductImg','Upload image of size below 2MB');	
				return false;	
			}
			
		}
		else
		{
			$this->form_validation->set_message('checkProductImg','Select Jpeg or png type');	
			return false;
		}
		
	}
        
    }
	

//check netweight 

public function checkneightweight()
{
	
	$netweight_arr = $this->input->post('netweight');
	 
	if(sizeof($netweight_arr)>0)//check whether user selects any netweight packaging or not
	{
		
		if($netweight_arr[0]<=0) //if so then check whether first packaging type is greater that zero 
		{
			$this->form_validation->set_message('checkneightweight','Net weight should be greater than zero and nonempty');
			return false;
		}
		else
		{
			for($i=1;$i<sizeof($netweight_arr);$i++) //Loop through the packaging types
			{
					if($netweight_arr[$i]<=0)// check the respective one for graterthan zero
					{
						$this->form_validation->set_message('checkneightweight','Net weight should be greater than zero');
						return false;
					}	
					
			}
		}
			
	}
	
}


//check grodssweight 

public function checkgrossweight()
{


	$grossweight_arr = $this->input->post('grossweight');
	$netweight_arr = $this->input->post('netweight');
			
	//echo sizeof($quantity_arr).":".sizeof($netweight_arr); 
	 
	if(sizeof($grossweight_arr)>0)	//check whether user selects any quantity packaging or not
	{
		
		if($grossweight_arr[0]<=0)//check if user select only one quantity packaging
		{
			$this->form_validation->set_message('checkgrossweight','Gross weight should be greater than zero and nonempty');
			return false;
		}
		else//if user selectsmultiplepricing packages
		{
			
			///get the total netweights
			if( sizeof($grossweight_arr) == sizeof($netweight_arr)) //check packaging types ofnetweight and quantity if they are equal
			{
				
			
				for($i=1;$i<sizeof($grossweight_arr);$i++) //Loop through the packaging types
				{
						if($grossweight_arr[$i]<=0)//check whether the quantity is greater that zero
						{
							$this->form_validation->set_message('checkgrossweight','Gross weight should be greater than zero');
							return false;
						}	
						
				}
			}
			else
			{
				$this->form_validation->set_message('checkgrossweight','Gross weight packages must match with net-weight package types');
				return false;
			}
		}
			
	}
	

}

//callback_checkQuantity starts here

public function checkQuantity()
{
	
	$quantity_arr = $this->input->post('quantity');
	$netweight_arr = $this->input->post('netweight');
			
	//echo sizeof($quantity_arr).":".sizeof($netweight_arr); 
	 
	if(sizeof($quantity_arr)>0)	//check whether user selects any quantity packaging or not
	{
		
		if($quantity_arr[0]<=0)//check if user select only one quantity packaging
		{
			$this->form_validation->set_message('checkQuantity','Quantity should be greater than zero and nonempty');
			return false;
		}
		else//if user selectsmultiplepricing packages
		{
			
			///get the total netweights
			if( sizeof($quantity_arr) == sizeof($netweight_arr)) //check packaging types ofnetweight and quantity if they are equal
			{
				
			
				for($i=1;$i<sizeof($quantity_arr);$i++) //Loop through the packaging types
				{
						if($quantity_arr[$i]<=0)//check whether the quantity is greater that zero
						{
							$this->form_validation->set_message('checkQuantity','Quantity should be greater than zero');
							return false;
						}	
						
				}
			}
			else
			{
				$this->form_validation->set_message('checkQuantity','Quantity packages must match with net-weight package types');
				return false;
			}
		}
			
	}
	
}

///callbak for pricing package
public function numeric_wcomma()
{
	
	$prce_arr = $this->input->post('product_price');
	$netweight_arr = $this->input->post('netweight');

	if( sizeof($prce_arr)>0)//check whether user selects any pricing packaging or not
	{
		
			if(trim($prce_arr[0])<=0 || trim($prce_arr[0])=='' )
			{
				$this->form_validation->set_message('numeric_wcomma','Price should be greater than zero');
				return false;
			}
			else
			{
				if( sizeof($prce_arr) == sizeof($netweight_arr))//check packaging types pricing and quantity if they are equal
				{		
					for($i=1;$i<sizeof($prce_arr);$i++) //Loop through the packaging types
					{
							if($prce_arr[$i]<=0)//check if user select only one quantity packaging
							{
								$this->form_validation->set_message('numeric_wcomma','Price should be greater than zero and non empty');
								return false;
							}	
							
					}
				}
				else
				{
					$this->form_validation->set_message('numeric_wcomma','Pricce Packages must match with net-weight package types');
	    		     return false;			
				}
			}

		
	}
	
	
}
    



//send email

public function sendEmail($toemail,$subject,$template)
{
	
	$sender_email  = $this->smtp_user_name;
	$user_password = $this->smtp_password;
	

	$username = 'Cold Care';
	
	// Configure email library
	$config['protocol'] = 'smtp';
	$config['smtp_host'] = 'ssl://smtp.googlemail.com';
	$config['smtp_port'] = 465;
	$config['smtp_user'] = $sender_email ;
	$config['smtp_pass'] = $user_password ;
	
	// Load email library and passing configured values to email library
	$this->load->library('email', $config);
	$this->email->set_newline("\r\n");
	
	// Sender email address
	$this->email->from($sender_email, $username);
	// Receiver email address
	$this->email->to($toemail);
	// Subject of email
	$this->email->subject($subject);
	// Message in email
	$this->email->message($template);
	
	if ($this->email->send()) 
	{
		return true;	
	}
	else
		return false;
}	
	


		
}//class ends here