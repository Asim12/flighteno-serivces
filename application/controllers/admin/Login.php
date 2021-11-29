<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct() {

		parent::__construct();


		// ini_set("display_errors", 1);
        // error_reporting(1);

		$this->load->model('Mod_isValidUser');

	}

	public function index(){

		if($this->session->userdata('admin_id') == ''){

			$this->load->view('admin/login');
		}
		else{
			redirect(base_url() . 'index.php/admin/Dashboard/index');
		}
	}
	public function VerifyLogin(){
		$email    = trim( $this->input->post('email') );
		$password = trim($this->input->post('password') );

		$response = $this->Mod_isValidUser->getUserData($email, $password);

		if($response == true  || $response == 1 || $response == 'true'){

			redirect(base_url() . 'index.php/admin/Dashboard/index');
		}else{
					
			$this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
												Invalid Credentials.
											</div>');
			// redirect('admin/Login', 'refresh');

			$this->load->view('admin/login');
		}
	}
	function logoutUser(){

		$db       = $this->mongo_db->customQuery();
		$admin_id = $this->session->userdata('admin_id');
		$this->session->unset_userdata('user_data');
		$db->users->updateOne([ '_id' => $this->mongo_db->mongoId($admin_id) ],  ['$set' => ['login_status' => false] ] );

		$this->session->unset_userdata('admin_id');

		$this->session->unset_userdata('logged_in_flighteno');
		$this->load->view('admin/login');
	}
}