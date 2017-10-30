<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller 
{
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

public function Pagenotfound()
{
	$this->load->view('site/header');
	$this->load->view('site/menu');	
	$this->load->view('site/errorpage');
	$this->load->view('site/footer');
}

// confirm registration

public function confirmregistration()
{
	/*
	$url_id=base64_decode($this->uri->segment(2));
	$regid = (double)$url_id/526825.24;
	*/
	
	$url_id=base64_decode($this->uri->segment(2));
	$regid = (double)$url_id/526825.24;

	$subject= 'Approval request';
	$this->load->view('site/header');
	$this->load->view('site/menu');	
	
	//get all the details of this registration and send an email to the admin for approval
	
	$this->db->select('ud.Owner_Name, ud.Email, ud.Location,us.UserName');
	$this->db->from('userdetails as ud');
	$this->db->join('users as us','us.SLNO=ud.SLNO');
	$this->db->where('us.SLNO',$regid);
	$usdetails = $this->db->get('');
	if($usdetails->num_rows()==0)
	{
		$regid = base64_decode($this->uri->segment(2));
		
		$this->db->select('ud.Owner_Name, ud.Email, ud.Location,us.UserName');
		$this->db->from('userdetails as ud');
		$this->db->join('users as us','us.SLNO=ud.SLNO');
		$this->db->where('us.SLNO',$regid);
		$usdetails = $this->db->get('');
	}
	else
	{
		
	}
	//echo $this->db->last_query(); exit;
	
	foreach($usdetails->result() as $udetails)
	{
		$UserName = $udetails->UserName;
		$StoreName = $udetails->Owner_Name;
		$EmailId = $udetails->Email;
		$Location = $udetails->Location;
		
	}
	
	
	$Admintemplate = ' <div style="margin:0px; padding:0px; font-family:calibri; font-size:14px;"> <div style="width:700px;  margin:auto; background:#79ad29; padding:27px 0px 27px 0px;"> <div style="width:590px; border-bottom:none;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6;"> <div style="width:239px; height:64px; float:left;"> <img src="'.base_url().'resources/site/img/demo-store-1401086283.jpg" /> </div> <div style="width:190px; float:right; height:64px;"> <p style="font-family:calibri; float:right; font-size:16px; font-style:italic; color:#122856;"><a href="javascript:void(0)" style="text-decoration:none; color:#6da218; line-height:64px; height:64px; float:left;" target="_blank">www.website.com</a></p> </div> <div style="clear:both"></div> </div><div style="width:590px;padding: 15px 26px 16px; margin:auto; background: #fff; border:1px solid #d6d5d6; border-top:0px;"><p style="margin-bottom:15px; font-size:14px;">New user has requested for store registration confirmation:</p><div class="order-colm row" style="width:540px;padding: 25px;border: 1px solid #eee;box-shadow: 0 0 5px #ccc;margin-bottom: 15px;"><h3 class="text-left" style="border-bottom: 1px solid #eee;padding: 0 0 15px;margin-bottom: 15px;color: #212121;    font-weight: 500;line-height: 1.1; margin-top:19px; font-size:30px;">Login Credential Details</h3>
<div style="display: block;border-bottom: 1px solid #eee;width:540px;padding:10px 5px; height:auto; overflow:hidden;"><div class="row">
<span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">User Id</span>
<span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">Store Name</span>
<span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">Email Id</span
><span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">Location</span>
</div>
</div>

<div style="display: block;border-bottom: 1px solid #eee;width:540px;padding:10px 5px; height:auto; overflow:hidden;"><div class="row">
<span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">'.$UserName.'</span>
<span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">'.$StoreName.'</span>
<span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">'.$EmailId.'</span
><span style="font-weight: 600;color: #000;width:130px;float:left; font-size:14px;">'.$Location.'</span>
</div>
</div>


<div style="width:530px;display:table;height:auto;"> 
</div> <div style="clear:both;"></div></div></div><div style="width:590px; background:#fff;color:#222; padding: 26px 26px 16px; margin:auto;  border:1px solid #d6d5d6; border-top:none;  background:#eee;"> <p style="color:rgb(51,51,51); font-size:13px; text-align:center;margin-bottom:5px;"> Ecom Food &ensp; &ensp; Email : <a href="javascript:void(0)" style="text-decoration:none; color:rgb(51,51,51);">emailid@website.com </a></p></div></div></div>';


$this->sendEmail('sudhaker.ssr@gmail.com',$subject,$Admintemplate);
	
	
	$this->load->view('site/confirmregistration');	
	
	
	$this->load->view('site/footer');
		
}


	public function index()
	{
		$this->load->view('site/header');
		$this->load->view('site/menu');	
		$this->load->view('site/index-header');
		$this->load->view('site/left-menu');
		
		$table='brands';
		$cond=array();
		$cond['Status'] = 'Active';
		$order_by='ASC';
		$order_by_field='BrandName';
		$limit='';
		
		//send the brand logos to the index view page
		$data['brands_logos']=$this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
		
		//set the category to the index view page
		
		$table='categories';
		$cond=array();
		$order_by='ASC';
		$order_by_field='Category_Name';
		$limit='';
		
		//send the brand logos to the index view page
		$data['Categories']=$this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
		
		
		$this->load->view('site/index',$data);	
		
		$this->load->view('site/footer');
	}
	
	public function categoryproduct(){
		$this->load->view('site/header');
		$this->load->view('site/menu');
		$this->load->view('site/left-menu');
		
		$table='brands';
		
		$cond=array();
		$cond['BrandName'] = $this->uri->segment(2);//str_replace("-"," ",$this->uri->segment(2));
		
		$order_by='';
		$order_by_field='';
		$limit='';
		
		$data['brnd'] = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');		
		
		$this->load->view('site/categoryproduct',$data);
		
		$this->load->view('site/footer');
	}
	
	
	public function filtered()
	{
		$cond = array();
	
		$this->load->view('site/header');
		$this->load->view('site/menu');
		$this->load->view('site/left-menu');
		
		$subCateg = $this->uri->segment(2);
		$Categ = ucwords(str_replace("-"," ",trim($this->uri->segment(3))));
		
		$cond = array();
		
		$table='categories';
		$field='CategoryID';
		$cond['Category_Name'] = $Categ;
		$order_by='';
		
		$order_by_field='';
		$limit='';
		
		
		$catId = $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');
		
		$cond = array();
		
		$table='subcategories';
		$field='Sub_CatId';
		
		$cond['CategId'] = $catId;
		$cond['SubCategory'] = $subCateg;
		$subcatId = $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');
		
		$data['catid'] = $catId;
		$data['subcatid'] = $subcatId;
		
		
		//check whether this category had any subcategories, types and also check whether it is a frozen food 
		
		//check whether it has subcategories
		
		$table='subcategories';
		
		$cond=array();
		$cond['CategId'] = $catId;
		
		$field='Sub_CatId';
		$order_by='';
		
		$order_by_field='';
		$limit='';
		
		$SUBCATID = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
		
	//	print_r($SUBCATID->result()); exit; 
	
	//find the subcategory id from the subcategory object
	$subcategory_ide= '';

//print_r($SUBCATID->result()	); 

foreach($SUBCATID->result()	as $sub_cat)
{
	if($sub_cat->SubCategory == $subCateg)
	{
		$subcategory_ide= $sub_cat->Sub_CatId;
	}
}

$this->session->set_userdata('subcategoryide',$subcategory_ide);
	
		if($SUBCATID!='0')
		{
			$data['subcatide'] = $SUBCATID; //assign subcategories
		}
		else
		{
			$data['subcatide'] = '0';	
		}
		
		//check whether it has types
		
		$table='subcattypes';
		
		$cond=array();
		$cond['CategoryId'] = $catId;
		
		$field='Type';
		$order_by='';
		
		$order_by_field='';
		$limit='';
		
		$SUBCATID = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
		if($SUBCATID!='0')
		{
			$data['type'] = $SUBCATID; //assign subcategories
		}
		else
		{
			$data['type'] = '0';	
		}			
		
		//check whether the category is a frozen food
		if($catId == "3")
		{
			$data['frozen'] = array(
										"Ready To"=>"Ready To",
										"Eat"=>"Eat",
										"Cook"=>"Cook",
									);	
		}
		else
		{
			$data['frozen'] = '0';	
		}
		

		//pulling the data from the database by product name wise
		

		$this->db->select('mes.MeasurementUnit, prd.ProductName,b.BrandName,b.BrandId,  prd.ProductPrice, prd.ProductId, prd.ProductImage, prd.NetWeight');
		$this->db->from('products as prd');
		$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
		$this->db->join('brands as b','b.BrandId=prd.BrandId');
		$this->db->where('prd.Category_Id',$data['catid']);
		$this->db->where('prd.Sub_CatId',$subcategory_ide);
		$this->db->where('b.Status','Active');
		$this->db->group_by('ProductName');
		$this->db->group_by('prd.BrandId');
		$this->db->order_by('ProductName','ASC');
		$totalRecords = $this->db->get('');
		
		
		$this->db->select('mes.MeasurementUnit, prd.ProductName,b.BrandName,b.BrandId,  prd.ProductPrice, prd.ProductId, prd.ProductImage, prd.NetWeight');
		$this->db->from('products as prd');
		$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
		
		$this->db->join('brands as b','b.BrandId=prd.BrandId');
		$this->db->where('prd.Category_Id',$data['catid']);
		$this->db->where('prd.Sub_CatId',$subcategory_ide);
		$this->db->where('b.Status','Active');
		$this->db->group_by('ProductName');
		$this->db->group_by('prd.BrandId');
		$this->db->order_by('ProductName','ASC');
		
		$this->db->limit('15');
		$data['prddetails'] = $this->db->get('');
		$data['totalProducts'] = $totalRecords->num_rows();
		

//echo $this->db->last_query(); exit; 
// get the product names from the product table		
	
	$this->db->select('prd.ProductName');
	$this->db->from('products as prd');
	$this->db->where('prd.Category_Id',$catId);
			$this->db->where('prd.Sub_CatId',$subcategory_ide);
	$this->db->group_by('prd.ProductName');
	$data['prdnames'] = $this->db->get('');
		
		
		$this->load->view('site/filteredproducts',$data);
		$this->load->view('site/footer');
		
	}
	
	public function categoryAllproduct()
	{
		//unset the session of brandid, because we are accessing products of the category regardless of brands
		$this->session->set_userdata('BrandId','');
		
		//unset the session of subcategoryide, because we are accessing products of the category regardless of subcategories
		$this->session->set_userdata('subcategoryide','');
		
		$this->load->view('site/header');
		$this->load->view('site/menu');
		$this->load->view('site/left-menu');
		
		//get the categories so that we can show the cate
		$cond=array();
		$table="categories";
		
		$cond['Category_Name'] = str_replace("-"," ",trim($this->uri->segment(2)));
		$field='CategoryID';
		$order_by='';
		$order_by_field='';
		$limit='';
		
		
		$data['catid'] = $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');
		
		//check whether this category had any subcategories, types and also check whether it is a frozen food 
		
		//check whether it has subcategories we had used this for the subcategories filter in the view
		
		$table='subcategories';
		
		$cond=array();
		$cond['CategId'] = $data['catid'];
		
		$field='Sub_CatId';
		$order_by='';
		
		$order_by_field='';
		$limit='';
		
		$SUBCATID = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
		if($SUBCATID!='0')
		{
			$data['subcatide'] = $SUBCATID; //assign subcategories
		}
		else
		{
			$data['subcatide'] = '0';	
		}
		
		//check whether it has types we had used this for the types filter in the view
		
		$table='subcattypes';
		
		$cond=array();
		$cond['CategoryId'] = $data['catid'];
		
		$field='Type';
		$order_by='';
		
		$order_by_field='';
		$limit='';
		
		$SUBCATID = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
		if($SUBCATID!='0')
		{
			$data['type'] = $SUBCATID; //assign subcategories
		}
		else
		{
			$data['type'] = '0';	
		}			
		
		//check whether the category is a frozen food we had used this for the readu\y to eat or cook filter in the view
		if($data['catid'] == "3")
		{
			$data['frozen'] = array(
										"Ready To"=>"Ready To",
										"Eat"=>"Eat",
										"Cook"=>"Cook",
									);	
		}
		else
		{
			$data['frozen'] = '0';	
		}
		
		
		//pulling the data from the database by product name wise
		
		//this section is for pagination 
		$this->db->select('mes.MeasurementUnit, prd.ProductName,b.BrandName,b.BrandId, prd.ProductPrice, prd.ProductId, prd.ProductImage, prd.NetWeight');
		$this->db->from('products as prd');
		$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
		
		$this->db->join('brands as b','b.BrandId=prd.BrandId');
		$this->db->group_by('ProductName');
		$this->db->group_by('prd.BrandId');
		$this->db->order_by('ProductName','ASC');
		
		$this->db->where('prd.Category_Id',$data['catid']);
		$this->db->where('b.Status','Active');
		
		//the below line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status
		
		$this->db->where('prd.Status','Active');
		
		//the above line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status ends here
		
		$totalRecords = $this->db->get('');

		//this section is for pagination ends here
		
		#echo $totalRecords->num_rows(); exit; 
		
		
		//this section of query is for the products
		
		$this->db->select('mes.MeasurementUnit, prd.ProductName,b.BrandName,b.BrandId, prd.ProductPrice, prd.ProductId, prd.ProductImage, prd.NetWeight');
		$this->db->from('products as prd');
		$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');

		$this->db->join('brands as b','b.BrandId=prd.BrandId');
		$this->db->group_by('ProductName');
		$this->db->group_by('prd.BrandId');
		$this->db->order_by('ProductName','ASC');
		
		$this->db->where('prd.Category_Id',$data['catid']);
		$this->db->where('b.Status','Active');
		
		//the below line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status
		
		$this->db->where('prd.Status','Active');
		
		//the above line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status ends here
				
		$this->db->limit('15');
		$data['prddetails'] = $this->db->get('');
		$data['totalProducts'] = $totalRecords->num_rows();
	
// get the product names from the product table	we had used this for the product name filter in the view	
	
	$this->db->select('prd.ProductName');
	$this->db->from('products as prd');
	$this->db->where('prd.Category_Id',$data['catid']);
	$this->db->group_by('prd.ProductName');
	$data['prdnames'] = $this->db->get('');
		
//	print_r($data['prdnames']->result())	; exit;
		if($data['catid']!='0')
		$this->load->view('site/categoryAllproduct',$data);
		else
			redirect(base_url('page-not-found'));
		
		$this->load->view('site/footer');
	}
	
	public function brandsproducts()
	{
		$this->session->set_userdata('BrandId','');
		$this->session->set_userdata('subcategoryide','');
			
		$this->load->view('site/header');
		$this->load->view('site/menu');
		$this->load->view('site/left-menu');
		
		$cond = array();
		
		$cond['BrandName']= $this->uri->segment(1);//str_replace("-"," ",$this->uri->segment(1));
		$table = "brands";
		
		$this->db->select('BrandId');
		$this->db->from($table);
		$this->db->where($cond);
		$BrandId = $this->db->get('')->row('BrandId');

		$cond = array();
		
		$cond['Category_Name']= str_replace("-"," ",$this->uri->segment(2));
		$table = "categories";
		
		$this->db->select('CategoryID');
		$this->db->from($table);
		$this->db->where($cond);
		$CategoryID = $this->db->get('')->row('CategoryID');

		$cond = array();
		
		$cond['BrandId'] 		= 	$BrandId;
		$cond['Category_Id'] 	= 	$CategoryID;
		
		$this->session->set_userdata('BrandId',$BrandId);
		
		$order_by='';
		$order_by_field='';
		$limit='';
		$data = array();
		$table='products';
		$data['Category_Id'] = $CategoryID;
		//$data['products'] = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='')	;
		
		
		
			//check whether this category had any subcategories, types and also check whether it is a frozen food 
		
		//check whether it has subcategories
		
		$table='subcategories';
		
		$cond=array();
		$cond['CategId'] = $CategoryID;
		
		$field='Sub_CatId';
		$order_by='';
		
		$order_by_field='';
		$limit='';
		
		$SUBCATID = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
		if($SUBCATID!='0')
		{
			$data['subcatide'] = $SUBCATID; //assign subcategories
		}
		else
		{
			$data['subcatide'] = '0';	
		}
		
		//check whether it has types
		
		$table='subcattypes';
		
		$cond=array();
		$cond['CategoryId'] = $CategoryID;
		
		$field='Type';
		$order_by='';
		
		$order_by_field='';
		$limit='';
		
		$SUBCATID = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
		if($SUBCATID!='0')
		{
			$data['type'] = $SUBCATID; //assign subcategories
		}
		else
		{
			$data['type'] = '0';	
		}			
		
		//check whether the category is a frozen food
		if($CategoryID == "3")
		{
			$data['frozen'] = array(
										"Ready To"=>"Ready To",
										"Eat"=>"Eat",
										"Cook"=>"Cook",
									);	
		}
		else
		{
			$data['frozen'] = '0';	
		}



//pulling the data from the database by product name wise
//for pagination

		$this->session->set_userdata('BrandId',$BrandId);
		
		$this->db->select('br.BrandName, mes.MeasurementUnit,b.BrandName,b.BrandId, prd.ProductName, prd.ProductPrice, prd.ProductId, prd.ProductImage, prd.NetWeight');
		$this->db->from('products as prd');
		$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
		$this->db->join('brands as br','br.BrandId=prd.BrandId');
		$this->db->join('brands as b','b.BrandId=prd.BrandId');
		$this->db->where('prd.Category_Id',$CategoryID);
		$this->db->where('prd.BrandId',$BrandId);
		
		//the below line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status
		
		$this->db->where('prd.Status','Active');
		
		//the above line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status ends 


		
		$this->db->group_by('ProductName');
		$this->db->order_by('ProductName','ASC');
		$totalRecords = $this->db->get('');
		
		
		$this->db->select('br.BrandName, mes.MeasurementUnit,b.BrandName,b.BrandId, prd.ProductName, prd.ProductPrice, prd.ProductId, prd.ProductImage, prd.NetWeight');
		$this->db->from('products as prd');
		$this->db->join('measurements as mes', 'mes.MeasurementId=prd.MeasurementUnit');
		$this->db->join('brands as br','br.BrandId=prd.BrandId');
		$this->db->join('brands as b','b.BrandId=prd.BrandId');
		$this->db->where('prd.Category_Id',$CategoryID);
		$this->db->where('prd.BrandId',$BrandId);
	
	//the below line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status
		
		$this->db->where('prd.Status','Active');
		
	//the above line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status ends 

		$this->db->group_by('ProductName');
		$this->db->order_by('ProductName','ASC');
		$this->db->limit('15');
		$data['products'] = $this->db->get('');
	$data['totalProducts'] = $totalRecords->num_rows();



#echo $this->db->last_query(); exit; 


// get the product names from the product table		
	
	$this->db->select('prd.ProductName');
	$this->db->from('products as prd');
	$this->db->where('prd.Category_Id',$CategoryID);
	$this->db->where('prd.BrandId',$BrandId);
	
//the below line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status
		
		$this->db->where('prd.Status','Active');
		
//the above line added by sudhaker on 18-03-2017 because client had asked to show the product which are in active status ends 

	
	$this->db->group_by('prd.ProductName');
	$data['prdnames'] = $this->db->get('');		
		
		
		if($data['products']!='0')
		{
			$this->load->view('site/brandsproducts',$data);
		}
		else
		{
			$data['products'] = array();
			$this->load->view('site/brandsproducts',$data);
		}
		
		
		$this->load->view('site/footer');
	}
	
	public function productview(){
		
	$productid=base64_decode($this->uri->segment(2)); //geting the id from the url
	
	//get the package id from the product id
	
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

		//if not we are quering the database for the package id
		
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
	
#echo $packageId; exit; 
		
		$this->load->view('site/header');
		$this->load->view('site/menu');
		$this->load->view('site/left-menu');
		
		$cond = array();
		$cond['ProductId'] = $productId;
		$table='products';
		
		$data = array();
		$data['ProductId'] = $productId;
		$data['packageid'] = $packageId;
		
		if($this->Commonmodel->checkexists($table,$cond))
		{
			$this->load->view('site/productview',$data);	
		}
		else
		{
			redirect(base_url('page-not-found'));
		}
		
		
		
		$this->load->view('site/footer');
	}
	
	public function cartview(){
		$this->load->view('site/header');
		$this->load->view('site/menu');
		$this->load->view('site/left-menu');
		$this->load->view('site/cartview');
		$this->load->view('site/footer');
	}
	
	public function checkout(){
		$this->load->view('site/header');
		$this->load->view('site/menu');
		
		if($this->session->userdata('UserName')!='')
		$this->load->view('site/checkout');
		else
		$this->load->view('site/checkout-login');
		
		
		$this->load->view('site/footer');
	}

	public function confirmorder()
	{

	$this->load->view('site/header');
	$this->load->view('site/menu');
		
	$url_id=base64_decode($this->uri->segment(2));
	$orderId = (double)$url_id/526825.24;		

	$cartitems = array();
	$table='orders';
	
	$cond=array();
	$field='OrderBy';
	
	$order_by='';
	$order_by_field='';
	$limit='';
	
	$cond['OrderStatus'] ='Awaiting';
	$cond['OrderId'] = $orderId;
	
if($this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit=''))
{
	$table='orderproducts';
	$cond=array();
	
	$order_by='';
	$order_by_field='';
	$limit='';
	
	$cond['OrderId'] = $orderId;
	$data['OrderId'] = $orderId;
	
	$data['cartitems']  = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
}
else
	$data['cartitems'] = '0';

	$this->load->view('site/confirmorder',$data);
	$this->load->view('site/footer');
			
	}
	

	
	public function profileinfo(){
	
		if($this->session->userdata('userslno')=='')
		redirect(base_url());
	
	
		$this->load->view('site/header');
		$this->load->view('site/menu');
		
		//get the communication and personal details of the user/store and brand info
		
		//$this->db->select('b.BrandName, b.BrandId, us.UserName, ud.*');
		$this->db->select(' us.UserName, ud.*');
		$this->db->from('userdetails as ud');
		$this->db->join('users as us','us.SLNO=ud.SLNO');
		//$this->db->join('brands as b','b.BrandId=ud.BrandId');
		$this->db->where('ud.SLNO',trim($this->session->userdata('userslno')) );
		$data['communication'] = $this->db->get('');
		
		$this->load->view('site/profileinfo',$data);
		
		$this->load->view('site/footer');
	}
	
	//order list 
	
	public function orderlist()
	{
		$data = array();
		
		$this->load->view('site/header');
		$this->load->view('site/menu');
		
		$this->db->select('ord.OrderStatus, ord.TotalProducts, ord.OrderedOn, ord.OrderId, ud.Owner_Name');
		$this->db->from('orders as ord');
		$this->db->join('userdetails as ud','ord.OrderBy=ud.SLNO');
		$this->db->where('ord.OrderBy',trim($this->session->userdata('userslno')));
		$data['orderlist'] = $this->db->get('');	
		if($this->session->userdata('userslno')!='' && $this->session->userdata('userrole')==2)
			{
				$this->load->view('site/orderlist',$data);	
			}
			else
			$this->load->view('site/checkout-login');	
		
		
		$this->load->view('site/footer');
	}
	
		public function orderhistory()
		{
			$this->load->view('site/header');
			$this->load->view('site/menu');
			
			
			$url_id=base64_decode($this->uri->segment(2));
			$orderid = (double)$url_id/526825.24;
			
				$table='orders';
				
				$cond = array();
				$cond['OrderId'] = $orderid;
				
				$output = array(); // used to store the final output data
				
				$prds = array(); //used to store product ids and the quantity
			
			if( $this->Commonmodel->checkexists($table,$cond))
			{
					// $prd_quant = $this->Commonmodel->getrows($table,$cond,$order_by='',$order_by_field='',$limit='');
					$this->db->select('op.*, ord.OrderStatus as Status');
					$this->db->from('orderproducts as op');
					$this->db->join('orders as ord','ord.OrderId=op.OrderId');
					$this->db->where('op.OrderId',$orderid);
					$prd_quant = $this->db->get('');
					
					foreach($prd_quant->result() as $data)
					{
						$prds[] = array(
											"ProductId"=>$data->Product,
											"Quantity"=>$data->Quantity,
											"PackageId"=>$data->PackageId,
										);
						$orderedOn = $data->OrderedOn;
						$Status = $data->Status;		
					}
					$data = array();					
					$data['cartitems'] = $prds;	
					
					
					///get the order status
					
					$table='orders';
					$cond=array();
					$cond['OrderId'] = $orderid;
					$field='OrderStatus';
					$order_by='';
					$order_by_field='';
					$limit='';
					
					$data['OrderStatus'] = $this->Commonmodel->getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='');
			}
			
			if($this->session->userdata('userslno')!='' && $this->session->userdata('userrole')==2)
			{
				$this->load->view('site/orderhistory',$data);		
			}
			else
			$this->load->view('site/checkout-login');
			
			$this->load->view('site/footer');
		}
	//logout
	
	public function logout()
	{
		$this->session->set_userdata('UserName','');
		$this->session->set_userdata('userslno','');
		$this->session->set_userdata('userrole','');	
		
		$cartitems = array();
		$this->session->set_userdata('lastcartItem','');	
		
		redirect(base_url());
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

	
}
?>