<?PHP
class Commonmodel extends CI_Model
{
	public function checkexists($table,$cond)
	{
		$this->db->where($cond);
		$qry = $this->db->get($table);
		if($qry->num_rows()>0)
			return $qry->num_rows();
		else
			return "0";
		
	}
	public function getAfield($table,$cond,$field,$order_by='',$order_by_field='',$limit='')
	{
		$this->db->select($field);
		$this->db->from($table);
		if( sizeof( count($cond) ) )
		{
			$this->db->where($cond);
		}
		if($order_by!='')
		{
			$this->db->order_by($order_by_field,$order_by);
		}	
		if($limit!='')
		{
				$this->db->limit($limit);
		}
		$qry = $this->db->get('');
		if($qry->num_rows()>0)
		{
			return $qry->row($field);			
		}else
			return "0";
		
	}
	public function getrows($table,$cond,$order_by='',$order_by_field='',$limit='')
	{
		
		
		if( sizeof( count($cond) ) )
		{
			$this->db->where($cond);
		}
		if($order_by!='')
		{
			$this->db->order_by($order_by_field,$order_by);
		}	
		if($limit!='')
		{
				$this->db->limit($limit);
		}
		
		$qry = $this->db->get($table);
		if($qry->num_rows()>0)
		return $qry;
		else	
		return "0";
		
	}
	
	
	public function get_single_row($table,$cond,$order_by='',$order_by_field='',$limit='')
	{
		
		if( sizeof( count($cond) ) )
		{
			$this->db->where($cond);
		}
		if($order_by!='')
		{
			$this->db->order_by($order_by_field,$order_by);
		}	
		if($limit!='')
		{
				$this->db->limit($limit);
		}
		
		$qry = $this->db->get($table);
//		echo $this->db->last_query(); exit; 
		
		if($qry->num_rows()>0)
		return $qry;
		else	
		return "0";
	
	}
	
	public function insertdata($table,$data)
	{
		$this->db->insert($table,$data)	;
		return $this->db->insert_id();
		
	}
	
	
	public function updatedata($table,$data,$cond)	
	{
		$this->db->where($cond);
		$this->db->update($table,$data);
		return $this->db->affected_rows(); exit; 
//		echo $this->db->last_query(); exit; 
		if($this->db->affected_rows()>0)
			return "1";
		else
			return "0";
	}
	
	public function getuserFranchise($cond)
	{
		
		if(empty($cond))
		{
			
		}
		else
		{
			$this->db->where('us.Status',$cond['Status']);
			$this->db->where('us.Role','2');
		}
		
		$this->db->select('us.SLNO,us.Status,us.USERNAME,usd.Owner_Name,usd.BrandId,usd.Email,usd.Phone,usd.Address,usd.Location');
		$this->db->from('users as us');
		$this->db->join('userdetails as usd','usd.SLNO=us.SLNO');
		$this->db->where('us.Role','2');
		$this->db->order_by('SLNO','DESC');
		
		$qrey = $this->db->get();
		
		if($qrey->num_rows()>0)
		{
			return $qrey;
		}
		else
			return "0";
	}
	
	public function getAUserFranchiseDetails($UserId)
	{
		
		$this->db->select('us.*,usd.*');
		$this->db->from('users as us');
		$this->db->join('userdetails as usd','usd.SLNO=us.SLNO');
		$this->db->where('usd.SLNO',$UserId);
		
		$qrey = $this->db->get();

		
		if($qrey->num_rows()>0)
		{
			return $qrey;
		}
		else
			return "0";
		
	}
	
public function getcategories($cond)
{
	$this->db->where($cond);
	$qry = $this->db->get('categories');
	
	if($qry->num_rows()>0)
		return $qry;
	else
		return "0";
	
		
}
	
	public function getsmtpdetails()
	{
			$this->db->select('user,password');
			$this->db->from('smtp_details');
			$this->db->limit(1);
			$qry = $this->db->get();

			if($qry->num_rows()>0)
				return $qry;
			else
				return "0";
		
					
	}
	
	
	public function getpathdetails($cond)
	{
		
			$this->db->select('Path');
			$this->db->from('uploadpaths');
			$this->db->where($cond);
			$this->db->limit(1);
			$qry = $this->db->get();

			if($qry->num_rows()>0)
				return $qry;
			else
				return "0";
	}
	
	
	public function getkeydetails($cond)
	{
		
			$this->db->select('EncKey');
			$this->db->from('getkeys');
			$this->db->where($cond);
			$this->db->limit(1);
			$qry = $this->db->get();

			if($qry->num_rows()>0)
				return $qry;
			else
				return "0";
	}

}

?>