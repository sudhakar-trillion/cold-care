<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Requestdispatcher extends CI_Controller {

	 public function __construct()
        {
			parent::__construct();
			date_default_timezone_set("Asia/Kolkata");
			$this->load->model('Commonmodel');
			
			$smtpdetails = $this->Commonmodel->getsmtpdetails();

				if( $smtpdetails!='0')
				{
					foreach($smtpdetails->result() as $details)
					{
						$this->smtp_user_name = $details->user;	
						$this->smtp_password = $details->password;	
					}
				}
				
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

			
			
        }//constructor ends here
		

	public function striptags($posted_data)
	{

		$requested_from =  $_SERVER['HTTP_REFERER'];
		
		
	//	if( strpos($requested_from, 'localhost') !== false)
		if( strpos($requested_from, 'trillionit.in') !== false)
		{
			//foreach($posted_data as $key=>$val) { $_POST[$key] = htmlentities( stripslashes(strip_tags($val)), ENT_QUOTES | ENT_HTML5, 'UTF-8'); }
			foreach($posted_data as $key=>$val) 
			{ 
				$str = stripslashes(str_replace("'","",$val));
				//The following to sanitize a string. It will both remove all HTML tags, and all characters with ASCII value > 127, from the string:
				$_POST[$key] = filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
					
			}
			return $_POST;	
		}
		else
		echo "!!!! Access denied !!!!"; exit; 
	}

public function registeruser()
{
	
	$_POST = $this->striptags($_POST);
	
	extract($_POST); //by using extract function we had taken the array data into the respective keys, means array values are stored in the respectives keys.
	
	$cond = array();
	
	$cond['UserName'] = trim($UserName);
	
	$table = 'users';
	
	$output_array = array();
	
	if($this->Commonmodel->checkexists($table,$cond)){//checking for the user existance
		$output_array['userId'] = 'yes';
		echo json_encode($output_array);
	}else{
		
		$cond = array();
	
	$cond['Email'] = trim($EmailId);
	
	$table = 'userdetails';
	
	$output_array = array();
	if($this->Commonmodel->checkexists($table,$cond)){//checking for the email existance
		$output_array['Email'] = 'yes';
		echo json_encode($output_array);
	}
	else
	{
		$output_array['userId'] = 'no';
		$output_array['Email'] = 'no';

//below section used to insert the data to the respective table
		
		$table1 = '';
		$table2 = '';
		
		$table1 = 'users';
		$table2 = 'userdetails';
		
		$data = array();
		
		$data['UserName'] = $this->input->post('UserName');
		$pwd = trim($this->input->post('Password'));
		
		$Pwd = $this->saltedpassword->makeITcrypt($pwd); // by using the user defined library we had make the password encrypt
		
		$data['Password']		= $Pwd['hashpassword'];
		$data['Salt'] 			= $Pwd['salt'];
		
		$data['Status']			= 'New';
		$data['LastLogin'] 		= '';
		
		$data['LastUpdated']	= time();
		$data['Role']			= '2';
		
		$table=$table1;
		//in the users table we had inserting the respective data
		$UserSLNO = $this->Commonmodel->insertdata($table,$data);
		
		
		if($UserSLNO>0)
		{
			$data = array();
			
			$data['SLNO'] = $UserSLNO;
			$data['Owner_Name'] = trim($this->input->post('StoreName'));
			
			$data['Email'] = trim($this->input->post('EmailId'));
			$data['Location'] = trim($this->input->post('Location'));
			//$data['BrandId'] = trim($this->input->post('brands_name'));
			
			$data['City'] = trim($this->input->post('City'));
			$data['LastUpdated'] = date('Y-m-d H:i:s');
	
			$inserted_Id = '';
			$table=$table2;
			//the dataken which had taken from the form is now inserting into the userdetails table
			$inserted_Id = $this->Commonmodel->insertdata($table,$data);
			
			if($inserted_Id>0)
			{
				
				//once done we are sending an email to the user
				$toemail=trim($this->input->post('EmailId'));
				$subject='Registration Success';
				
				
				$id=(double)(($UserSLNO)*526825.24);
				$uid_encoded = base64_encode($id);
				
	/* Emai template for registration for the user */			
				
				$template = ' <div style="margin:0px; padding:0px; font-family:calibri; font-size:14px;"> <div style="width:700px;  margin:auto; background:#79ad29; padding:27px 0px 27px 0px;"> <div style="width:590px; border-bottom:none;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6;"> <div style="width:239px; height:64px; float:left;"> <img src="'.base_url().'resources/site/img/demo-store-1401086283.jpg" /> </div> <div style="width:190px; float:right; height:64px;"> <p style="font-family:calibri; float:right; font-size:16px; font-style:italic; color:#122856;"><a href="javascript:void(0)" style="text-decoration:none; color:#6da218; line-height:64px; height:64px; float:left;" target="_blank">www.website.com</a></p> </div> <div style="clear:both"></div> </div><div style="width:590px;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6; border-top:0px;"><p style="margin-bottom:15px; font-size:14px;">Registration successful below are your login credentials:</p><div class="order-colm row" style="width:540px;padding: 25px;border: 1px solid #eee;box-shadow: 0 0 5px #ccc;margin-bottom: 15px;"><h3 class="text-left" style="border-bottom: 1px solid #eee;padding: 0 0 15px;margin-bottom: 15px;color: #212121;    font-weight: 500;line-height: 1.1; margin-top:19px; font-size:30px;">Login Credential Details</h3><div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;"><div class="row"><span style="font-weight: 600;color: #000;width:225px;float:left; font-size:14px;">UserId</span><span style="font-weight: 600;color: #000;width:112px;float:left; font-size:14px; text-align:center;">Password</span></div></div>';
					
					
$template.='<div style="width:530px;display:table;height:auto;"> <div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;">  <div class="row">  <div  style="font-weight: 400;color: #000;width:225px;float:left; font-size:14px;"> <span style="overflow: hidden; max-width: 160px; white-space: pre; text-overflow: ellipsis; float: left; display: inline-block; margin-right: 5px; float:left;">'.trim($this->input->post('UserName')).'</span></div> <span style="font-weight: 400;color: #000;width:112px;float:left; font-size:14px; text-align:center;">'.trim($this->input->post('Password')).'</span></div></div></div>';	


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
				
				
				
//email template for the admin
$Admintemplate = ' <div style="margin:0px; padding:0px; font-family:calibri; font-size:14px;"> <div style="width:700px;  margin:auto; background:#79ad29; padding:27px 0px 27px 0px;"> <div style="width:590px; border-bottom:none;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6;"> <div style="width:239px; height:64px; float:left;"> <img src="'.base_url().'resources/site/img/demo-store-1401086283.jpg" /> </div> <div style="width:190px; float:right; height:64px;"> <p style="font-family:calibri; float:right; font-size:16px; font-style:italic; color:#122856;"><a href="javascript:void(0)" style="text-decoration:none; color:#6da218; line-height:64px; height:64px; float:left;" target="_blank">www.website.com</a></p> </div> <div style="clear:both"></div> </div><div style="width:590px;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6; border-top:0px;"><p style="margin-bottom:15px; font-size:14px;">New user has requested for store registration:</p><div class="order-colm row" style="width:540px;padding: 25px;border: 1px solid #eee;box-shadow: 0 0 5px #ccc;margin-bottom: 15px;"><h3 class="text-left" style="border-bottom: 1px solid #eee;padding: 0 0 15px;margin-bottom: 15px;color: #212121;    font-weight: 500;line-height: 1.1; margin-top:19px; font-size:30px;">Login Credential Details</h3>
<div style="display: block;border-bottom: 1px solid #eee;width:540px;padding:10px 5px; height:auto; overflow:hidden;"><div class="row">
<span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">User Id</span>
<span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">Store Name</span>
<span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">Email Id</span
><span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">Location</span>
</div>
</div>

<div style="display: block;border-bottom: 1px solid #eee;width:540px;padding:10px 5px; height:auto; overflow:hidden;"><div class="row">
<span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">'.trim($this->input->post('UserName')).'</span>
<span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">'.trim($this->input->post('StoreName')).'</span>
<span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">'.trim($this->input->post('EmailId')).'</span
><span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">'.trim($this->input->post('Location')).'</span>
</div>
</div>


<div style="width:530px;display:table;height:auto;"> 
</div> <div style="clear:both;"></div></div></div><div style="width:590px; background:#fff;color:#222; padding: 26px 26px 16px; margin:auto;  border:1px solid #d6d5d6; border-top:none;  background:#eee;"> <p style="color:rgb(51,51,51); font-size:13px; text-align:center;margin-bottom:5px;"> Ecom Food &ensp; &ensp; Email : <a href="javascript:void(0)" style="text-decoration:none; color:rgb(51,51,51);">emailid@website.com </a></p></div></div></div>';
							
				
				
				
	//send email to the registered email			
				
			if($this->sendEmail($toemail,$subject,$template))
			{
				$Adminsubject = 'New user registraton';
				$toemail = 'storemanager@mailinator.com';
				if($this->sendEmail($toemail,$Adminsubject,$Admintemplate ))				
				$output_array['Inserted'] = 'yes';
			}
			else
				$output_array['Inserted'] = 'oopes';
		}
				
	}
	else
	{
			$output_array['Inserted'] = 'no';
	}
		
	//below section used to insert the data to the respective table ends here
		echo json_encode($output_array);
	}
	
	}
					
				
}



//edit profile

public function editprofile()
{
	
	$_POST = $this->striptags($_POST);
	
	extract($_POST);
	
	$cond = array();
	$cond['SLNO'] = trim($this->session->userdata('userslno'));
	
	
	$setdata = array();
	
	$setdata['Owner_Name'] = $edit_store_name;
	$setdata['Email'] = $edit_store_email;
	$setdata['AuthorisedEmail'] =$edit_authorised_email;
	
	$setdata['Phone'] = $edit_phone;
	$setdata['Address'] = $edit_store_addr;
	$setdata['Location'] = $edit_location;
	if(trim($edit_password)!='')
	{
		
		$Pwd = $this->saltedpassword->makeITcrypt($edit_password);
		$setData = array();
		
		$setData['Password']		= $Pwd['hashpassword'];
		$setData['Salt'] 			= $Pwd['salt'];
		$Cond=array();
		$Cond['SLNO']  = trim($this->session->userdata('userslno'));
		
		$this->Commonmodel->updatedata('users',$setData,$cond);
		
	}
	
	$setdata['LastUpdated'] = date('Y-m-d H:i:s');
	
	$table='userdetails';
	
	if($this->Commonmodel->updatedata($table,$setdata,$cond))
	{
		echo "1";
	}
	else
		echo "0";
	
	
	
}

//user logiun validation
public function validateUserlogin()
{
	$_POST = $this->striptags($_POST);
	
	extract($_POST);
	
	$userid = trim($username);
	$password = trim($password);
	
	$res_data = $this->saltedpassword->makeITdecrypt($userid,$password);
	
	if( $res_data == "1" )
	{
		$table = 'users';
		$cond  = array();
		$pwd = $this->saltedpassword->getPassword($userid);
		$cond['Password'] = $pwd;
		$cond['Role'] = '2';
		
		$out_arr = $this->Commonmodel->get_single_row($table,$cond,$order_by='',$order_by_field='',$limit='');
		if($out_arr)
		{
			$this->db->where('UserName',$userid);
			$this->db->where('Status','Active');
			$qry = $this->db->get('users');
			if($qry->num_rows()>0)
			{
				
			
			$table='';
			$cond='';
			$data='';
			
			$table='users';
			$cond=array("UserName"=>$userid,"Password"=>$pwd);
			$data=array( 'LastLogin'=>date('Y-m-d H:i:s A'),'LastUpdated'=>time() );
			
			$this->Commonmodel->updatedata($table,$data,$cond);//update the last login and time

			foreach($out_arr->result() as $arr)	
			{
				$this->session->set_userdata('UserName',$arr->UserName);
				$this->session->set_userdata('userslno',$arr->SLNO);
				$this->session->set_userdata('userrole',$arr->Role);
				echo "1";
			}
		
			}
			else
			{
				echo "-1";	
			}
		}
		
	}
	else echo "0";
	
	
}

public function getuserFranchise()
{
	
		$postdata = array();
		
		$postdata = json_decode(file_get_contents('php://input'),TRUE);
		$postdata = $this->striptags($postdata);
		
		$out_resp	=	array();
		$cond		=	array();


		if(trim($postdata['yes_no']) == 'Inactive')
		{
			$cond['Status'] = 'Inactive'; 
			
		}
		else if(trim($postdata['yes_no']) == 'Active')
		{
			$cond['Status'] = 'Active'; 
			
		}
		else if(trim($postdata['yes_no']) == 'New')
		{
			$cond['Status'] = 'New'; 
			
		}
		else{
				$cond=array();
			
			}
		
		$res_set = $this->Commonmodel->getuserFranchise($cond);
		
		if($res_set!='0')
		{
			$cnt=1;
			foreach($res_set->result() as $data)
			{
				$out_resp[]= array(
									"SLNO"=>$cnt,
									"UserId"=>$data->SLNO,
									"Status"=>$data->Status,
									"USERNAME"=>$data->USERNAME,
									"BrandId"=>$data->BrandId,
									"Owner_Name"=>$data->Owner_Name,
									"Email"=>$data->Email,
									"Phone"=>$data->Phone, 
									"Address"=>$data->Address,
									"Location"=>$data->Location								
									);	
			$cnt++;
			}
		}
		else
		{
			$out_resp = array("nodata"=>"yes");	
		}
		
		echo json_encode($out_resp);
	
	}
	
public function getAUserFranchiseDetails()
{
	
	
		$postdata = array();
		$postdata = json_decode(file_get_contents('php://input'),TRUE);
		
		$postdata = $this->striptags($postdata);
		
		$res_set = $this->Commonmodel->getAUserFranchiseDetails($postdata['UserId']);
		
		
		if($res_set!='0')
		{
			$cnt=1;
			
			
			foreach($res_set->result() as $data)
			{
				$out_resp[]= array(
									"SLNO"=>$cnt,
									"Status"=>$data->Status,
									"UserId"=>$data->SLNO,
									"BrandId"=>$data->BrandId,
									"City"=>$data->City,
									"USERNAME"=>$data->UserName,
									"Owner_Name"=>$data->Owner_Name,
									"Email"=>$data->Email,
									"Phone"=>$data->Phone, 
									"Address"=>$data->Address,
									"Location"=>$data->Location								
									);	
			$cnt++;
			}
		}
		else
		{
			$out_resp = array("nodata"=>"yes");	
		}
		
		echo json_encode($out_resp);
	
	}
	
######################################################################################################################
							/*  getAUserFranchiseDetails ends here */
######################################################################################################################


######################################################################################################################
							/*  get brands  starts here */
######################################################################################################################

public function getbrands()
{
	
	
		$out_resp	=	array();
		$cond		=	array();
		
		$table ='brands';
		
		$order_by='BrandId';
		$order_by_field='Desc';
		
		$res_set = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
		
		if($res_set!='0')
		{
			$cnt=1;
			foreach($res_set->result() as $data)
			{
				$out_resp[]= array(
									"SLNO"=>$cnt,
									"BrandId"=>$data->BrandId,
									'Brand'=>$data->BrandName,
									"Status"=>$data->Status,
																
									);	
			$cnt++;
			}
			
			//$out_resp['nodata'] = "no";
		}
		else
		{
			$out_resp = array("nodata"=>"yes");	
		}
		
		echo json_encode($out_resp);
	
}

######################################################################################################################
							/*  get brands ends here */
######################################################################################################################




######################################################################################################################
							/*  changing status of the brand  starts here */
######################################################################################################################

public function Activate_inactivate_brand()
{
	
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);
	$postdata = $this->striptags($postdata);
	$cond= array();
	$table="brands";
	
	$setdata = array();
	
	if($postdata['Status']=="Active")
	{
		$setdata['Status']		= 'Inactive';
	}
	elseif($postdata['Status']=="Inactive")
	{
		$setdata['Status']		= 'Active';
	}
	
	$setdata['LastUpdated']	= time();
	$cond['BrandId']		= $postdata['BrandId'];
	
	if(	$this->Commonmodel->updatedata($table,$setdata,$cond) )
	{	
		echo "1";
	}
	else
		echo "0";
		
	
}


