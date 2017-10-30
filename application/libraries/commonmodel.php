<?PHP
class commonmodel extends CI_Model
{
	
	public function get_single_row($table,$cond,$order_by='',$order_by_field='',$limit='')
	{
		if( sizeof( $count($cond) ) )
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
		
		if($qry->num_rows()==1)
		{
			return $qry->result();	
		}
		else
			return "0";
	}
		
}

?>