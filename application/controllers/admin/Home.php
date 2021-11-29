<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct()
	{
		parent :: __construct();
		if($this->session->userdata('admin_id') == ''){
		    redirect('admin/Login', 'refresh');
		}
	}
	public function index()
	{
		$this->load->view('admin/dashboard');
	}
}


