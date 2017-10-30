<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Adminlogin extends CI_Controller {

	 public function __construct()
        {
                parent::__construct();
                // Your own constructor code
				date_default_timezone_set("Asia/Kolkata");
				$this->load->model('Commonmodel');
				
				
				
        }
	public function index()
	{

		if($this->input->post('login_btn'))
		{
				$this->form_validation->set_rules($this->config->item('login_rules'));
				if( $this->form_validation->run() === false )//checking whether any violation of valdation rules
				{
					$this->load->view('landing/login');	
				}
				else
					{
						$userid = trim($this->input->post('username'));
						$password = trim($this->input->post('password'));
						
						$res_data = $this->saltedpassword->makeITdecrypt($userid,$password);
						
						if( $res_data == "1" )
						{
							
								$table = 'users';
							$cond  = array();
							$pwd = $this->saltedpassword->getPassword($userid);
							$cond['Password'] = $pwd;
							
							$out_arr = $this->Commonmodel->get_single_row($table,$cond,$order_by='',$order_by_field='',$limit='');
							if($out_arr)
							{
								
								$table='';
								$cond='';
								$data='';
								
								$table='users';
								$cond=array("UserName"=>$userid,"Password"=>$pwd,'Status'=>'Active');
								$data=array( 'LastLogin'=>date('Y-m-d H:i:s A'),'LastUpdated'=>time() );
								
								$this->Commonmodel->updatedata($table,$data,$cond);//update the last login and time

								foreach($out_arr->result() as $arr)	
								{
									
									$this->session->set_userdata('username',$arr->UserName);
									$this->session->set_userdata('userslno',$arr->SLNO);
									$this->session->set_userdata('userrole',$arr->Role);
									
									if($arr->Role=='1')
										redirect(base_url('admin-dashboard'));
									elseif($arr->Role=='2')
										redirect(base_url());
								
								}
								
							}
							
						}
						elseif( $res_data == "-1" )
						{
							
							$msg = "<div class='alert alert-danger'> Invalid credentials</div>";
							$this->session->set_flashdata('invaliduser',$msg);
							redirect(base_url('Adminlogin'));
						}
						elseif( $res_data == "0" )
						{

							$msg = "<div class='alert alert-danger'> User not exists</div>";
							$this->session->set_flashdata('invaliduser',$msg);
							redirect(base_url('Adminlogin'));
						}


						
					}
				
		}
		else
				$this->load->view('landing/login');
	}
}
