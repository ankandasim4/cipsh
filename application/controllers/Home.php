<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Platformsh\ConfigReader\Config;
class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		// echo CI_VERSION; exit;
		$this->load->model('employees');
		$this->load->helper('url');
		$emp_list['emp_list'] = $this->employees->get_employees();
		$this->load->view('home.php', $emp_list);
	}
	public function test(){
		echo $credentials['host'];
		echo "</br>";
		echo $credentials['username'];
		echo "</br>";
		echo $credentials['password'];
		echo "</br>";
		echo $credentials['path'];
	}
}