######################################################################################################################
							/*  changing status of the brand  ends here */
######################################################################################################################


#####################################################################################################################
							/* Get the list of categories and the respective brands */
#####################################################################################################################

public function getcategories()
{
	
		$out_resp	=	array();
		$cond		=	array();
		$res_set = $this->Commonmodel->getcategories($cond);
		
		if($res_set!='0')
		{
			$cnt=1;
			foreach($res_set->result() as $data)
			{
				$out_resp[]= array(
									"SLNO"=>$cnt,
									"CategoryID"=>$data->CategoryID,
									"Category_Name"=>$data->Category_Name,
									//"BrandName"=>$data->BrandName,
									"Status"=>$data->Status							
									);	
			$cnt++;
			}
		}
		else
		{
			$out_resp = array("nodata"=>"yes");	
		}
		
		echo json_encode($out_resp);
	
}


#####################################################################################################################
							/* Get the list of categories and the respective brands ends here */
#####################################################################################################################

    
####################################################################################################							/* Get the list of measurement units here */
####################################################################################################

    
    public function getunits()
    {
		
        $out_resp	=	array();
		$cond		=	array();
        $table      =   'measurements';
        
		$res_set = $this->Commonmodel->getrows($table,$cond=array(),$order_by='',$order_by_field='',$limit='');
		
		if($res_set!='0')
		{
			$cnt=1;
			foreach($res_set->result() as $data)
			{
				$out_resp[]= array(
									"SLNO"=>$cnt,
									"MeasurementId"=>$data->MeasurementId,
									"MeasurementUnit"=>$data->MeasurementUnit,
									"Status"=>$data->Status,						
									);	
			$cnt++;
			}
		}
		else
		{
			$out_resp = array("nodata"=>"yes");	
		}
		
		echo json_encode($out_resp);
        
    
	}
    
####################################################################################################							/* Get the list of measurement units ends here */
####################################################################################################


    
######################################################################################################################
							/*  changing status of the brand  starts here */
######################################################################################################################

public function Activate_inactivate_unit()
{
	
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);
	$postdata = $this->striptags($postdata);
	$cond= array();
	$table="measurements";
	
	$setdata = array();
	
	if($postdata['Status']=="Active")
	{
		$setdata['Status']		= 'Inactive';
	}
	elseif($postdata['Status']=="Inactive")
	{
		$setdata['Status']		= 'Active';
	}
	
	$setdata['LastUpdated']	   = time();
	$cond['MeasurementId']		= $postdata['MeasurementId'];
	
	if(	$this->Commonmodel->updatedata($table,$setdata,$cond) )
	{	
		echo "1";
	}
	else
		echo "0";
		
	
}


######################################################################################################################
							/*  changing status of the brand  ends here */
######################################################################################################################

    #############################################################################
    #############################################################################
    /* Getting the categories according to the brand */
    
    public function getcategories_Brand()
    {
		
		$_POST = $this->striptags($_POST);
		
        $brandID=trim($_POST['brandid']);
        
        $cond = array();
        $cond['BrandId'] = $brandID;
        $table='categories';
        
        $resp_data = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
        
        if($resp_data!='0')
        {
            $options = array();
            $out_resp = array();
            
            foreach($resp_data->result() as $categs)
            {
                $options[] = "<option value='".$categs->CategoryID."'>".$categs->Category_Name."</option>";
            }
            
            $out_resp = array("nodata"=>"no",$options );
        }
        else
        {
            $out_resp = array("nodata"=>"yes",array("options"=>"<option value='0'>select Category</option>"));	
        }
        echo json_encode($out_resp);
    
	}


#######################################################################################################################################
#######################################################################################################################################

/* get the subcategories */

#######################################################################################################################################
#######################################################################################################################################
	
	
public function getsubcategories_Category()
{
	
		$_POST = $this->striptags($_POST);
		//$brandID=trim($_POST['brand']);
		$categid = trim($_POST['categid']);
		
        
        $cond = array();
       // $cond['BrandId'] = $brandID;
		$cond['CategId'] = $categid;
        
		$table='subcategories';
		
        
        $resp_data = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
        
        if($resp_data!='0')
        {
            $options = array();
            $out_resp = array();
            
            foreach($resp_data->result() as $subcategs)
            {
                $options[] = "<option value='".$subcategs->Sub_CatId."'>".$subcategs->SubCategory."</option>";
            }
            
            $out_resp = array("nodata"=>"no",$options );
        }
        else
        {
            $out_resp = array("nodata"=>"yes",array("options"=>"<option value='0'>select sub-category</option>"));	
        }
        echo json_encode($out_resp);
	
}
	
    
#################################################################################################### 

