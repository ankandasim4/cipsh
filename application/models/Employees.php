<?php 

class Employees extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}

	/* 
		This function checks if the email and password matches with the database
	*/
	public function get_employees() {
		$sql = "SELECT * FROM employees";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function get_employee_data($id) {
		$sql = "SELECT * FROM employees where id=".$id;
		$query = $this->db->query($sql);
		return $query->result();
	}
}