<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Managemissilenous extends CI_Controller {

	public function __construct()
		{
			parent::__construct();
			date_default_timezone_set("Asia/Kolkata");
			define('HEADER','Admin/header');
			define('FOOTER','Admin/footer');
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



public function viewuser()
	{
		$this->load->view(HEADER);
		$this->load->view('Admin/viewuser');
		$this->load->view(FOOTER);
	}
	

/*  View new user registrations starts here */

public function viewnewusers()
{
	$this->load->view(HEADER);
	$this->load->view('Admin/viewnewusers');
	$this->load->view(FOOTER);
}


###########################################################################################################
###########################################################################################################




###########################################################################################################
###########################################################################################################

/*  View new uactive ser  starts here */

public function viewactiveusers()
{
	$this->load->view(HEADER);
	$this->load->view('Admin/viewactiveusers');
	$this->load->view(FOOTER);
}


###########################################################################################################
###########################################################################################################


###########################################################################################################
###########################################################################################################

/*  View new uactive ser  starts here */

public function viewinactiveusers()
{
	$this->load->view(HEADER);
	$this->load->view('Admin/viewinactiveusers');
	$this->load->view(FOOTER);
}


###########################################################################################################
###########################################################################################################	



public function viewbrands()
{
	$this->load->view(HEADER);
	$this->load->view('Admin/viewbrands');
	$this->load->view(FOOTER);
}

public function viewcategories()
{
	$this->load->view(HEADER);
	$this->load->view('Admin/admin-view-categories');
	$this->load->view(FOOTER);
	
}




######################################################################################################################
######################################################################################################################

/* View subcategories starts here */

######################################################################################################################
######################################################################################################################

public function viewsubcategories()
{
	$this->load->view(HEADER);
	$this->load->view('Admin/viewsubcategories');
	$this->load->view(FOOTER);
	
}

######################################################################################################################
######################################################################################################################

/* View subcategories Ends here */

######################################################################################################################
######################################################################################################################


########################################################################################################################################
########################################################################################################################################
########################################################################################################################################

/*  View base uom starts here */

########################################################################################################################################
########################################################################################################################################
########################################################################################################################################


public function viewbaseuom()
{
	$this->load->view(HEADER);
	$this->load->view('Admin/viewbaseuom');
	$this->load->view(FOOTER);
	
}



########################################################################################################################################
########################################################################################################################################
########################################################################################################################################

/*  View base uom ends here */

########################################################################################################################################
########################################################################################################################################
########################################################################################################################################

   
####################################################################################################
####################################################################################################

/*  View Measuement starts here */

####################################################################################################
####################################################################################################  
    public function viewmeasurements()
    {
        $this->load->view(HEADER);
        
        $this->load->view('Admin/viewmeasurements');
        $this->load->view(FOOTER);
    }
        
    
    
####################################################################################################
####################################################################################################

/*  View Measuement ends here */

####################################################################################################
####################################################################################################     


    
public function viewproducts()
{
    $this->load->view(HEADER);
    $this->load->view('Admin/viewproducts');
    $this->load->view(FOOTER);
}
    
    
//view all orders
public function viewAllorders()
{
	$this->load->view(HEADER);
    $this->load->view('Admin/viewAllorders');
    $this->load->view(FOOTER);
	
	
}//viewAllorders ends here

//view individual order details

public function vieworder()
{
	
	$this->load->view(HEADER);
    $this->load->view('Admin/vieworder');
    $this->load->view(FOOTER);
}

//view orders by category

public function vieworderbycategory()
{
	
	$this->load->view(HEADER);
    $this->load->view('Admin/viewordersbycategory');
    $this->load->view(FOOTER);
	
}

//view orders by product

public function vieworderbyproduct()
{
	// we called all the data related to the products are from the angularJs
	// we had called a function products from the angularJs controller ( angularController.js ) this is to build the select list with the default products which are in the database
	//kindly go there and you can find the documentation there too
	
	
	// calling a method getAllorders() form the  angularJs controller ( angularController.js ) this is to get all the orders which with the products
	
	//to get the filtered data we had used a function called getordersbyfilter form the  angularJs controller ( angularController.js ) 
	
	
	$this->load->view(HEADER);
    $this->load->view('Admin/viewordersbyproduct');
    $this->load->view(FOOTER);
	
}



//change the order status


public function ChangeOrderStatus()
{
	
	$this->load->view(HEADER);
    $this->load->view('Admin/change-order-status');
    $this->load->view(FOOTER);
}


//coded on 20-03-2017

public function todaysdeliveries()
{
	
	$this->load->view(HEADER);
		$this->load->view('Admin/todaysdeliveries');
	$this->load->view(FOOTER);
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