##########################################################################################################################################################################################################/* getProducts_listing function gets the list of products added by the admin */    

    public function getProducts_listing()
    {
		
        $out_resp	=	array();
		
        $this->db->select("prd.ProductId, prd.ProductName,prd.BrandId,prd.Status,prd.AddedBy, prd.Sub_CatId, pkg.Price as ProductPrice,cat.Category_Name, prd.Qty, pkg.Netweight NetWeight, mes.MeasurementUnit");
        $this->db->from('products as prd');
       // $this->db->join('brands as brnd','prd.BrandId=brnd.BrandId');
        $this->db->join('categories as cat','prd.Category_Id=cat.CategoryID');
        $this->db->join('measurements as mes','prd.MeasurementUnit=mes.MeasurementId');
		$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
		//$this->db->join('subcategories as sub ','prd.Sub_CatId=sub.Sub_CatId');
		$this->db->order_by('prd.ProductId','DESC');
		$this->db->group_by('prd.ProductId');
        $qry = $this->db->get();
        //echo $this->db->last_query(); exit; 
        
        if($qry->num_rows()>0)
        {
            $slno=1;
          foreach($qry->result() as $prdcts)
          {
			  
			  if($prdcts->Sub_CatId>0)
			  {
				$this->db->select("SubCategory");
				$this->db->from('subcategories');
				$this->db->where('Sub_CatId',$prdcts->Sub_CatId);
				$subcateg = $this->db->get('')->row('SubCategory');
			  }
			  else
			  $subcateg="----";
			  
			  if($prdcts->BrandId>0)
			  {
				 $table='brands';
				 $cond=array();
				 $cond['BrandId']=$prdcts->BrandId;
				 $field='BrandName';
				 $order_by='';
				 $order_by_field='';
				 $limit='';
				 
				$Brand = $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');
			  }
			  else
			  {
				$Brand = 'Not Applicable';
			  }
              $out_resp[]=array(
                                "SLNO"=>$slno,
                                "ProductId"=>$prdcts->ProductId,
                                "ProductName"=>$prdcts->ProductName,
                                "ProductPrice"=>$prdcts->ProductPrice,
								"Status"=>$prdcts->Status,
                                "BrandName"=>$Brand,//$prdcts->BrandName,
                                "Category_Name"=>$prdcts->Category_Name,
								 "SubCategory"=>$subcateg,
								 "NetWeight"=>$prdcts->NetWeight,
                                "MeasurementUnit"=>$prdcts->MeasurementUnit,
								"Qty"=>$prdcts->Qty,
								"Addedby"=>$prdcts->AddedBy,
                                    );
              $slno++;
          }
        }
        else
		{
			$out_resp = array("nodata"=>"yes");	
		}
		
		echo json_encode($out_resp);
            
        
        
    
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* Get the list of subcategories  */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
public function getsubcategories()
{
	
	 $out_resp	=	array();
	 
	$this->db->select('c.Category_Name as Category_Name, s.SubCategory as SubCategory, s.Sub_CatId as Sub_CatId');
	$this->db->from('subcategories as s');
	//$this->db->join('brands as b','b.BrandId=s.BrandId');
	$this->db->join('categories as c','c.CategoryID=s.CategId');
	$qry = $this->db->get();
	
	if( $qry->num_rows()>0)
	{
		$slno=1;
          foreach($qry->result() as $data)
          {
              $out_resp[]=array(
                                "SLNO"=>$slno,
                                "SubcatId"=>$data->Sub_CatId,
                              //  "BrandName"=>$data->BrandName,
                                "CategoryName"=>$data->Category_Name,
                                "SubCategory"=>$data->SubCategory,
                               
                                    );
              $slno++;
          }
	}
	else
	{
		$out_resp = array("nodata"=>"yes");	
	}
	
	echo json_encode($out_resp);
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*  get uoms starts here */

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////



public function getuoms()
{
	
	 $out_resp	=	array();
	 
	 $this->db->order_by('Baseuom','DESC');
	 $qry = $this->db->get('baseuom');
	
	if($qry->num_rows()>0)
	{
		$slno=1;
          foreach($qry->result() as $data)
          {
              $out_resp[]=array(
                                "SLNO"=>$slno,
                                "Baseuom"=>$data->Baseuom,
                                "Baseid"=>$data->baseid                               
                                );
              $slno++;
          }
		
	}
	else
	{
		$out_resp = array("nodata"=>"yes");	
	}
	
	echo json_encode($out_resp);
	
}

//get all the orders

public function getAllorders()
{
	
	
	$chk_page  = explode("/",$_SERVER['HTTP_REFERER']); //get the http referer (from which url this method has been called


	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);
	$postdata = $this->striptags($_POST);

if( end($chk_page) == "admin-view-orders-category" ) //if user request ed form the orders by category page
{ 
	$this->db->select('ud.Owner_Name,od.OrderId,cat.Category_Name,prd.ProductName, date_format(od.OrderedOn,"%d-%m-%Y") as OrderedOn, od.Total_Amount,od.OrderStatus,od.TotalProducts');
		$this->db->from('orders as od');
		$this->db->join('userdetails as ud','ud.SLNO=od.OrderBy');
		$this->db->join('orderproducts as op','od.OrderId=op.OrderId');
		$this->db->join('products as prd','prd.ProductId=op.Product');
		$this->db->join('categories as cat','cat.CategoryID=prd.Category_Id');
		$this->db->where('prd.Category_Id>',0);	
		//$this->db->group_by('od.OrderId, ud.Owner_Name, prd.Category_Id');
		$this->db->group_by('od.OrderId, prd.Category_Id');
}
else if(end($chk_page) == "admin-view-orders-products" ) //if user request ed form the orders by category page
{ 
	$this->db->select('ud.Owner_Name,od.OrderId,cat.Category_Name,prd.ProductName, date_format(od.OrderedOn,"%d-%m-%Y") as OrderedOn, od.Total_Amount,od.OrderStatus,od.TotalProducts');
		$this->db->from('orders as od');
		$this->db->join('userdetails as ud','ud.SLNO=od.OrderBy');
		$this->db->join('orderproducts as op','od.OrderId=op.OrderId');
		$this->db->join('products as prd','prd.ProductId=op.Product');
		$this->db->join('categories as cat','cat.CategoryID=prd.Category_Id');
		$this->db->where('prd.Category_Id>',0);	
		$this->db->group_by('od.OrderId, ud.Owner_Name, prd.Category_Id');
}
else //if called pages are  admin-view-orders, admin-view-awaiting-orders, admin-view-confirmed-orders,admin-view-delivered-orders, admin-view-cancelled-orders
{
	
	//if user calls this method form the below paths then we are going to make a where conditions according to the page fromwhere this method has been called
	
if(end($chk_page) == "admin-view-orders")
{
	//$this->db->where('OrderStatus!=','Awaiting');
}
else if(end($chk_page) == "admin-view-awaiting-orders")
{
	$this->db->where('OrderStatus','Awaiting');
}
else if(end($chk_page) == "admin-view-confirmed-orders")
{
	$this->db->where('OrderStatus','Confirmed');
}
else if(end($chk_page) == "admin-view-delivered-orders")
{
	$this->db->where('OrderStatus','Delivered');
}
else if(end($chk_page) == "admin-view-cancelled-orders")
{
	$this->db->where('OrderStatus','Cancelled');
}

	
	$out_resp	=	array();
	
	$this->db->select('ud.Owner_Name,od.OrderId,date_format(od.OrderedOn,"%d-%m-%Y") as OrderedOn,od.Total_Amount, od.OrderStatus,od.TotalProducts');
	$this->db->from('orders as od');
	$this->db->join('userdetails as ud','ud.SLNO=od.OrderBy');
	$this->db->order_by('OrderId','DESC');
}

$qry = $this->db->get('');
	if($qry->num_rows()>0)
	{
		$slno=1;
          foreach($qry->result() as $data)
          {
              $table='orderproducts';
			  $cond=array();
			  $field='OrderedOn';
			  $order_by='DESC';
			  $order_by_field='OPID';
			  $limit='1';
			  
			 $OrderedOn =  $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');
			  
			  if( end($chk_page) == "admin-view-orders-category" )
				{
					$Category_Name = $data->Category_Name;
					$Product_Name = $data->ProductName;
				}
			elseif( end($chk_page) == "admin-view-orders-products" )
				{
					$Category_Name = $data->Category_Name;
					$Product_Name = $data->ProductName;
				}
			else
				{
					$Category_Name = '';	
					$Product_Name = '';
				}
				
			  $out_resp[]=array(
									"SLNO"=>$slno,
									"Owner_Name"=>$data->Owner_Name,
									"OrderId"=>$data->OrderId, 
									"OrderStatus"=>$data->OrderStatus,
									"TotalProducts"=>$data->TotalProducts,
									"Total_Amount"=>$data->Total_Amount,
									"OrderedOn"=>$data->OrderedOn,
									"Category"=>$Category_Name,
									"Product_Name"=>$Product_Name,
									"todate"=>$data->OrderedOn                       
                                );
              $slno++;
          }
		
	}
	else
	{
		$out_resp = array("nodata"=>"yes");	
	}
	
	echo json_encode($out_resp);
	
}

//get the orders by ********* and prepare the excel sheet for that and download that

public function download_orders_by_excelsheet()
{
	$requested_from =  $_SERVER['HTTP_REFERER'];
		
	$this->load->library('excel');
	
	$chk_page  = explode("/",$_SERVER['HTTP_REFERER']);
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);


	if(array_key_exists('Category',$postdata['filter']))
	{
			
		$category_arr = $postdata['filter']['Category'];
		$this->db->select('ud.Owner_Name,od.OrderId,prd.ProductName, date_format(od.OrderedOn,"%d-%m-%Y") as OrderedOn, od.Total_Amount,od.OrderStatus,od.TotalProducts');
	$this->db->from('orders as od');
	$this->db->join('userdetails as ud','ud.SLNO=od.OrderBy');
	$this->db->join('orderproducts as op','od.OrderId=op.OrderId');
	$this->db->join('products as prd','prd.ProductId=op.Product');
	
	if($postdata['filter']['Category']['CategoryID']>0)
	$this->db->where('prd.Category_Id',$postdata['filter']['Category']['CategoryID']);
	
	$this->db->group_by('od.OrderId');
	
	//$qry = $this->db->get();

//	echo $this->db->last_query(); exit; 
	
		
	
	}
	elseif(array_key_exists('Product',$postdata['filter']))
	{
		$category_arr = $postdata['filter']['Product'];
	
	$this->db->select('ud.Owner_Name,od.OrderId,prd.ProductName, date_format(od.OrderedOn,"%d-%m-%Y") as OrderedOn, od.Total_Amount,od.OrderStatus,od.TotalProducts');
	$this->db->from('orders as od');
	$this->db->join('userdetails as ud','ud.SLNO=od.OrderBy');
	$this->db->join('orderproducts as op','od.OrderId=op.OrderId');
	$this->db->join('products as prd','prd.ProductId=op.Product');
	if($postdata['filter']['Product']['ProductId']>0)
	$this->db->where('prd.ProductId',$postdata['filter']['Product']['ProductId']);
	
	$this->db->group_by('od.OrderId');
	//$qry = $this->db->get();

//	echo $this->db->last_query(); exit; 
	
		
		
	
	}
	else
	{
		
	
	
//preparing the where conditions

if(end($chk_page) == "admin-view-orders")
{

}
else if(end($chk_page) == "admin-view-awaiting-orders")
{
	$this->db->where('OrderStatus','Awaiting');
}
else if(end($chk_page) == "admin-view-confirmed-orders")
{
	$this->db->where('OrderStatus','Confirmed');
}
else if(end($chk_page) == "admin-view-delivered-orders")
{
	$this->db->where('OrderStatus','Delivered');
}
else if(end($chk_page) == "admin-view-cancelled-orders")
{
	$this->db->where('OrderStatus','Cancelled');
}
	
	$out_resp	=	array();
//preparing the select querey	
	$this->db->select('ud.Owner_Name,od.OrderId,date_format(od.OrderedOn,"%d-%m-%Y") as OrderedOn, od.Total_Amount,od.OrderStatus,od.TotalProducts');
	$this->db->from('orders as od');
	$this->db->join('userdetails as ud','ud.SLNO=od.OrderBy');
	$this->db->order_by('OrderId','DESC');
	
	}
//preparing the where conditions	
	if(array_key_exists('Owner_Name',$postdata['filter']))
	{
		if(trim($postdata['filter']['Owner_Name'])!='')
		{
			$this->db->where('ud.Owner_Name',trim($postdata['filter']['Owner_Name']));
		}
	}
	
	if(array_key_exists('OrderId',$postdata['filter']))
	{
		if(trim($postdata['filter']['OrderId'])!='')
		{
			$this->db->where('od.OrderId',(int)trim($postdata['filter']['OrderId']));
		}
	}
	
	if(array_key_exists('OrderStatus',$postdata['filter']))
	{
		if(trim($postdata['filter']['OrderStatus'])!='')
		{
			$this->db->where('od.OrderStatus',ucwords(strtolower(trim($postdata['filter']['OrderStatus']))) );
		}
	}




//check whether user selects from date or not 
	if( array_key_exists('OrderedOn',$postdata['filter']) && trim($postdata['filter']['OrderedOn'])!='')
	{
		//check whether user selects to date or not 
		if( array_key_exists('todate',$postdata['filter']) && trim($postdata['filter']['todate'])!='')
		{
			
			$frmdataed=  trim($postdata['filter']['OrderedOn']);
			$todataed=  trim($postdata['filter']['todate']);
			
			$this->db->where('date_format(od.OrderedOn,"%Y-%m-%d")<=',$todataed);
			$this->db->where('date_format(od.OrderedOn,"%Y-%m-%d")>=',$frmdataed);
		}
		else
		{
			$frmdataed=  trim($postdata['filter']['OrderedOn']);
			$todataed=  trim($postdata['filter']['todate']);

			$this->db->where('date_format(od.OrderedOn,"%Y-%m-%d")',$frmdataed);
			
		}
	}
	else if( array_key_exists('todate',$postdata['filter']) && trim($postdata['filter']['todate'])!='') //check whether user selects to date or not 
	{
		
			
			$todataed=  trim($postdata['filter']['todate']);

			$this->db->where('date_format(od.OrderedOn,"%Y-%m-%d")',$todataed);
			
	}
	
	
	
	$qry = $this->db->get('');
	
	#echo $this->db->last_query(); exit;
	
	if($qry->num_rows()>0)
	{
		$slno=1;
          foreach($qry->result() as $data)
          {
              $table='orderproducts';
			  $cond=array();
			  $field='OrderedOn';
			  $order_by='DESC';
			  $order_by_field='OPID';
			  $limit='1';
			  
			 $OrderedOn =  $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');
			  
			  if(array_key_exists('Category',$postdata['filter']) )
				{
					$product = $data->ProductName;	
					$category=$postdata['filter']['Category']['Category_Name'];
				}
			else if(array_key_exists('Product',$postdata['filter']) )
				{
					$product = $data->ProductName;	
					$category=$postdata['filter']['Product']['Product_Name'];
				}
				else
				{
					$product = '';	
					$category='';
				}
		
			  
			  $out_resp[]=array(
									"SLNO"=>$slno,
									"Owner_Name"=>$data->Owner_Name,
									"OrderId"=>$data->OrderId, 
									"OrderStatus"=>$data->OrderStatus,
									"TotalProducts"=>$data->TotalProducts,
									"OrderedOn"=>$data->OrderedOn,
									"Total_Amount" =>$data->Total_Amount,
									"Product_Name"=>$product,
									"Category"=>$category,
									"todate"=>$data->OrderedOn                       
                                );
              $slno++;
          }
		
	}
	else
	{
		$out_resp = array("nodata"=>"yes");	

	}
	
#	echo json_encode($out_resp);

	if(!array_key_exists('nodata',$out_resp) )
	{
	
		if($chk_page[4] == "admin-view-orders")
		{
			
			
			
			
			$this->excel->setActiveSheetIndex(0);
			$select_cols = array('Slno','Store Name','OrderId','Order Status','Quantity','Order Price','Ordered On');
							$excel_sheet_name = time().str_replace(" ","-",$postdata['filter']['Owner_Name']); 							
	
			$cnt=1;
			
			$Excelcolmns = range('A','Z');
			
			$needed_columns = array_slice( $Excelcolmns,0,sizeof($select_cols) );
			
			//echo "<Pre>"; print_r($needed_columns); exit; 
	//preparing the header goes here
		
		$cnt=1;		
		
			foreach( $needed_columns as $key=>$val )
					{
						$col = $select_cols[$key];
						
						$this->excel->getActiveSheet()->setCellValue($needed_columns[$key].'1', $col);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getFont()->setSize(13);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getFont()->setBold(true);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
					}
	//preparing the header ends here
		
	
	//prepare the body if the excel sheet goes here
	
	
	foreach($out_resp as $key=>$va)
	{
		//prepare the excel sheet name
	
			if($cnt==1)
				{ 
					$this->excel->getActiveSheet()->setTitle("Orders by category"); 
					$excel_sheet_name = time().str_replace(" ","-",$postdata['filter']['Owner_Name']); 							
				}	
		
		foreach($va as $k=>$value)
		{
			
			if($k=="SLNO")
			{
			//	echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('A'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('A'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('A'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			if($k=="Owner_Name")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('B'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('B'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('B'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			if($k=="OrderId")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('C'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('C'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('C'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="OrderStatus")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('D'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('D'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('D'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="TotalProducts")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('E'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('E'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('E'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="Total_Amount")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('F'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('F'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('F'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="OrderedOn")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('G'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			
		}
	
		//echo "<br>";		
		$cnt++;
	}
		$filename="$excel_sheet_name.xls"; //save our workbook as this file name
	
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		//$objWriter->save('php://output');
		$objWriter->save($filename);
		echo $filename;
	//prepare the body if the excel sheet ends here	
		
		
		}
		if($chk_page[4] == "admin-view-orders-category")
		{
			
			$this->excel->setActiveSheetIndex(0);
			$select_cols = array('Slno','Store Name','Category','OrderId','Order Status','Quantity','Order Price','Ordered On');
			$excel_sheet_name = time().str_replace(" ","-",$postdata['filter']['Category']['Category_Name']); 
	
	
			$cnt=1;
			
			$Excelcolmns = range('A','Z');
			
			$needed_columns = array_slice( $Excelcolmns,0,sizeof($select_cols) );
			
			//echo "<Pre>"; print_r($needed_columns); exit; 
	//preparing the header goes here
		
		$cnt=1;		
		
			foreach( $needed_columns as $key=>$val )
					{
						$col = $select_cols[$key];
						
						$this->excel->getActiveSheet()->setCellValue($needed_columns[$key].'1', $col);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getFont()->setSize(13);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getFont()->setBold(true);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
					}
	//preparing the header ends here
		
	
	//prepare the body if the excel sheet goes here
	
	
	foreach($out_resp as $key=>$va)
	{
		//prepare the excel sheet name
	
			if($cnt==1)
				{ 
					$this->excel->getActiveSheet()->setTitle("Orders by category"); 
					$excel_sheet_name = time().str_replace(" ","-",$postdata['filter']['Category']['Category_Name']); 
								
				}	
		
		foreach($va as $k=>$value)
		{
			
			if($k=="SLNO")
			{
			//	echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('A'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('A'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('A'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			if($k=="Owner_Name")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('B'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('B'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('B'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="Category")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('C'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('C'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('C'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="OrderId")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('D'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('D'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('D'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="OrderStatus")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('E'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('E'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('E'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="TotalProducts")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('F'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('F'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('F'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="Total_Amount")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('G'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="OrderedOn")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('H'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('H'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('H'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			
		}
	
		//echo "<br>";		
		$cnt++;
	}
		$filename="$excel_sheet_name.xls"; //save our workbook as this file name
	
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		//$objWriter->save('php://output');
		$objWriter->save($filename);
		echo $filename;
	//prepare the body if the excel sheet ends here	
		
		
		}//if ends here
		if($chk_page[4] == 'admin-view-orders-products')	
		{
			
			$this->excel->setActiveSheetIndex(0);
			$select_cols = array('Slno','Store Name','Product','OrderId','Order Status','Quantity','Order Price','Ordered On');
			$excel_sheet_name = time().str_replace(" ","-",$postdata['filter']['Product']['Product_Name']); 
	
			$cnt=1;
			
			$Excelcolmns = range('A','Z');
			
			$needed_columns = array_slice( $Excelcolmns,0,sizeof($select_cols) );
			
			//echo "<Pre>"; print_r($needed_columns); exit; 
	//preparing the header goes here
		
		$cnt=1;		
		
			foreach( $needed_columns as $key=>$val )
					{
						$col = $select_cols[$key];
						
						$this->excel->getActiveSheet()->setCellValue($needed_columns[$key].'1', $col);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getFont()->setSize(13);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getFont()->setBold(true);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
					}
	//preparing the header ends here
		
	
	//prepare the body if the excel sheet goes here
	
	
	foreach($out_resp as $key=>$va)
	{
		//prepare the excel sheet name
	
			if($cnt==1)
				{ 
					$this->excel->getActiveSheet()->setTitle("Orders by category"); 
					$excel_sheet_name = time().str_replace(" ","-",$postdata['filter']['Product']['Product_Name']); 								
				}	
		
		foreach($va as $k=>$value)
		{
			
			if($k=="SLNO")
			{
			//	echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('A'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('A'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('A'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			if($k=="Owner_Name")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('B'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('B'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('B'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="Product_Name")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('C'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('C'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('C'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			if($k=="OrderId")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('D'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('D'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('D'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="OrderStatus")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('E'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('E'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('E'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="TotalProducts")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('F'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('F'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('F'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="Total_Amount")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('G'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="OrderedOn")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('H'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('H'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('H'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			
		}
	
		//echo "<br>";		
		$cnt++;
	}
		$filename="$excel_sheet_name.xls"; //save our workbook as this file name
	
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		//$objWriter->save('php://output');
		$objWriter->save($filename);
		echo $filename;
	//prepare the body if the excel sheet ends here	
		
		
			
			
			
		}
		
		if($chk_page[4] == 'admin-view-confirmed-orders')	
		{
			
			
			
			
			$this->excel->setActiveSheetIndex(0);
			$select_cols = array('Slno','Store Name','OrderId','Order Status','Quantity','Order Price','Ordered On');
							$excel_sheet_name = time().str_replace(" ","-",$postdata['filter']['Owner_Name']); 							
	
			$cnt=1;
			
			$Excelcolmns = range('A','Z');
			
			$needed_columns = array_slice( $Excelcolmns,0,sizeof($select_cols) );
			
			//echo "<Pre>"; print_r($needed_columns); exit; 
	//preparing the header goes here
		
		$cnt=1;		
		
			foreach( $needed_columns as $key=>$val )
					{
						$col = $select_cols[$key];
						
						$this->excel->getActiveSheet()->setCellValue($needed_columns[$key].'1', $col);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getFont()->setSize(13);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getFont()->setBold(true);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
					}
	//preparing the header ends here
		
	
	//prepare the body if the excel sheet goes here
	
	
	foreach($out_resp as $key=>$va)
	{
		//prepare the excel sheet name
	
			if($cnt==1)
				{ 
					$this->excel->getActiveSheet()->setTitle("Orders by category"); 
					$excel_sheet_name = time().str_replace(" ","-",$postdata['filter']['Owner_Name']); 							
				}	
		
		foreach($va as $k=>$value)
		{
			
			if($k=="SLNO")
			{
			//	echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('A'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('A'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('A'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			if($k=="Owner_Name")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('B'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('B'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('B'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			if($k=="OrderId")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('C'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('C'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('C'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="OrderStatus")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('D'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('D'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('D'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="TotalProducts")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('E'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('E'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('E'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="Total_Amount")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('F'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('F'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('F'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="OrderedOn")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('G'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			
		}
	
		//echo "<br>";		
		$cnt++;
	}
		$filename="$excel_sheet_name.xls"; //save our workbook as this file name
	
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		//$objWriter->save('php://output');
		$objWriter->save($filename);
		echo $filename;
	//prepare the body if the excel sheet ends here	
		
		
			}

	}
	else
	{
		echo "no data";
	}
	
	
	
}

public function download_orderd_product_excelsheet()
{
	//this is for the products per order page 
	
		
	$this->load->library('excel');
	
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);	
	$postdata = $this->striptags($postdata);
	$table='orders';
	
	$cond = array();
	$cond['OrderId'] = $postdata['orderid'];
	
	$output = array(); // used to store the final output data
	
	$prds = array(); //used to store product ids and the quantity
	
	//check whether the order exists or not
	
	if( $this->Commonmodel->checkexists($table,$cond))
	{

		//get the product id and its quantity, and the order status
		
		// $prd_quant = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
		$this->db->select('op.*, ord.OrderStatus as Status, usd.Owner_Name as store');
		$this->db->from('orderproducts as op');
		$this->db->join('orders as ord','ord.OrderId=op.OrderId');
		$this->db->join('userdetails as usd','usd.SLNO=ord.OrderBy');
		$this->db->where('op.OrderId',$postdata['orderid']);
		$prd_quant = $this->db->get('');
		
		 foreach($prd_quant->result() as $data)
		 {
			 $prds[] = array(
			 				"ProductId"=>$data->Product,
							"Quantity"=>$data->Quantity,
							"PackageId"=>$data->PackageId,
							);
			$orderedOn = explode(" ",$data->OrderedOn);
			$ord = date_create($orderedOn[0]);
			$ord_dtd = date_format($ord,"d-m-Y");
			
			$orderedOn = $ord_dtd." ".$orderedOn[1];
			
			$Status = $data->Status;
			$storename = $data->store;
			
		 }
		 //get EACH product information of the order
$slno=0;
$total_amount_cart = 0;
		foreach($prds as $val_arrays)
			{
				
				$slno++;					
						//calling thedatabase for the product
						
						$this->db->select('mes.MeasurementUnit,bse.Baseuom as packagetype,cat.Category_Name, prd.ProductName, pkg.Price as ProductPrice, prd.ProductImage, pkg.Netweight as NetWeight, pkg.Grossweight  as GrossWeight,prd.ReadyTo, prd.BaseUOM');
						$this->db->from('products as prd');
						$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
						$this->db->join('baseuom as bse', 'bse.baseid=prd.BaseUOM');
						$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
						$this->db->join('categories as cat','cat.CategoryID=prd.Category_Id');
						$this->db->where('prd.ProductId',$val_arrays['ProductId']);
						$this->db->where('pkg.Id',$val_arrays['PackageId']);
						$prddetails = $this->db->get('');
						
						foreach($prddetails->result() as $product )
						{
						//	$ProductImage = $product->ProductImage;
							$ProductName = $product->ProductName;
							$GrossWeight  = $product->GrossWeight;
							$ProductPrice = ($product->ProductPrice)*($val_arrays['Quantity']); 
							$category = 	$product->Category_Name;
							$perunit=$product->ProductPrice;
							$MeasurementUnit = $product->MeasurementUnit;
							$total_amount_cart = $total_amount_cart+$ProductPrice;
							if(end($product))
							{
								$total_amount = $total_amount_cart;
							}
						}
						
						$quantity = $val_arrays['Quantity'];
						
						$output[] = array(
											"SLNO"=>$slno,
											"ProductName"=>str_replace("-"," ",$ProductName),
											"GrossWeight"=>$GrossWeight,
											"ProductPrice"=>$ProductPrice,
											"Category_Name"=>$category,
											"Perunit"=>$perunit,
											"MeasurementUnit"=>$MeasurementUnit,
											"quantity"=>$quantity,
											"orderedOn"=>$orderedOn,
											"Status"=>$Status,
											"OrderId"=>$postdata['orderid'],
											"TotalAmount"=>$total_amount_cart,
											"Store"=>$storename
											
										);
						
				}
				

		 
		
	}
	else
	{
		$output['invalidOrder'] = "yes";
	}//check whether the order exists or not else part
	
//if the order exists
	if(!array_key_exists('invalidOrder',$output))
	{
		
			$this->excel->setActiveSheetIndex(0);
			$select_cols = array('Slno','Orderid','Category','Product Name','GrossWeight','Quantity','Perunit','Order Price','Order Status','Store','Ordered On');
			$excel_sheet_name = time().'order_'.$postdata['orderid']; 
	
			$cnt=1;
			
			$Excelcolmns = range('A','Z');
			
			$needed_columns = array_slice( $Excelcolmns,0,sizeof($select_cols) );
			
			//echo "<Pre>"; print_r($needed_columns); exit; 
	//preparing the header goes here
		
		$cnt=1;		
		
			foreach( $needed_columns as $key=>$val )
					{
						$col = $select_cols[$key];
						
						$this->excel->getActiveSheet()->setCellValue($needed_columns[$key].'1', $col);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getFont()->setSize(13);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getFont()->setBold(true);
						$this->excel->getActiveSheet()->getStyle($needed_columns[$key].'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
					}
	//preparing the header ends here
		
	
	//prepare the body if the excel sheet goes here
	
$total_cost = 0;	
	
	foreach($output as $key=>$va)
	{
		//prepare the excel sheet name
	
			if($cnt==1)
				{ 
					$this->excel->getActiveSheet()->setTitle("Products under order_".$postdata['orderid']); 
					$excel_sheet_name = time().'order_'.$postdata['orderid']; 							
				}	
		
		foreach($va as $k=>$value)
		{
			
			if($k=="SLNO")
			{
			//	echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('A'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('A'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('A'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			if($k=="OrderId")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('B'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('B'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('B'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="ProductName")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('D'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('D'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('D'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="Category_Name")
			{
				$this->excel->getActiveSheet()->setCellValue('C'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('C'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('C'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="GrossWeight")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('E'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('E'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('E'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="quantity")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('F'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('F'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('F'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="Perunit")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('G'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="ProductPrice")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('H'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('H'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('H'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			if($k=="Status")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('I'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('I'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('I'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			if($k=="Store")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('J'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('J'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('J'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			if($k=="orderedOn")
			{
				//echo "$k:".$value;	
				$this->excel->getActiveSheet()->setCellValue('K'.($cnt+1), $value);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('K'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('K'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
			
			if($k=="TotalAmount") $total_cost = $value;
		}
	
		//echo "<br>";		
		$cnt++;
	}
	
					$this->excel->getActiveSheet()->setCellValue('G'.($cnt+1), "Grand total");
					//change the font size
				$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getFont()->setBold(true);
				$this->excel->getActiveSheet()->getStyle('G'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
	
				$this->excel->getActiveSheet()->setCellValue('H'.($cnt+1), $total_cost);
					//change the font size
				$this->excel->getActiveSheet()->getStyle('H'.($cnt+1))->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('H'.($cnt+1))->getFont()->setBold(true);
				$this->excel->getActiveSheet()->getStyle('H'.($cnt+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
	
		$filename="$excel_sheet_name.xls"; //save our workbook as this file name
	
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		//$objWriter->save('php://output');
		$objWriter->save($filename);
		echo $filename;
	//prepare the body if the excel sheet ends here	
		
		
			
			
			
		
	
	}
	else
	echo "no products";
			
}

public function getordersbyfilter()
{
	$requested_from =  $_SERVER['HTTP_REFERER'];
	
	if( strpos($requested_from, 'trillionit') === false)
		{
			$out_resp = array("nodata"=>"yes"); 
			echo json_encode($out_resp); exit; 
		}
	
	// i had used this funtion for the pages like orders by store, orders by category, orders by product
	//depending on the page i had made the query and get the data and sends the json as the response
	//for the orders by store we are not using any category nor product so i had checked for the category and product if they are not then it will be from the orders by store page otherwise from the respective pages.	

	$chk_page  = explode("/",$_SERVER['HTTP_REFERER']);//get the url form where this method has been called
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);

//if flter by category, check whether user selects any category filter
	if(array_key_exists('Category',$postdata['filter']))
	{

		$category_arr = $postdata['filter']['Category'];

		$this->db->select('ud.Owner_Name,od.OrderId,prd.ProductName, date_format(od.OrderedOn,"%d-%m-%Y") as OrderedOn, od.Total_Amount,od.OrderStatus,od.TotalProducts');
		$this->db->from('orders as od');
		$this->db->join('userdetails as ud','ud.SLNO=od.OrderBy');
		$this->db->join('orderproducts as op','od.OrderId=op.OrderId');
		$this->db->join('products as prd','prd.ProductId=op.Product');
		
		if($postdata['filter']['Category']['CategoryID']>0)
		$this->db->where('prd.Category_Id',$postdata['filter']['Category']['CategoryID']);
		
		$this->db->group_by('od.OrderId');
	}
	elseif(array_key_exists('Product',$postdata['filter'])) //if filter by product, checks whether users selects any product filter
	{
		$category_arr = $postdata['filter']['Product'];
		
		$this->db->select('ud.Owner_Name,od.OrderId,prd.ProductName, date_format(od.OrderedOn,"%d-%m-%Y") as OrderedOn, od.Total_Amount,od.OrderStatus,od.TotalProducts');
		$this->db->from('orders as od');
		$this->db->join('userdetails as ud','ud.SLNO=od.OrderBy');
		$this->db->join('orderproducts as op','od.OrderId=op.OrderId');
		$this->db->join('products as prd','prd.ProductId=op.Product');
		
		if($postdata['filter']['Product']['ProductId']!='0')
			$this->db->where('prd.ProductId',$postdata['filter']['Product']['ProductId']);
		else
			$this->db->where('prd.ProductId>',0);	
		
		$this->db->group_by('od.OrderId');
	
	}
	else //if not above then by default by store
	{
		if(end($chk_page) == "admin-view-orders")
{

}
else if(end($chk_page) == "admin-view-awaiting-orders")
{
	$this->db->where('OrderStatus','Awaiting');
}
else if(end($chk_page) == "admin-view-confirmed-orders")
{
	$this->db->where('OrderStatus','Confirmed');
}
else if(end($chk_page) == "admin-view-delivered-orders")
{
	$this->db->where('OrderStatus','Delivered');
}
else if(end($chk_page) == "admin-view-cancelled-orders")
{
	$this->db->where('OrderStatus','Cancelled');
}
	
	$out_resp	=	array();
//preparing the select querey	
	$this->db->select('ud.Owner_Name,od.OrderId,date_format(od.OrderedOn,"%d-%m-%Y") as OrderedOn, od.Total_Amount,od.OrderStatus,od.TotalProducts');
	$this->db->from('orders as od');
	$this->db->join('userdetails as ud','ud.SLNO=od.OrderBy');
	$this->db->order_by('OrderId','DESC');
	}

//preparing the where conditions	


	if(array_key_exists('Owner_Name',$postdata['filter']))
	{
		if(trim($postdata['filter']['Owner_Name'])!='')
		{
			$this->db->where('ud.Owner_Name',trim($postdata['filter']['Owner_Name']));
		}
	}
	
	if(array_key_exists('OrderId',$postdata['filter']))
	{
		if(trim($postdata['filter']['OrderId'])!='')
		{
			$this->db->where('od.OrderId',(int)trim($postdata['filter']['OrderId']));
		}
	}
	
	if(array_key_exists('OrderStatus',$postdata['filter']))
	{
		if(trim($postdata['filter']['OrderStatus'])!='')
		{
			$this->db->where('od.OrderStatus',ucwords(strtolower(trim($postdata['filter']['OrderStatus']))) );
		}
	}

//check whether user selects from date or not 

	if( array_key_exists('OrderedOn',$postdata['filter']) && trim($postdata['filter']['OrderedOn'])!='')
	{
		
		//check whether user selects to date or not 
		if( array_key_exists('todate',$postdata['filter']) && trim($postdata['filter']['todate'])!='')
		{
			//cond for in between
			$frmdataed=  trim($postdata['filter']['OrderedOn']);
			$todataed=  trim($postdata['filter']['todate']);
			
			$this->db->where('date_format(od.OrderedOn,"%Y-%m-%d")<=',$todataed);
			$this->db->where('date_format(od.OrderedOn,"%Y-%m-%d")>=',$frmdataed);	
		}
		else
		{
			
			
			
			$frmdataed=  trim($postdata['filter']['OrderedOn']);
			$todataed=  trim($postdata['filter']['todate']);
			
			$this->db->where('date_format(od.OrderedOn,"%Y-%m-%d")',$frmdataed);
		}
	
	}
	else if( array_key_exists('todate',$postdata['filter']) && trim($postdata['filter']['todate'])!='') //check whether user selects to date or not 
	{
		
		
		
			$frmdataed=  trim($postdata['filter']['OrderedOn']);
			$todataed=  trim($postdata['filter']['todate']);
			
			$this->db->where('date_format(od.OrderedOn,"%Y-%m-%d")',$todataed);
	
	}
	
	$qry = $this->db->get('');
	
	#echo $this->db->last_query(); exit;
	
	if($qry->num_rows()>0)
	{
		$slno=1;
          foreach($qry->result() as $data)
          {
              $table='orderproducts';
			  $cond=array();
			  $field='OrderedOn';
			  $order_by='DESC';
			  $order_by_field='OPID';
			  $limit='1';
			  
			 $OrderedOn =  $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');
			  
		//prepare the json with the category and product also
		// here we are checking whether the request is from which page according to that 
		// we are populating the category and product varaibles respectively				  
			  
			  if(array_key_exists('Category',$postdata['filter']) )
				{
					$product = $data->ProductName;	
					$category=$postdata['filter']['Category']['Category_Name'];
				}
			else if(array_key_exists('Product',$postdata['filter']) )
				{
					$product = $data->ProductName;	
					$category=$postdata['filter']['Product']['Product_Name'];
				}
				else
				{
					$product = '';	
					$category='';
				}
		
			  
			  $out_resp[]=array(
									"SLNO"=>$slno,
									"Owner_Name"=>$data->Owner_Name,
									"OrderId"=>$data->OrderId, 
									"OrderStatus"=>$data->OrderStatus,
									"TotalProducts"=>$data->TotalProducts,
									"OrderedOn"=>$data->OrderedOn,
									"Total_Amount" =>$data->Total_Amount,
									"Product_Name"=>$product,
									"Category"=>$category,
									"todate"=>$data->OrderedOn                       
                                );
              $slno++;
          }
		
	}
	else
	{
		$out_resp = array("nodata"=>"yes");	
	}
	
	echo json_encode($out_resp);
	
	
}


//get the products which are ordered in an order

public function getAllproductsperorder()
{
	
	//this is for getting the products which are in this order
	
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);	
	$postdata = $this->striptags($postdata);
	$table='orders';
	
	$cond = array();
	$cond['OrderId'] = $postdata['orderid'];
	
	$output = array(); // used to store the final output data
	
	$prds = array(); //used to store product ids and the quantity
	
	//check whether the order exists or not
	
	if( $this->Commonmodel->checkexists($table,$cond))
	{

		//get the product id and its quantity, and the order status
		
		// $prd_quant = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
		$this->db->select('op.*, ord.OrderStatus as Status');
		$this->db->from('orderproducts as op');
		$this->db->join('orders as ord','ord.OrderId=op.OrderId');
		$this->db->where('op.OrderId',$postdata['orderid']);
		$prd_quant = $this->db->get('');
		
		 foreach($prd_quant->result() as $data)
		 {
			 $prds[] = array(
			 				"ProductId"=>$data->Product,
							"Quantity"=>$data->Quantity,
							"PackageId"=>$data->PackageId,
							);
			$orderedOn = explode(" ",$data->OrderedOn);
			
			$orderedDated = date_create($orderedOn[0]);
			$orderedDated = date_format($orderedDated,'d-m-Y');
			$orderedOn =$orderedDated." ".$orderedOn[1];

			$Status = $data->Status;		
		 }
		 //get EACH product information of the order
$slno=0;
$total_amount_cart = 0;
		foreach($prds as $val_arrays) 
			{
				
				$slno++;					
						//calling the database for the product and the information of the products
						
						$this->db->select('mes.MeasurementUnit,bse.Baseuom as packagetype, prd.ProductName, pkg.Price as ProductPrice, prd.ProductImage, pkg.Netweight as NetWeight, pkg.Grossweight  as GrossWeight,prd.ReadyTo, prd.BaseUOM');
						$this->db->from('products as prd');
						$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
						$this->db->join('baseuom as bse', 'bse.baseid=prd.BaseUOM');
						$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
						$this->db->where('prd.ProductId',$val_arrays['ProductId']);
						$this->db->where('pkg.Id',$val_arrays['PackageId']);
						$prddetails = $this->db->get('');
						
						foreach($prddetails->result() as $product )
						{
						//	$ProductImage = $product->ProductImage;
							$ProductName = $product->ProductName;
							$GrossWeight  = $product->GrossWeight;
							$ProductPrice = ($product->ProductPrice)*($val_arrays['Quantity']); 
							$MeasurementUnit = $product->MeasurementUnit;
							$total_amount_cart = $total_amount_cart+$ProductPrice;
							if(end($product))
							{
								$total_amount = $total_amount_cart;
							}
						}
						
						$quantity = $val_arrays['Quantity'];
						
						$output[] = array(
											"SLNO"=>$slno,
											"ProductName"=>str_replace("-"," ",$ProductName),
											"GrossWeight"=>$GrossWeight,
											"ProductPrice"=>$ProductPrice,
											"MeasurementUnit"=>$MeasurementUnit,
											"quantity"=>$quantity,
											"orderedOn"=>$orderedOn,
											"Status"=>$Status,
											"OrderId"=>$postdata['orderid'],
											"TotalAmount"=>$total_amount_cart 
										);
				}
		
	}
	else
	{
		$output['invalidOrder'] = "yes";
	}//check whether the order exists or not else part
	
	echo json_encode($output);
	
}


//get the sub category types if any

public function getsubcattypes()
{
	
	$table='subcattypes';
	$cond=array();
	
	extract($_GET);
	$order_by='ASC';
	$order_by_field='Type';
	$limit='';
	
	$outputdata = array();
	
	$subcat_types = $this->db->select('*')->from('subcattypes')->where("Type LIKE '%$term%'")->get();
	//$subcat_types = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
	//print_r($subcat_types->result()); 
	if($subcat_types!='0')
	{
		foreach($subcat_types->result() as $data)
		{
			$outputdata[] = $data->Type;
		}
	}
	
	echo json_encode($outputdata);
}


//get the product details

public function getProduct()
{
	$_POST = $this->striptags($_POST);
	
	
	extract($_POST)	;
		
	$output = array();
	
	$cartitems = array();

//explode the product id with an underscore 
	
	$expl = explode("_",$productid);
//echo $expl[0]; exit; 
//echo sizeof($expl);
	if( sizeof($expl)>1) // check whether the product id contains any underscore based on that we are splitting prdid and package id
	{
		
		$productId = $expl[0]; 	
		$packageId = $expl[1];

	}
	else
	{
		// if it does not had any underscore with the package id then we will make a call to the database for the package id
		$productId = $expl[0];	
		
		// get the default package id for this product
		$cond = array();
		$cond['ProductId'] = $expl[0];
		$table= 'packagintypes';
		$order_by='ASC';
		$order_by_field='Id';
		$limit='1';
		
		$qry = $this->Commonmodel->getrows($table,$cond,$order_by,$order_by_field,$limit);

		foreach($qry->result() as $res)
		{
			$packageId = $res->Id;
		}
		
	}
//check whether the lastcartItem is sessioned or not 

	if( $this->session->userdata('lastcartItem')!='')
	{
		//if so then the we are loading that into an array called cartitems	
		$cartitems = $this->session->userdata('lastcartItem'); //load the sessioncart items into the array
		
		$Prdidincart = array();
		$Pkdidincart = array();
		$found="0";
		$output['incart']="no";
		
		//echo $packageId.":".$productId."<pre>";print_r($cartitems); echo "</pre>";
		//looping through that 
		foreach($cartitems as $key=>$val_arrays)
		{
			/*
			print_r($cartitems[$key]);
			echo "<br>";
			*/
			$Prdidincart = $val_arrays['ProductId'];
			$Pkdidincart = $val_arrays['PackageId'];

		//check whether the package id with this procuct is avalable in the cart or not if so then we are making an output array with key as incart to yes if not making an output array with key as incart to no
			if( $cartitems[$key]['ProductId']==$productId && $cartitems[$key]['PackageId']==$packageId )
			{
				$quantity=$cartitems[$key]['Quantity'];
				$found="1";
				$output['incart']="yes";
			}
			
		}
		if($found=="0")
		{
			$output['incart']="no";	
		}
		

	}
	else
	{
		$output['incart']="no";
	}

//querying the database to get the details of the product selected to view

$this->db->select('mes.MeasurementUnit,bse.Baseuom as packagetype,b.BrandName, prd.ProductName, prd.ProductImage, pkg.Price as ProductPrice, pkg.Netweight as NetWeight, pkg.Grossweight as GrossWeight,prd.ReadyTo, prd.BaseUOM');
	$this->db->from('products as prd');
	$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
	$this->db->join('baseuom as bse', 'bse.baseid=prd.BaseUOM');
	$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
	$this->db->join('brands as b','b.BrandId=prd.BrandId');
	$this->db->where('pkg.ProductId',$productId);
	if($packageId>0)
	{
		$this->db->where('pkg.Id',$packageId);
	}
	
	$this->db->where('prd.ProductId',$productId);
	$prddetails = $this->db->get('');

#echo $this->db->last_query(); exit; 	

	if($prddetails->num_rows()>0)
	{
		$output['Noproducts'] = "no";
		if($output['incart']=="yes")
		{
			$quantity = $quantity;
		}
		else
			$quantity = 1;
		foreach($prddetails->result() as $prdct)
		{
			$output['products']  = array(
											"BrandName"=>$prdct->BrandName,
											"Name"=>$prdct->ProductName,
											"PackageId"=>$packageId,
											"MeasurementUnit"=>$prdct->MeasurementUnit,
											"ProductPrice"=>$prdct->ProductPrice,
											"ProductImage"=>$prdct->ProductImage,
											"NetWeight"=>$prdct->NetWeight,
											"GrossWeight"=>$prdct->GrossWeight,
											"ReadyTo"=>$prdct->ReadyTo,											
											"BaseUOM"=>$prdct->BaseUOM,
											"packagetype"=>$prdct->packagetype,
											"ProductId"=>$productId,
											"Quantity"=>$quantity
										
										);
		}
	}
	else
	{
		$output['Noproducts'] = "yes";
	}
//finally sending the output array with some keys as the response to the ajax call
	echo json_encode($output);
}

public function addtocart()
{
	$_POST = $this->striptags($_POST);
	extract($_POST);
	$cartitems = array();

//first explode the product id with and underscore, when we explode it will create an array

	$expl = explode("_",$productid);
	
	//check whether i had appended with an underscore and package id or not by checking the size of the expl array
	if(sizeof($expl)>1)
	{
		//if it had appended with an underscore and package id then 
		$prdid = $expl[0];// first will be the product id
		$pkgid = $expl[1];	//second will be the package id
	}
	else
	{
		
		//if not appended with an underscore and package id then make a call to the database table for the package id (Means that product had only one package)
		$prdid = $productid;
		
		$cond = array();
		$table='packagintypes';
		
		$cond['ProductId'] = $productid;
		
		$order_by='ASC';
		$order_by_field='Id';
		$limit='1';
		
		$qry = $this->Commonmodel->getrows($table,$cond,$order_by,$order_by_field,$limit);
		
		foreach($qry->result() as $data)
		{
			$pkgid = $data->Id;	
		}
		
		
	}
	
	//echo "$prdid:$pkgid"; exit; 
	
	$cond = array();
	$table="";

//check whether the cart is empty or not
	
	if( $this->session->userdata('lastcartItem')!='')
	{
		
		
		//print_r($this->session->userdata('lastcartItem')); exit;
		
		$cartitems = $this->session->userdata('lastcartItem'); //load the sessioncart items into the array
		$Idincart = array();
		$PkgIdincart = array();

		//store the repective ids and packages into different arrays
		foreach($cartitems as $val_arrays)
		{
			$Idincart[] = $val_arrays['ProductId'];
			$PkgIdincart[] = $val_arrays['PackageId'];
			
		}
		
		if(in_array($prdid,$Idincart))// check whether the product is already added to the cart or not
		{
		//	echo "$prdid:$pkgid";
			if(in_array($pkgid,$PkgIdincart) )
			{
				
			}
			else
			{
				//if the product id with this package id is not there in the cart then add it to the cart and make a sesison of it 
				$cartitems[]= array("ProductId"=>$prdid,"PackageId"=>$pkgid,"Quantity"=>$qty_val);
				$this->session->set_userdata('lastcartItem',$cartitems);
				echo sizeof($cartitems);	
			}
		}
		else //if not added then add it to the session
		{

				$cartitems[]= array("ProductId"=>$prdid,"PackageId"=>$pkgid,"Quantity"=>$qty_val);
				$this->session->set_userdata('lastcartItem',$cartitems);
				echo sizeof($cartitems);
			
		}
	
	
	}
	else
	{
		//if it is empty store the product id with the package id and its qwuantity to the cartitems and make it a session
		$cartitems[]= array("ProductId"=>$prdid,"PackageId"=>$pkgid,"Quantity"=>$qty_val);
		$this->session->set_userdata('lastcartItem',$cartitems);
		echo sizeof($cartitems);
	}
	
}

public function alterCart()
{
	$_POST = $this->striptags($_POST);
	extract($_POST);
	
	$cartitems = array();
	$cnt=0;
	$cartitems = $this->session->userdata('lastcartItem'); //load the sessioncart items into the array

//print_r($cartitems); 
//explode the product id with an underscore 
$expl = explode("_",$productid);
//echo $expl[0]; exit; 
//echo sizeof($expl);
	if( sizeof($expl)>1) // check whether the product id contains any underscore based on that we are splitting prdid and package id
	{
		$packageId = $expl[1];
		$productId = $expl[0]; 	
	//	echo $packageId; exit; 
	}
	else
	{
		$productId = $expl[0];	
		
		
		// get the default package id for this product
		$cond = array();
		$cond['ProductId'] = $expl[0];
		$table= 'packagintypes';
		$order_by='DESC';
		$order_by_field='Id';
		$limit='1';
		
		$qry = $this->Commonmodel->getrows($table,$cond,$order_by,$order_by_field,$limit);

		foreach($qry->result() as $res)
		{
			$packageId = $res->Id;
		}
		
	}

/*
echo $productId.":".$packageId;
echo "<pre>";
print_r($cartitems); 
echo "</pre>";	
*/
	foreach($cartitems as $key=>$val_arrays)
	{
		
		if( $val_arrays['ProductId'] == $productId  && $val_arrays['PackageId'] == $packageId)		
		{
			if($Inc_dec=="Inc")
				$Quant = $val_arrays['Quantity']+1;
			else
				{
					if($val_arrays['Quantity']>1)
					$Quant = $val_arrays['Quantity']-1;
					else
					$Quant = '1';
				}
				
			$cartitems[$key]=array(
									"ProductId"=>$productId,
									"PackageId"=>$packageId,
									"Quantity"=>$Quant
									);
$this->session->set_userdata('lastcartItem',$cartitems);									
			print_r($cartitems[$key]);
		
		}
		
		$cnt++;
	}
	

}

public function clearcart()
{
	
	$cartitems = array();
	$this->session->set_userdata('lastcartItem','');	
	echo "1";	
}
//delete a product from the cart

public function deletePrdCart()
{
	$_POST = $this->striptags($_POST);
	extract($_POST);
	$deleted="0";
	
	
	
//print_r($cartitems); 

$expl = explode("_",$productId);
//echo $expl[0]; exit; 
//echo sizeof($expl);
	if( sizeof($expl)>1) // check whether the product id contains any underscore based on that we are splitting prdid and package id
	{
		$packageId = $expl[1];
		$productId = $expl[0]; 	
	//	echo $packageId; exit; 
	}
	else
	{
		$productId = $expl[0];	
		
		
		// get the default package id for this product
		$cond = array();
		$cond['ProductId'] = $expl[0];
		$table= 'packagintypes';
		$order_by='DESC';
		$order_by_field='Id';
		$limit='1';
		
		$qry = $this->Commonmodel->getrows($table,$cond,$order_by,$order_by_field,$limit);

		foreach($qry->result() as $res)
		{
			$packageId = $res->Id;
		}
		
	}

	
//	echo $productId.":".$packageId; exit; 
	
	if( $this->session->userdata('lastcartItem')!='')
	{
		
		$cartitems = $this->session->userdata('lastcartItem'); //load the sessioncart items into the array
		//print_r($cartitems);
		$incart = array();
		//echo "<br>";
		foreach($cartitems as $key=>$val_arrays)
		{
			//if($val_arrays['ProductId'] == $productId)
			if( $val_arrays['ProductId'] == $productId  && $val_arrays['PackageId'] == $packageId)	
			{
					unset($cartitems[$key]);
					$this->session->set_userdata('lastcartItem',$cartitems);
					$deleted = "1";
			}
				
		}
		echo $deleted;
	}
	
	
}//delete product fromcart ends here

//confirmOrder starts here
public function confirmOrder()
{
	

	//check whether store had a authotized email or not
	$table='userdetails';
	$cond=array();
	$cond['SLNO'] = $this->session->userdata('userslno');
	$field='AuthorisedEmail';
	$order_by='';
	$order_by_field='';
	$limit='';
	
	if($this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='')!='')
	{
		
$cartitems = array();
$cartitems = $this->session->userdata('lastcartItem');
//echo "<pre>";
//print_r($cartitems); exit; 
$incart = array();
$product = '';

$total_amount_cart = 0;
$rowcnt=0;	
	
	//sending the order to the orders and orderproducts table
	
	$insertdata = array();
	$table='orders';
	
	$insertdata['OrderBy'] =  $this->session->userdata('userslno');
	$insertdata['OrderStatus'] = 'Awaiting';
	
	$insertdata['TotalProducts'] = sizeof($cartitems);
	$insertdata['OrderedOn'] = date('Y-m-d H:i:s');
	$insertdata['LastUpdated'] = date('Y-m-d H:i:s');

	$orderId = $this->Commonmodel->insertdata($table,$insertdata);



foreach($cartitems as $val_arrays)
	{
	
	$insertdata = array();
	$table='orderproducts';
	
	$insertdata['OrderId'] =  $orderId;
	$insertdata['Product'] = $val_arrays['ProductId'];
	$insertdata['PackageId'] = $val_arrays['PackageId'];
	
	$insertdata['Quantity'] = $val_arrays['Quantity'];
	$insertdata['OrderedOn'] = date('Y-m-d H:i:s');
	

	$this->Commonmodel->insertdata($table,$insertdata);
	}

	
	$template = '
<div style="margin:0px; padding:0px; font-family:calibri; font-size:14px;">

<div style="width:700px;  margin:auto; background:#79ad29; padding:27px 0px 27px 0px;">
  <div style="width:590px; border-bottom:none;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6;">
    <div style="width:239px; height:64px; float:left;"> <img src="'.base_url().'resources/site/img/demo-store-1401086283.jpg" /> </div>
    <div style="width:190px; float:right; height:64px;">
      <p style="font-family:calibri; float:right; font-size:16px; font-style:italic; color:#122856;"><a href="javascript:void(0)" style="text-decoration:none; color:#6da218; line-height:64px; height:64px; float:left;" target="_blank">www.website.com</a></p>
    </div>
    <div style="clear:both"></div>
  </div>
  <div style="width:590px;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6; border-top:0px;">
    <p style="margin-bottom:15px; font-size:14px;">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout:</p>
    <div class="order-colm row" style="width:540px;padding: 25px;border: 1px solid #eee;box-shadow: 0 0 5px #ccc;margin-bottom: 15px;">
        <h3 class="text-left" style="border-bottom: 1px solid #eee;padding: 0 0 15px;margin-bottom: 15px;color: #212121;    font-weight: 500;
    line-height: 1.1; margin-top:19px; font-size:30px;">Order Summary</h3>
        
        <div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;">
            <div class="row">
                <span style="font-weight: 600;color: #000;width:225px;float:left; font-size:14px;">Product</span>
                <span style="font-weight: 600;color: #000;width:112px;float:left; font-size:14px; text-align:center;">Cost</span>
                <span style="font-weight: 600;color: #000;width:112px;float:right; font-size:14px;text-align:right;">Total Price</span>
            </div>
        </div>';
		
   	
	
foreach($cartitems as $val_arrays)
	{
		
	$rowcnt++;
//calling thedatabase for the product

$this->db->select('mes.MeasurementUnit,bse.Baseuom as packagetype, prd.ProductName, pkg.Price as ProductPrice, prd.ProductImage, pkg.Netweight as NetWeight, pkg.Grossweight as GrossWeight,prd.ReadyTo, prd.BaseUOM');
$this->db->from('products as prd');
$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
$this->db->join('baseuom as bse', 'bse.baseid=prd.BaseUOM');
$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
$this->db->where('prd.ProductId',$val_arrays['ProductId']);
$this->db->where('pkg.Id',$val_arrays['PackageId']);
$prddetails = $this->db->get('');

     
    
foreach($prddetails->result() as $product )
{
	$ProductImage = $product->ProductImage;
	$ProductName = $product->ProductName;
	$GrossWeight  = $product->GrossWeight;
	$ProductPrice = ($product->ProductPrice)*($val_arrays['Quantity']); 
	$MeasurementUnit = $product->MeasurementUnit;
	$total_amount_cart = $total_amount_cart+$ProductPrice;
	
}

$quantity = $val_arrays['Quantity'];

$template.='<div style="width:530px;display:table;height:auto;"> <div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;">  <div class="row">  <div  style="font-weight: 400;color: #000;width:225px;float:left; font-size:14px;"> <span style="overflow: hidden; max-width: 160px; white-space: pre; text-overflow: ellipsis; float: left; display: inline-block; margin-right: 5px; float:left;">'.$ProductName.'</span> x  <span class="order_prod_qty">'.$quantity.'</span>  </div> <span style="font-weight: 400;color: #000;width:112px;float:left; font-size:14px; text-align:center;">Rs. '.$ProductPrice/$quantity."/".$GrossWeight." ".$MeasurementUnit.'</span>  <span style="font-weight: 400;color: #000;width:112px;float:right; font-size:14px; text-align:right;">Rs. '.$ProductPrice.'/-</span></div></div></div>';



	}    

	$id=(double)(($orderId)*526825.24);
	$order_encoded = base64_encode($id);

//update total amount for this order in the orders table

//$orderId

$cond= array();
$cond['OrderId'] = $orderId;

$table= 'orders';

$setdata = array();
$setdata['Total_Amount'] = $total_amount_cart;

$this->Commonmodel->updatedata($table,$setdata,$cond);
        
	$template.= '<div style="width:530px;display:table;height:auto;">
            <div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;">
                <span style="font-weight: 600;color: #000;width:337px;float:left; font-size:14px;">TOTAL</span>
                <span style="font-weight: 600;color: #000;width:112px;float:right; font-size:14px;text-align:right;">Rs. '.$total_amount_cart.'/-</span>
            </div>
        </div>
        
        <a href="'.base_url('confirm-order/'.$order_encoded).'" style="width:200px; height:60px; line-height:60px; font-size:20px; margin:15px 0 0; float:right; overflow:hidden; text-align:center;color: white;background-color: #7ebb1e;border-color: #7ebb1e; text-decoration:none;">
        	Authorize order
        </a>
        <div style="clear:both;"></div>
    </div>
    
  </div>
  <div style="width:590px; background:#fff;color:#222; padding: 26px 26px 16px; margin:auto;  border:1px solid #d6d5d6; border-top:none;  background:#eee;">
    <p style="color:rgb(51,51,51); font-size:13px; text-align:center;margin-bottom:5px;"> Ecom Food &ensp; &ensp; Email : <a href="javascript:void(0)" style="text-decoration:none; color:rgb(51,51,51);">emailid@website.com </a></p>
  </div>
</div>

</div>';


$table='userdetails';
$cond=array();
$cond['SLNO'] = $this->session->userdata('userslno');

$field='AuthorisedEmail';

$order_by='';
$order_by_field='';
$limit='';

$toemail = $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');

$subject = 'Confirm Order';

if($this->sendEmail($toemail,$subject,$template))
{
	if($orderId>0) 
	{ 
	
		$cartitems = array();
		$cartitems = $this->session->set_userdata('lastcartItem','');
		$msg = "<div class='alert alert-success'>Please check your email your order is in awaiting list </div>";

		$this->session->set_flashdata('AwaitingList',$msg);
		echo "1";
		
	 }
	else
	{
		echo "-1";	
	}	
}
else  { echo "0"; }
//$this->email->print_debugger();
	
	}
	else
	{
		$msg = "<div class='alert alert-danger'> Pleased provide authorized email in your profile before confirming your order</div>";
		$this->session->set_flashdata('AwaitingList',$msg);
		echo "no";	
	}



}
//confirmOrder ends here
    

//approve order starts here

public function approveOrder()
{
	$_POST = $this->striptags($_POST);
	extract($_POST);
	$total_amount_cart=0;
	

$subject = 'Order has been confirmed by the user';
	//check whether the order is already approved or not

	$cond = array();
	$cond['OrderId'] = $OrderID;
	$table="orders";
	$field='OrderStatus';
	$order_by='';
	$order_by_field='';
	$limit='';

	$status = $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');
	if($status!='0')
	{
		//check whether the status isawaiting or not
		if($status == "Awaiting")
		{
			
		$template = $this->Orderstatustemplate($status,$OrderID,'');			
//echo $template; exit; 
$toemail = 'sudhaker.ssr@gmail.com'; //admin email 

if($this->sendEmail($toemail,$subject,$template))
{
	$msg = "<div class='alert alert-success'>Thank you for approval we will get back to you very soon..</div>";
	$this->session->set_flashdata('Appoved',$msg);
	echo "1";//if mail sends
}
else
	echo "2";//if mail failed to send

	
		
		}//if awaiting
		else
		{
			echo "-1";
		}
	}
	else
		echo "0";//if order witht the conditions is not available
}//approveOrder ends here



//get the getfilteredProducts 
public function getfilteredProducts()
{
	
	$sucateg_ID ='';
	$type_ID ='';
	$readyto ='';
	$product='';
	
	
	$_POST = $this->striptags($_POST);
	
	/*
	echo "<pre>";
	print_r($_POST); exit; */
	
	if( array_key_exists('Product_wise',$_POST) )
	{
		if( $_POST['Product_wise']!= "0" )
		$this->db->where('prd.ProductName',trim($_POST['Product_wise']));
	}
	
	if( array_key_exists('type',$_POST) )
	{
		if( $_POST['type']!= "0" )
		$this->db->where('prd.Type',trim($_POST['type']));
	}
	if( array_key_exists('readyto',$_POST) )
	{
		if($_POST['readyto']!='Ready To')
		$this->db->where('prd.ReadyTo',trim($_POST['readyto']));
	}
	if( $this->session->userdata('BrandId')!='')
			$this->db->where('prd.BrandId',trim($this->session->userdata('BrandId')));

if( $this->session->userdata('subcategoryide')!='')
{
	if( array_key_exists('subcateg',$_POST) )
	{
		if( $_POST['subcateg']!= "0" )
		$this->db->where('prd.Sub_CatId',trim($_POST['subcateg']));
	}
	else
	$this->db->where('prd.Sub_CatId',trim($this->session->userdata('subcategoryide')));			
}
else
{
	if( array_key_exists('subcateg',$_POST) )
	{
		if( $_POST['subcateg']!= "0" )
		$this->db->where('prd.Sub_CatId',trim($_POST['subcateg']));
	}	
}
					

	extract($_POST);

	$this->db->select('mes.MeasurementUnit, prd.ProductName,b.BrandName,b.BrandId, prd.ProductPrice, prd.ProductId, prd.ProductImage, prd.NetWeight');
	$this->db->from('products as prd');
	$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
	$this->db->join('brands as b','b.BrandId=prd.BrandId');
	$this->db->where('prd.Category_Id',$_POST['categID']);
	$this->db->where('b.Status','Active');
	
	//the below line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status
		
	$this->db->where('prd.Status','Active');
		
	//the above line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status ends here
	
	$this->db->group_by('prd.ProductName');
	$this->db->group_by('prd.BrandId');
	$this->db->order_by('prd.ProductName','ASC');
	$total_records = $this->db->get('');
	
	/*
	echo $this->db->last_query();
	echo "<br>";
	echo $total_records->num_rows(); exit; 
	*/
	
	if( array_key_exists('Product_wise',$_POST) )
	{
		if( $_POST['Product_wise']!= "0" )
		$this->db->where('prd.ProductName',trim($_POST['Product_wise']));
	}
	if( array_key_exists('subcateg',$_POST) )
	{
		if( $_POST['subcateg']!= "0" )
		$this->db->where('prd.Sub_CatId',trim($_POST['subcateg']));
	}
	if( array_key_exists('type',$_POST) )
	{
		if( $_POST['type']!= "0" )
		$this->db->where('prd.Type',trim($_POST['type']));
	}
	if( array_key_exists('readyto',$_POST) )
	{
		if($_POST['readyto']!='Ready To')
		$this->db->where('prd.ReadyTo',trim($_POST['readyto']));
	}
	if( $this->session->userdata('BrandId')!='')
			$this->db->where('prd.BrandId',trim($this->session->userdata('BrandId')));
			
/*
if( $this->session->userdata('subcategoryide')!='')
			$this->db->where('prd.Sub_CatId',trim($this->session->userdata('subcategoryide')));		
*/
	$this->db->select('mes.MeasurementUnit, prd.ProductName,b.BrandName,b.BrandId, prd.ProductPrice, prd.ProductId, prd.ProductImage, prd.NetWeight');
	$this->db->from('products as prd');
	$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
	$this->db->join('brands as b','b.BrandId=prd.BrandId');
	$this->db->where('prd.Category_Id',$_POST['categID']);
	$this->db->where('b.Status','Active');
	
	//the below line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status
		
	$this->db->where('prd.Status','Active');
	
	//the above line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status ends here
	
	
	$this->db->group_by('ProductName');
	$this->db->group_by('prd.BrandId');
	$this->db->order_by('prd.ProductName','ASC');
	
	if( array_key_exists('pge',$_POST) )
	{
		$upperlimit = ($_POST['pge']-1)*15;
		$page=$_POST['pge'];
	}
	else
	$page=1;
	
	

	if($total_records->num_rows()>$totalProducts && $comingFrom == "scroll")
		$this->db->limit(15,$upperlimit);
	else
		$this->db->limit(15,0);
		
	
	$prddetails = $this->db->get('');
	
	#echo $this->db->last_query(); exit;
	?>
   <ul class="tm-carousel product_list" style="display:block;">
   
    <?PHP
	if($total_records->num_rows()>$totalProducts && $comingFrom == "scroll")
	{
		$cartitems = array();
		$Prdidincart = array();
		$Pkdidincart = array();
		
		if( $this->session->userdata('lastcartItem')!='')
		{
			$cartitems = $this->session->userdata('lastcartItem'); //load the sessioncart items into the array
		
		
			foreach($cartitems as $val_arrays)
			{
				$Prdidincart[] = $val_arrays['ProductId'];
				$Pkdidincart[] = $val_arrays['PackageId'];
			}
		}
		
	foreach($prddetails->result() as $prdct)
	{
		
					?>
<li class="item last-item-of-mobile-line col-sm-4 allproducts" id="PRD_<?PHP echo $prdct->ProductId; ?>" total_prdcts="<?PHP echo $total_records->num_rows(); ?>">
                        <div class="product-container">
						 <!-- <div class="product_brand_icon"><img src="resources/site/img/brands/mccain-logo.jpg" alt="" class="img-responsive" /></div>-->
                         <?PHP
						 /*
							$id=(double)(($prdct->ProductId)*526825.24);
							$prd_encoded = base64_encode($id);
							*/
							$prd_encoded = base64_encode($prdct->ProductId);
						  ?>
                          
                          <div class="left-block">
                            <div class="product-image-container"> 
                            <a class="product_img_link" href="<?PHP echo base_url('product-view/').$prd_encoded."/".str_replace(" ","-",$prdct->ProductName); ?>" title="Nascetur ridiculus mus" itemprop="url"> 
                            <img class="replace-2x img-responsive" src="<?PHP echo $prdct->ProductImage?>" alt="" title="" width="220" height="200" itemprop="image" /> 
                            </a> 
                            </div>
                          </div>
                          
                          <div class="right-block">
<h5><a class="product-name" href="<?PHP echo base_url('product-view/').$prd_encoded."/".str_replace(" ","-",$prdct->ProductName); ?>" title=""><b><?PHP echo $prdct->BrandName."-".$prdct->ProductName?></b></a></h5>
                           

<?PHP
$this->db->select('prd.ProductId,ms.MeasurementUnit, bs.Baseuom,pkg.Id as packageid, pkg.Price as ProductPrice, pkg.Netweight as NetWeight');
$this->db->from('products as prd');
$this->db->join('baseuom as bs','bs.baseid=prd.BaseUOM');
$this->db->join('measurements as ms','ms.MeasurementId=prd.MeasurementUnit');
$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
$this->db->where('prd.ProductName',$prdct->ProductName);
$this->db->where('prd.BrandId',$prdct->BrandId);
$this->db->where('pkg.ProductId',$prdct->ProductId);

//the below line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status
		
$this->db->where('prd.Status','Active');
		
//the above line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status ends here


$this->db->order_by('prd.ProductName','ASC');
$pkgng_types = $this->db->get('');

if($pkgng_types->num_rows()>1)
{

?>  
<div class="form-group">
<select class="form-control pkgtypes"  pdk_id="<?PHP echo $prdct->packageid;?>">
<?PHP
$cnt=0;
	foreach($pkgng_types->result() as $pkgtype)
	{
		if($cnt==0)
		{
			$packageId = $pkgtype->packageid;
			$packageIde = $packageId;
		}
		$cnt++;
?>
	<option value="<?PHP echo $pkgtype->ProductId."_".$pkgtype->packageid; ?>"><?PHP echo $pkgtype->NetWeight." ".$pkgtype->MeasurementUnit."-Rs ".$pkgtype->ProductPrice; ?> </option>

<?PHP
	}
?>
</select>
</div>
<?PHP
}
else
{
	foreach($pkgng_types->result() as $pkgtype)
	{
		$packageIde = "_".$pkgtype->packageid;
		$packageId = $pkgtype->packageid;
		
	?>
 <p><a class="product-name" href="<?PHP echo base_url('product-view/').$prd_encoded."/".str_replace(" ","-",$prdct->ProductName); ?>" title=""><i class="fa fa-inr" aria-hidden="true"></i> <?PHP echo $pkgtype->ProductPrice?>/<?PHP echo $pkgtype->NetWeight?><?PHP echo $pkgtype->MeasurementUnit?></a></p>
<?PHP
	}
}
?>

<span class="btn btn-default product_view" id="<?PHP echo $prdct->ProductId;?>" data-toggle="modal" data-target="#myModal" ><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                            
                            <span class="btn btn-default add-to-cart ">
                            <?PHP
							
							/*
								$Prdidincart[] = $val_arrays['ProductId'];
								$Pkdidincart[] = $val_arrays['PackageId'];
							*/							
							if(in_array($prdct->ProductId,$Prdidincart))
							{
								if(in_array($packageId,$Pkdidincart))
								{
							?>
                           			 <a class="addedtocart" style="color:red"  >In Cart</a>
                            <?PHP
								}
									else
									{
									?>
							<a class="addtocart" id="<?PHP echo $prdct->ProductId.$packageIde;?>"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
									<?PHP 
									}
								
							}
							else
							{
							?>
                       		  <a class="addtocart" id="<?PHP echo $prdct->ProductId.$packageIde;?>"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
                            <?PHP 
							}
							?>
                            </span>


                          </div>
                        </div>
                      </li>
                      
                  <?PHP
				  
				}
			
		
	
	
	
	
	}
	else
	{	
		if($comingFrom != "scroll" && $total_records->num_rows()>0)
		{
		 
		$cartitems = array();

		$Prdidincart = array();
		$Pkdidincart = array();
		
		if( $this->session->userdata('lastcartItem')!='')
		{
			$cartitems = $this->session->userdata('lastcartItem'); //load the sessioncart items into the array

			foreach($cartitems as $val_arrays)
			{
				$Prdidincart[] = $val_arrays['ProductId'];
				$Pkdidincart[] = $val_arrays['PackageId'];
			}
		}
		
	foreach($prddetails->result() as $prdct)
	{
		
					?>
<li class="item last-item-of-mobile-line col-sm-4 allproducts" id="PRD_<?PHP echo $prdct->ProductId; ?>" total_prdcts="<?PHP echo $total_records->num_rows(); ?>">
                        <div class="product-container">
						 <!-- <div class="product_brand_icon"><img src="resources/site/img/brands/mccain-logo.jpg" alt="" class="img-responsive" /></div>-->
                         <?PHP
							$id=(double)(($prdct->ProductId)*526825.24);
							$prd_encoded = base64_encode($prdct->ProductId);
						  ?>
                          
                          <div class="left-block">
                            <div class="product-image-container"> 
                            <a class="product_img_link" href="<?PHP echo base_url('product-view/').$prd_encoded."/".str_replace(" ","-",$prdct->ProductName); ?>" title="Nascetur ridiculus mus" itemprop="url"> 
                            <img class="replace-2x img-responsive" src="<?PHP echo $prdct->ProductImage?>" alt="" title="" width="220" height="200" itemprop="image" /> 
                            </a> 
                            </div>
                          </div>
                          
                          <div class="right-block">
                         
                          	<h5><a class="product-name" href="<?PHP echo base_url('product-view/').$prd_encoded."/".str_replace(" ","-",$prdct->ProductName); ?>" title="">
<?PHP 
//if( $this->session->userdata('BrandId')!='')
echo "<b>".$prdct->BrandName."-".$prdct->ProductName."</b>";
/*
else
	echo "<b>".$prdct->ProductName."</b>";
*/	
?>
 </a></h5>
                           

<?PHP




//get the available packin types

/*
$this->db->select('prd.ProductId,ms.MeasurementUnit, bs.Baseuom, prd.ProductPrice, prd.NetWeight');
$this->db->from('products as prd');
$this->db->join('baseuom as bs','bs.baseid=prd.BaseUOM');
//$this->db->join('brands as br','br.BrandId=prd.BrandId');
$this->db->join('measurements as ms','ms.MeasurementId=prd.MeasurementUnit');
$this->db->where('prd.ProductName',$prdct->ProductName);
//$this->db->where('br.BrandName',$prdct->BrandName);
$this->db->where('prd.ProductName',$prdct->ProductName);
$this->db->order_by('prd.ProductName','ASC');
$pkgng_types = $this->db->get('');
*/
/*
$this->db->select('prd.ProductId,ms.MeasurementUnit, bs.Baseuom, prd.ProductPrice, prd.NetWeight');
$this->db->from('products as prd');
$this->db->join('baseuom as bs','bs.baseid=prd.BaseUOM');
$this->db->join('measurements as ms','ms.MeasurementId=prd.MeasurementUnit');
$this->db->where('prd.ProductName',$prdct->ProductName);
$this->db->where('prd.BrandId',$prdct->BrandId);
$this->db->order_by('prd.ProductName','ASC');
$pkgng_types = $this->db->get('');
*/

$this->db->select('prd.ProductId,ms.MeasurementUnit, bs.Baseuom, pkg.Id as packageid, pkg.Price as ProductPrice, pkg.Netweight as NetWeight');
$this->db->from('products as prd');
$this->db->join('baseuom as bs','bs.baseid=prd.BaseUOM');
$this->db->join('measurements as ms','ms.MeasurementId=prd.MeasurementUnit');
$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
$this->db->where('prd.ProductName',$prdct->ProductName);
$this->db->where('prd.BrandId',$prdct->BrandId);
$this->db->where('pkg.ProductId',$prdct->ProductId);

//the below line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status
		
$this->db->where('prd.Status','Active');
		
//the above line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status ends here


$this->db->order_by('prd.ProductName','ASC');
$pkgng_types = $this->db->get('');

if($pkgng_types->num_rows()>1)
{

?>  
<div class="form-group">
<select class="form-control pkgtypes" pdk_id="<?PHP echo $prdct->packageid;?>"> 
<?PHP
$cnt=0;
	foreach($pkgng_types->result() as $pkgtype)
	{
		
	if($cnt==0)
	{
		$packageId = $pkgtype->packageid;
		$packageIde = $packageId;
	}
	$cnt++;
?>
	<option value="<?PHP echo $pkgtype->ProductId."_".$pkgtype->packageid; ?>"><?PHP echo $pkgtype->NetWeight." ".$pkgtype->MeasurementUnit."-Rs ".$pkgtype->ProductPrice; ?> </option>

<?PHP
	}
?>
</select>
</div>
<?PHP
}
else
{
	foreach($pkgng_types->result() as $pkgtype)
	{
		$packageIde = "_".$pkgtype->packageid;
		$packageId = $pkgtype->packageid;
	?>
 <p><a class="product-name" href="<?PHP echo base_url('product-view/').$prd_encoded."/".str_replace(" ","-",$prdct->ProductName); ?>" title=""><i class="fa fa-inr" aria-hidden="true"></i> <?PHP echo $pkgtype->ProductPrice?>/<?PHP echo $pkgtype->NetWeight?><?PHP echo $pkgtype->MeasurementUnit?></a></p>

<?PHP
	}
}
?>
<span class="btn btn-default product_view" id="<?PHP echo $prdct->ProductId;?>" data-toggle="modal" data-target="#myModal" ><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                            
                            <span class="btn btn-default add-to-cart ">
                            <?PHP
							
							/*
								$Prdidincart[] = $val_arrays['ProductId'];
								$Pkdidincart[] = $val_arrays['PackageId'];
							*/							
							if(in_array($prdct->ProductId,$Prdidincart))
							{
								if(in_array($packageId,$Pkdidincart))
								{
							?>
                           			 <a class="addedtocart" style="color:red"  >In Cart</a>
                            <?PHP
								}
									else
									{
									?>
							<a class="addtocart" id="<?PHP echo $prdct->ProductId.$packageIde;?>"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
									<?PHP 
									}
								
							}
							else
							{
							?>
                       		  <a class="addtocart" id="<?PHP echo $prdct->ProductId.$packageIde;?>"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
                            <?PHP 
							}
							?>
                            </span>
                            
                          </div>
                        </div>
                      </li>
                      
                  <?PHP
				  
				}
			
		
	
	
		
		
		}
		else
			{
				$msg = "<li style='text-align:left'><div class='alert alert-danger'>No products avaliable </div></li>";
				echo $msg;	
			}
	}
	
	?>
    </ul>
    
    
    <?PHP	
	
	$totalProducts = $total_records->num_rows();
	if($totalProducts>15  )
	{
						
						
						$perPage = 15;
						$totalPages = ceil($totalProducts/$perPage);
						$startAt = $perPage * ($page-1);
						$links='';

						if($page<=$totalPages)
						{
						$prev=$page-1;
						
						if($prev<=0)
						{
							$prev=1;
						}
						
						if($page>1)
								$links=$links."<a class='getdata_click' id='1'>&laquo;</a>";
						
						
						//preparing the remaining pages
						
						for ($i = $page-2; $i<5+$page-2; $i++) 
						{
						
							if($i>0 && $i<=$totalPages)
							{
							
							$links .= ($i != $page ) ? "<a class='getdata_click' id='".$i."'> $i</a> " : "<a class='getdata_click active' id='".$i."'> $i</a>";
							
							}
							
							}
						}

						//next pages
						
				
				if($page<$totalPages)
				{
					$next=$page+1;
					
					if($next<0)
					{
					$next=1;
					}
					$links=$links."<a class='getdata_click' id='".$next."'>&raquo;</a>";
				
				}
				
				else
				{
					$next=$page+1;
					
					if($next>$totalPages)
					{
					$next=$totalPages;
					}
					if($next==$totalPages)
					{
					}
					else							
					$links=$links."<a class='getdata_click' id='".$next."'>".$page."-".$totalPages."&raquo;</a>";
				}
				
				
				//$links=$links."<a class='getdata_click' id='".$totalPages."'>Last</a>";
						
						?>
                        <div class="clearfix"></div>
                        <div class="pagination" style="float:left">
 							<?PHP echo $links;?>
                        </div>
                       <div style="display: inline-block; position: relative;  width: 50px; height: 50px; margin: 10px;  overflow: hidden; float: left; ">
                 	<div class="ajax_load" ></div>
                 </div>
                        <?PHP						
					
					}
	
	
}


//change the order status

public function changeOrderStatus()
{
	
	//exit; 
	
	$_POST = $this->striptags($_POST);
	extract($_POST);
	$cond = array();
	$table='orders';
	
	$cond['OrderId'] = $orderId;
	$setdata = array();
	$setdata['OrderStatus'] = $status;
	$setdata['LastUpdated'] = date('Y-m-d H:i:s');
	$subject = "Order has been $status";
	
	$auth = '';
	$reg = '';

$this->db->select('OrderStatus');
$this->db->from('orders');
$this->db->where('OrderId',$orderId);
$qry = $this->db->get();
$order_status = $qry->row('OrderStatus');

$proceed="yes";

if($order_status == "Shipped")
{
	if( $status == "Shipped" )
	{
		$proceed="no";
		
		$msg = "<div class='alert alert-danger'> Order you are trying to ship has been already shipped!!! </div>";
		$this->session->set_flashdata('ChangeOrder_status',$msg);
		
	}
	elseif($status == "Delivered" )
	{
		$proceed="yes";		
	}
	
	elseif($status == "Cancelled" )
	{
		$proceed="yes";		
	}
}

if($proceed == "yes")	
{
	$res = $this->Commonmodel->updatedata($table,$setdata,$cond);
//	echo $this->db->last_query(); exit; 
	if($res)
	{
		//get the store registered or authorized email
		
		$this->db->select('ud.Email,ud.AuthorisedEmail');
		$this->db->from('userdetails as ud');
		$this->db->join('orders or','or.OrderBy=ud.SLNO');
		$this->db->where('or.OrderId',$orderId);
		$qry = $this->db->get();
		
		foreach( $qry->result() as $fetch_data)
		{
			$auth = $fetch_data->AuthorisedEmail;
			$reg = $fetch_data->Email;
		}
 
		 $toemail2=$reg.",".$auth;
		 
		if($status=="Shipped")
		{
			$otherparam = "<p>Expected date of delivery is ".$scheduledOn." ".$hrs.":".$mins." $meri</p>";
			
			$dtd_create = date_create($scheduledOn);
			$dtd_format = date_format($dtd_create,"Y-m-d");
			$delivery_scheduled = $dtd_format." ".$hrs.":".$mins.":".date("s")." $meri";
			
			
			$this->Commonmodel->updatedata('orders',array("Expected_Delivery_date"=>$delivery_scheduled),array("OrderId"=>$orderId));
#echo $this->db->last_query(); exit; 
		}
		elseif($status == "Cancelled" )
		{
			$otherparam = '<p>'.$reason.'</p>';
		}
		else
		$otherparam = '';
		
		$template = $this->Orderstatustemplate($status,$orderId,$otherparam);	
		
		$toemail = 'sudhaker.ssr@gmail.com,'.$toemail2;
		
		$this->sendEmail($toemail,$subject,$template);
		$msg = "<div class='alert alert-success'> Order Status has been changed to <b> $status </b> </div>";
		$this->session->set_flashdata('ChangeOrder_status',$msg);
		echo "1";
	}
	else
	{
		
		$msg = "<div class='alert alert-danger'> unable to change order status to <b> $status</b> </div>";
		$this->session->set_flashdata('ChangeOrder_status',$msg);
		echo "0";
		
	}
	
}
else
{
	echo "1";	
}

}



//this section will create the template for the order status sucha as 
//confirmed by the user,
//shipped by the admin
//delivered by the admin
//cancelled by the admin

public function Orderstatustemplate($status,$OrderID,$otherParam)
{
	
			$cartitems = array();
			$template='fsdfs';
			$table='orderproducts';
			$cond=array();
			
			$order_by='';
			$order_by_field='';
			$limit='';
			
			$cond['OrderId'] = $OrderID;
			$data['OrderId'] = $OrderID;
			
			$products  = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
			
			//change the status to approve for the order
			
			$cond=array();
			$cond['OrderId'] = $OrderID;
			
			$setdata = array();
			$setdata['LastUpdated'] = date('Y-m-d H:i:s');
			$table='orders';
			$username='';
			$msg ='';
			$total_amount_cart=0;

	//setr the order status according to the parameter
	if($status=="Awaiting") { $setdata['OrderStatus'] ='Confirmed'; }		
	else if($status=="Shipped") { $setdata['OrderStatus'] ='Shipped'; }
	else if($status=="Delivered") { $setdata['OrderStatus'] ='Delivered'; }
	else if($status=="Cancelled") { $setdata['OrderStatus'] ='Cancelled'; }
	
	
		$this->db->where($cond);
		$qry=$this->db->update($table,$setdata);	

if($qry)//update the status

			{
			//	echo $this->db->last_query(); exit; 
				
		
				$this->db->select('usd.*');
				$this->db->from('orders as ord');
				$this->db->join('orderproducts as op','op.OrderId=ord.OrderId');
				$this->db->join('userdetails as usd','usd.SLNO=ord.OrderBy');
				$this->db->where('ord.OrderId',$OrderID);
				$userdetails = $this->db->get('');
				foreach($userdetails->result() as $user)
				{
				$username =	$user->Owner_Name;
				}
		
//set the message according to the parameter

		if($status=="Awaiting") { $msg=' User <b>'.strtoupper($username).'</b> has confirmed the order <b>(Order No:#'.$OrderID.')'; }
		else if($status=="Shipped") { $msg=' Products with the Order <b>(Order No:#'.$OrderID.') has been shipped'; }
		else if($status=="Delivered") { $msg='Thank you for ordering, your products with the Order <b>(Order No:#'.$OrderID.') has been delivered';  }
		else if($status=="Cancelled") { $msg='We are feeling very sad to say your products with the Order <b>(Order No:#'.$OrderID.') has been cancelled';   }				
				
		if($otherParam!='')		
		{
			$msg.="$otherParam";
		}
		
			$template = ' <div style="margin:0px; padding:0px; font-family:calibri; font-size:14px;"> <div style="width:700px;  margin:auto; background:#79ad29; padding:27px 0px 27px 0px;"> <div style="width:590px; border-bottom:none;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6;"> <div style="width:239px; height:64px; float:left;"> <img src="'.base_url().'resources/site/img/demo-store-1401086283.jpg" /> </div> <div style="width:190px; float:right; height:64px;"> <p style="font-family:calibri; float:right; font-size:16px; font-style:italic; color:#122856;"><a href="javascript:void(0)" style="text-decoration:none; color:#6da218; line-height:64px; height:64px; float:left;" target="_blank">www.website.com</a></p> </div> <div style="clear:both"></div> </div><div style="width:590px;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6; border-top:0px;"><p style="margin-bottom:15px; font-size:14px;">'.$msg.'</b></p><div class="order-colm row" style="width:540px;padding: 25px;border: 1px solid #eee;box-shadow: 0 0 5px #ccc;margin-bottom: 15px;"><h3 class="text-left" style="border-bottom: 1px solid #eee;padding: 0 0 15px;margin-bottom: 15px;color: #212121;    font-weight: 500;line-height: 1.1; margin-top:19px; font-size:30px;">Order Summary</h3><div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;"><div class="row"><span style="font-weight: 600;color: #000;width:225px;float:left; font-size:14px;">Product</span><span style="font-weight: 600;color: #000;width:112px;float:left; font-size:14px; text-align:center;">Cost</span><span style="font-weight: 600;color: #000;width:112px;float:right; font-size:14px;text-align:right;">Total Price</span></div></div>';
					

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
echo "<pre>";
print_r( $products->result() ); exit; 
*/
foreach($products->result() as $val_arrays)
	{
		
		

//calling thedatabase for the product

$this->db->select('mes.MeasurementUnit,bse.Baseuom as packagetype, prd.ProductName, pkg.Price as ProductPrice, prd.ProductImage, pkg.Netweight as NetWeight, pkg.Grossweight as GrossWeight,prd.ReadyTo, prd.BaseUOM');
$this->db->from('products as prd');
$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
$this->db->join('baseuom as bse', 'bse.baseid=prd.BaseUOM');
$this->db->join('packagintypes as pkg','pkg.ProductId=prd.ProductId');
$this->db->where('prd.ProductId',$val_arrays->Product);
$this->db->where('pkg.Id',$val_arrays->PackageId);
$prddetails = $this->db->get('');

     
    
foreach($prddetails->result() as $product )
{
	$ProductImage = $product->ProductImage;
	$ProductName = $product->ProductName;
	$GrossWeight  = $product->GrossWeight;
	$ProductPrice = ($product->ProductPrice)*($val_arrays->Quantity); 
	$MeasurementUnit = $product->MeasurementUnit;
	$total_amount_cart = $total_amount_cart+$ProductPrice;
	
}

$quantity = $val_arrays->Quantity;

$template.='<div style="width:530px;display:table;height:auto;"> <div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;">  <div class="row">  <div  style="font-weight: 400;color: #000;width:225px;float:left; font-size:14px;"> <span style="overflow: hidden; max-width: 160px; white-space: pre; text-overflow: ellipsis; float: left; display: inline-block; margin-right: 5px; float:left;">'.$ProductName.'</span> x  <span class="order_prod_qty">'.$quantity.'</span>  </div> <span style="font-weight: 400;color: #000;width:112px;float:left; font-size:14px; text-align:center;">Rs. '.$ProductPrice/$quantity."/".$GrossWeight." ".$MeasurementUnit.'</span>  <span style="font-weight: 400;color: #000;width:112px;float:right; font-size:14px; text-align:right;">Rs. '.$ProductPrice.'/-</span></div></div></div>';

	
	}    


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
$template.= '<div style="width:530px;display:table;height:auto;"> <div style="display: block;border-bottom: 1px solid #eee;width:530px;padding:10px 5px; height:auto; overflow:hidden;"> <span style="font-weight: 600;color: #000;width:337px;float:left; font-size:14px;">TOTAL</span> <span style="font-weight: 600;color: #000;width:112px;float:right; font-size:14px;text-align:right;">Rs. '.$total_amount_cart.'/-</span></div></div> <div style="clear:both;"></div></div></div><div style="width:590px; background:#fff;color:#222; padding: 26px 26px 16px; margin:auto;  border:1px solid #d6d5d6; border-top:none;  background:#eee;"> <p style="color:rgb(51,51,51); font-size:13px; text-align:center;margin-bottom:5px;"> Ecom Food &ensp; &ensp; Email : <a href="javascript:void(0)" style="text-decoration:none; color:rgb(51,51,51);">emailid@website.com </a></p></div></div></div>';
			
			}
else			
	{
		$template ="No template";
	}
	return $template;
	
}







//this section is used to send email to the emai id
//this will take below parameters

/*
toemail
subject
template
*/
	
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


// below funciton is used to get the product names available in the database at the time of adding products to the database

public function getproductNames()
{
/*
$get_data = $_GET;	
	
foreach($get_data as $key=>$val) { $_GET[$key] = strip_tags($val); }

			
	$table='subcattypes';
	$cond=array();
	
	$_GET = $this->striptags($get_data);
	*/
	extract($_GET);
	$order_by='ASC';
	$order_by_field='Type';
	$limit='';
	
	$outputdata = array();
	
	$prd_names = $this->db->select('*')->from('products')->where('BrandId',$brand)->where('Category_Id',$category)->where('Sub_CatId',$subcategory)->where("ProductName LIKE '$term%'")->group_by('ProductName')->get();

//echo $this->db->last_query(); exit; 

	if($prd_names!='0')
	{
		foreach($prd_names->result() as $data)
		{
			$outputdata[] = $data->ProductName;
		}
	}
	
	echo json_encode($outputdata);
	
			
}


//check whether the product is in cart or not
public function checkProductincart()
{
	$_POST = $this->striptags($_POST);
	
	extract($_POST);
	$expl = explode("_",$productid);

	if( sizeof($expl) > 1)
	{
		$prdid = $expl[0];
		$pkgid = $expl[1];
	}

	
	
	if($this->session->userdata('lastcartItem')!='')
	{
		//print_r($this->session->userdata('lastcartItem'));
		
		$cartitems = $this->session->userdata('lastcartItem'); //load the sessioncart items into the array
		$Prdidincart = array();
		$Pkdidincart = array();
		foreach($cartitems as $val_arrays)
		{
			$Prdidincart[] = $val_arrays['ProductId'];
			$Pkdidincart[] = $val_arrays['PackageId'];
		}
		if(in_array($prdid,$Prdidincart))
		{
			//echo "0";
			
			if(in_array($pkgid,$Pkdidincart))
			{
				echo "0";
			}
			else
				echo "1";
		}
		else
			echo "1";
		
	}
	else
	{
		echo "1";
	}
	
}//checkProductincart ends here

//encrypt the product id	
public function encryptProductid()
{

$_POST = $this->striptags($_POST);

	extract($_POST);
	
	//$id=(double)(($productid)*526825.24);
	echo base64_encode($productid);	
}

//reset password and send a mail to the user

public function resetpassword()
{
$_POST = $this->striptags($_POST);	
	
		extract($_POST);
	
		$toemail 					=	'';
		$auth  						= 	"";
		$subject 					=	'Reset password';
		
		//check whehter authorised email is set or not
		$table='userdetails';
		$field='AuthorisedEmail';
		$order_by='';
		$order_by_field='';
		$limit='';
		
		$cond=array();
		
		$cond['Email'] 	=	$forget_reg_email;
		
		$authorised = $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');
	//	echo $this->db->last_query(); exit; 
		$cond=array();
			
		if( $authorised!='' )
		{
			
			$cond['AuthorisedEmail'] 	=	$authorised;
			$toemail 					=	$authorised;
			$auth  						= 	"Authorized Email";
		}
		else
		{
			$cond['Email'] 				=	$forget_reg_email;
			$toemail 					=	$forget_reg_email;	
			$auth  						= 	"Registered Email";
		}
	
	//print_r($cond); exit; 
	
	$field='SLNO';	
	//get the SLNO 	
	$slno = $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');
	
	$table='users';
	
	//generate random password
	
	$cond = array();
	$cond['SLNO'] = $slno;
	
	$pwd = $this->saltedpassword->random_password(8);
	$Password = $this->saltedpassword->makeITcrypt($pwd);
	
	$setdata['Password']			= $Password['hashpassword'];
	$setdata['Salt'] 				= $Password['salt'];
	
	$setdata['LastUpdated']		= time();

	$exec_qry = $this->Commonmodel->updatedata($table,$setdata,$cond) ;

	#echo $cond['SLNO']."<br>"; print_r($setdata); exit; 	
	
	if( $exec_qry )
	{
		$template = "<h3>Your login password:</h3>".$pwd;
		$this->sendEmail($toemail,$subject,$template);
		
		$arr = array("Message"=>"done","to"=>$auth);
		echo json_encode($arr);
	}
	else
	{
		$arr = array("Message"=>"failed","to"=>$auth);
		echo json_encode($arr);
	}
		
		
}//resetpassword ends here

//edit product details except image

public function updateProductDetails()
{
	
	$table = 'packagintypes';
	
	$_POST = $this->striptags($_POST);
	extract($_POST);


	//prepare the query for updating the product details except image in the products table

//this section is to delete the pakcages if user deletes any 
//and deletes the packages if so

				$pkgid = array();
				$prd_pkgs = array();
				for($i=0;$i<sizeof($Pricing);$i++)
				{	
					if( array_key_exists('packageid',$Net[$i])) //check whether user added new packaging type if not
					{
						$pkgid[] = $Net[$i]['packageid'];
						$pkgid[] = $Gross[$i]['packageid'];
						$pkgid[] = $Quantity[$i]['packageid'];
						$pkgid[] = $Pricing[$i]['packageid'];
					}
				}
				
				//get the package ids for this product from the database
				
				$this->db->where('ProductId',$ProductId);
				$pkgns = $this->db->get('packagintypes');
				
				foreach($pkgns->result() as $pkg)
				{
					$prd_pkgs[] = 	$pkg->Id;
				}
				
				$removed = array_diff($prd_pkgs,$pkgid); // get the package ids which are deleted by the user if user deletes
				if(!empty($removed))
				{
					foreach($removed as $k=>$v)
					{
						//echo $removed[$k];
						$this->db->where('Id',$removed[$k]);
						$this->db->where('ProductId',$ProductId);
						$this->db->delete('packagintypes');
					}
				}
	
//this section is to delete the pakcages if user deletes any  ends here


//this section is to delete the pakcages if user deletes any
//also updates the packages if any intact one using the if block
///if any new added then insert them using the else block
	
	for($i=0;$i<sizeof($Pricing);$i++)
				{	
					if( array_key_exists('packageid',$Net[$i])) //check whether user added new packaging type if not
					{
						
							$cond['Id'] = $Net[$i]['packageid'];
							$cond['ProductId'] = $ProductId; 
							
							$setdata['Netweight'] = $Net[$i]['value'];
							$setdata['Grossweight'] = $Gross[$i]['value'];
							
							$setdata['Quantity'] = $Quantity[$i]['value'];
							$setdata['Price'] = $Pricing[$i]['value'];
							$setdata['Lastupdated'] = time();
							$table='';
							$table='packagintypes';
							$this->db->where($cond);
							$this->db->update($table,$setdata);
						
					}
					else ////check whether user added new packaging type if so insert new pacakage into the 
					{
						$table='packagintypes';
						$insertdata = array();
					
						$data['ProductId'] 		= 	$ProductId;
						$data['Netweight'] 		= 	$Net[$i]['value'];
						$data['Grossweight'] 	= 	$Gross[$i]['value'];
						
						$data['Quantity'] 		= 	$Quantity[$i]['value'];
						$data['Price'] 			= 	$Pricing[$i]['value'];
						$data['Lastupdated'] 	=	 time();
						
						$this->Commonmodel->insertdata($table,$data);
					}
					
				}
	
			//prepare the query for updating the product details except the image in the products table
			
			
			//checks whether the type already exists 
			$subtype = ucwords(str_replace("-"," ",strtolower(trim($subcategoryType))));

			$cond = array();
			$cond['Type'] = $subtype;
			$data = array();
			$data['Type']= $subtype;
			$data['CategoryId'] =  trim($this->input->post('category'));
			$table="subcattypes";
			
			if($this->Commonmodel->checkexists($table,$cond)){ }
			else { $this->db->insert($table,$data);	}
	
	//checks whether the type already exists  ends her
	
			$cond = array();
			$table='products';	

			$cond['ProductId'] = $ProductId; 
			$setdata = array();
			
			$setdata['BrandId'] = $brand;
			$setdata['Category_Id'] = $category;
			$setdata['Sub_CatId'] = $subcategory;
			$setdata['ProductName'] = ucwords(str_replace("-"," ",strtolower(trim($product_name))));
			
			$setdata['ProductDesc'] = $prdct_desc;
			$setdata['Type'] = ucwords(str_replace("-"," ",strtolower(trim($subcategoryType))));
			$setdata['ReadyTo'] = $readyto;
			$setdata['MeasurementUnit'] = $Measurementunit;
			$setdata['BaseUOM'] = $baseuom;
			$setdata['Status']= $prd_status;
			$setdata['AddedBy']= $this->session->userdata('username');
			$setdata['LastUpdated'] = time();
			
			//echo "<pre>"; print_r($setdata); exit; 				
			
			$this->db->where($cond);
			$this->db->update($table,$setdata);
			if($this->db->affected_rows()>0)
			echo "1";
		else
			echo "0";

		
}
//
//change password
public function changepassword()
{
	$_POST = $this->striptags($_POST);	
	extract($_POST);
	
	$Pwd = $this->saltedpassword->makeITcrypt($edit_password);
		$setData = array();
		
		$setData['Password']		= $Pwd['hashpassword'];
		$setData['Salt'] 			= $Pwd['salt'];
		$Cond=array();
		$Cond['SLNO']  = trim($this->session->userdata('userslno'));
		
		echo $this->Commonmodel->updatedata('users',$setData,$Cond);
}

//get the categories


public function getstores()
{
	$this->db->select('Owner_Name, ID ');
	$this->db->from('userdetails');
	$stores = $this->db->get();	
	
	$store_output = array();
	$cnt=0;
		
	foreach($stores->result() as $store)
	{
		if($cnt==0)
		{
			$store_output[] = array(
									"ID"=>"0",
									"Store"=>"Select Store"
								);
			$store_output[] = array(
									"ID"=>$store->ID,
									"Store"=>$store->Owner_Name
								);								
		}
		else
		{
			$store_output[] = array(
									"ID"=>$store->ID,
									"Store"=>$store->Owner_Name
								);
		}
		$cnt++;
	}
	
	echo json_encode($store_output);
	
	
	
}


//get categories


public function getcatego()
{
	$this->db->select('CategoryID, Category_Name');
	$this->db->from('categories');
	$stores = $this->db->get();	
	
	$category_output = array();
	$cnt=0;
		
	foreach($stores->result() as $store)
	{
		if($cnt==0)
		{
			$category_output[] = array(
									"CategoryID"=>"0",
									"Category_Name"=>"Select Category"
								);
			$category_output[] = array(
									"CategoryID"=>$store->CategoryID,
									"Category_Name"=>$store->Category_Name
								);								
		}
		else
		{
			$category_output[] = array(
									"CategoryID"=>$store->CategoryID,
									"Category_Name"=>$store->Category_Name
								);
		}
		$cnt++;
	}
	
	echo json_encode($category_output);
	
	
	
}


//get products

public function getprodcts()
{

//query the database table called products for the products
	
	$this->db->select('ProductId, ProductName');
	$this->db->from('products');
	$this->db->order_by('ProductName','ASC');
	$this->db->group_by('ProductName');
	
	$stores = $this->db->get();	
	
	$products_output = array();
	$cnt=0;
		
	foreach($stores->result() as $store)
	{
		if($cnt==0) // if the loop count is one we are taking the select product option and the first product
		{
			$products_output[] = array(
									"ProductId"=>"0",
									"Product_Name"=>"Select Product"
								);
			$products_output[] = array(
									"ProductId"=>$store->ProductId,
									"Product_Name"=>$store->ProductName
								);								
		}
		else // if the loop count is morethan one time  we are taking the remaining product
		{
			$products_output[] = array(
									"ProductId"=>$store->ProductId,
									"Product_Name"=>$store->ProductName
								);
		}
		$cnt++;
	}
	
	echo json_encode($products_output);
	
}


//coded by sudhaker on 20-03-2017
//to get the orders which has to be delivered today

public function getAllorderstobedelivered()
{

//get all the orders which has to be delivered today
	
	$out_resp	=	array();
	
	$this->db->select('ud.Owner_Name,od.OrderId,date_format(od.OrderedOn,"%d-%m-%Y") as OrderedOn, date_format(od.Expected_Delivery_date,"%Y-%m-%d") as Expected_Delivery_date, date_format(od.Expected_Delivery_date,"%d-%m-%Y %H:%i:%s") as scheduledAt, od.Total_Amount, od.OrderStatus,od.TotalProducts');
	$this->db->from('orders as od');
	$this->db->join('userdetails as ud','ud.SLNO=od.OrderBy');
	$this->db->order_by('OrderId','DESC');
	$this->db->where('od.OrderStatus!=','Delivered');
	$qry = $this->db->get('');
	
//	echo $this->db->last_query(); exit; 
	if($qry->num_rows()>0)
	{
		$slno=1;
          foreach($qry->result() as $data)
          {
              $table='orderproducts';
			  $cond=array();
			  $field='OrderedOn';
			  $order_by='DESC';
			  $order_by_field='OPID';
			  $limit='1';
			  
			 $OrderedOn =  $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');
			  
			  //get the date
			  $dtd = explode(" ",trim($data->Expected_Delivery_date));
			  
			  if($dtd[0] == date('Y-m-d'))
				{	
				  		$out_resp[]=array(
										"SLNO"=>$slno,
										"Owner_Name"=>$data->Owner_Name,
										"OrderId"=>$data->OrderId, 
										"OrderStatus"=>$data->OrderStatus,
										"TotalProducts"=>$data->TotalProducts,
										"Total_Amount"=>$data->Total_Amount,
										"OrderedOn"=>$data->OrderedOn,
										"Expected_Delivery_date"=>$data->Expected_Delivery_date,
										"scheduledAt"=>$data->scheduledAt,
										"todate"=>$data->OrderedOn                       
									);
	              $slno++;
				}
          }
		
	}
	else
	{
		$out_resp = array("nodata"=>"yes");	
	}
	
	echo json_encode($out_resp);
	
}




///delete excel once user download 
public function deleteexcelsheet()
{
		
	$postdata = json_decode(file_get_contents('php://input'),TRUE);
	$postdata = $this->striptags($postdata);
	$path = $_SERVER['DOCUMENT_ROOT']."/ecom-live/".$postdata['excelname'];

	
	
	$this->load->helper('file');
	unlink($path);
	//unlink($postdata['excelname']);

}
}//class ends here