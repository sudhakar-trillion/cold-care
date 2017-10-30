<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Saltedpassword
{
	public function makeITcrypt($pwd)
	{
		
		
		$ci= &get_instance();
		
		
		$password = $pwd;

/*
		$Blowfish_Pre = $ci->config->item('Blowfish_Pre');
		$Blowfish_End = $ci->config->item('Blowfish_End');
*/

		//get the  Blowfish_Pre and Blowfish_End from the table 
		
		$ci->db->select('EncKey as Blowfish_Pre');
		$ci->db->from('getkeys');
		$ci->db->where('KeyFor','Blowfish_Pre');
		
		$Blowfish_Pre = $ci->db->get()->row('Blowfish_Pre');
		
		$ci->db->select('EncKey as Blowfish_End');
		$ci->db->from('getkeys');
		$ci->db->where('KeyFor','Blowfish_End');
		
		$Blowfish_End = $ci->db->get()->row('Blowfish_End');

		
		$Allowed_Chars =
		'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
		$Chars_Len = 63;

		$Salt_Length = 21;
		$mysql_date = date( 'Y-m-d' );

		$salt = "";

		for($i=0; $i<$Salt_Length; $i++)
		{
			$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
		}
		$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
		$hashed_password = crypt($password, $bcrypt_salt);
		
		$ret_array= array("hashpassword"=>$hashed_password,'salt'=>$salt);
		
		return $ret_array;

	
	
	}
	
	
	public function makeITdecrypt($userid,$pwd)
	{
		
		
		$ci= &get_instance();
		
/*
		$Blowfish_Pre = $ci->config->item('Blowfish_Pre');
		$Blowfish_End = $ci->config->item('Blowfish_End');
*/

		//get the  Blowfish_Pre and Blowfish_End from the table 
		
		$ci->db->select('EncKey as Blowfish_Pre');
		$ci->db->from('getkeys');
		$ci->db->where('KeyFor','Blowfish_Pre');
	
		$Blowfish_Pre = $ci->db->get()->row('Blowfish_Pre');
		
		$ci->db->select('EncKey as Blowfish_End');
		$ci->db->from('getkeys');
		$ci->db->where('KeyFor','Blowfish_End');
	
		$Blowfish_End = $ci->db->get()->row('Blowfish_End');
		
		
		
		$cond = array();
		$cond['UserName'] = trim($userid);
			$ci->db->where($cond);
		$qry = $ci->db->get('users');
		
		if($qry->num_rows()==1)
		{
			foreach($qry->result() as $data)
			{
				$salt = $data->Salt;
				$password = $data->Password;
			}
			$hashed_pass = crypt($pwd, $Blowfish_Pre.$salt.$Blowfish_End);	

			
			if ($hashed_pass == $password)
			 {
				return '1';
			} 
			else 
			{
				return '-1';
			}
			
		}
		else
			return "0";
		
		
		
//		$hashed_pass = crypt($password, $Blowfish_Pre . $row['salt'] . $Blowfish_End);

	
	
	}
	
	public function getPassword($userid)
	{
		
		
		$ci= &get_instance();
		
	
/*
		$Blowfish_Pre = $ci->config->item('Blowfish_Pre');
		$Blowfish_End = $ci->config->item('Blowfish_End');
*/

		//get the  Blowfish_Pre and Blowfish_End from the table 
		
		$ci->db->select('EncKey as Blowfish_Pre');
		$ci->db->from('getkeys');
		$ci->db->where('KeyFor','Blowfish_Pre');
		
		$Blowfish_Pre = $ci->db->get()->row('Blowfish_Pre');
		
		$ci->db->select('EncKey as Blowfish_End');
		$ci->db->from('getkeys');
		$ci->db->where('KeyFor','Blowfish_End');
		
		$Blowfish_End = $ci->db->get()->row('Blowfish_End');
		
		$cond = array();
		$cond['UserName'] = trim($userid);
			$ci->db->where($cond);
		$qry = $ci->db->get('users');
		
		foreach($qry->result() as $data)
			{ 
				$password = $data->Password;
			}
			return $password;
		
	
	}
	
	public function random_password( $length = 8 ) 
	{
    	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*+?";
    	$password = substr( str_shuffle( $chars ), 0, $length );
    	return $password;
	}
	
}


?>
