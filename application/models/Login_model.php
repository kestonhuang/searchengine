<?php
class Login_model extends CI_Model
{
	function can_login($email, $password)
	{
		$this->db->where('email', $email);
		$query = $this->db->get('account');
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				if($row->is_email_verified == 'yes')
				{
					if(password_verify($password, $row->password))
					{
						$this->session->set_userdata('id', $row->id);
						return "SUCCESS";
					}
					else
					{
						return 'Incorrect Password';
					}
				}
				else
				{
					return 'Please verify your email address before you are able to login';
				}
			}
		}
		else
		{
			return 'Incorrect Email Address';
		}
	}

	public function get_user_by_email($email)
	{
		$this->db->where('email', $email);
		$query = $this->db->get('account');
		if($query->num_rows()) return $query->row();
		return false;
	}

	public function get_user($user_id)
	{
		$this->db->where('id', $user_id);
		$query = $this->db->get('account');
		if($query->num_rows()) return $query->row();
		return false;
	}

	public function update_user($user_id, $data)
	{
//		echo $user_id;
		$this->db->where('id', $user_id);
		$this->db->update('account', $data);
//		print_r($this->db->error());
//		echo $user_id.'<pre>';print_r($data);die;
	}

	public function getRows($params = array()){
		$this->db->select('*');
		$this->db->from('account');

		if(array_key_exists("conditions", $params)){
			foreach($params['conditions'] as $key => $val){
				$this->db->where($key, $val);
			}
		}

		if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
			$result = $this->db->count_all_results();
		}else{
			if(array_key_exists("id", $params) || $params['returnType'] == 'single'){
				if(!empty($params['id'])){
					$this->db->where('id', $params['id']);
				}
				$query = $this->db->get();
				$result = $query->row_array();
			}else{
				$this->db->order_by('id', 'desc');
				if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
					$this->db->limit($params['limit'],$params['start']);
				}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
					$this->db->limit($params['limit']);
				}

				$query = $this->db->get();
				$result = ($query->num_rows() > 0)?$query->result_array():FALSE;
			}
		}

		// Return fetched data
		return $result;
	}

	function Is_already_register($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('account');
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function Update_user_data($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('account', $data);
	}

	function Insert_user_data($data)
	{
		$this->db->insert('account', $data);
//		return $this->db->insert_id();
	}

	function fetch_data($query)
	{
		$this->db->select("*");
		$this->db->from("item");
		if($query != '')
		{
			$this->db->like('name', $query);
			$this->db->or_like('category', $query);
			$this->db->or_like('listedByUserID', $query);
		}
		$this->db->order_by('itemID', 'DESC');
		return $this->db->get();
	}

}

?>
