
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	function __construct()
	{
		parent :: __construct();

        // ini_set("display_errors", 1);
        // error_reporting(1);
        $this->load->model('Mod_login');
	}

    public function index(){
        $this->Mod_login->is_user_login();
        $db  =  $this->mongo_db->customQuery();
        if( $this->input->post() ){

            $postData['buyerUsersFilter'] = $this->input->post(); 
            $this->session->set_userdata($postData);
        }
        $searchData = $this->session->userdata('buyerUsersFilter');

        if($searchData['location'] != ""){

            $findArray['country'] = $searchData['location'];
        }
        
        if($searchData['full_name'] != ""){

            $findArray['full_name']  = [ '$regex' => $searchData['full_name'], '$options' => 'si']; 
        }

        $findArray['profile_status'] = 'buyer';
        
        $buyer      =  $db->users->find($findArray);
        $buyerCount =  iterator_to_array($buyer);

        $config['base_url'] = SURL . 'index.php/admin/users/index';
        $config['total_rows'] = count($buyerCount);
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = 'Next Page<i class="fa fa-long-arrow-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>Previous Page';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
    
        if($page !=0) 
        {
          $page = ($page-1) * $config['per_page'];
        }
        $data["links"] = $this->pagination->create_links();

        $condition = array('sort'=>array('created_date'=> -1));
        $condition = array('limit' => $config['per_page'], 'skip' =>  $page); 
        
        $buyer     =  $db->users->find($findArray, $condition);
        $buyerRes  =  iterator_to_array($buyer);

        $data['buyers']    =  $buyerRes;
        $data['total']     =  count($buyerCount);

        $data['getAllCountries'] = getCountry();
        $this->load->view('users/buyer', $data);
    }
    public function traveler(){
        $this->Mod_login->is_user_login();
        $db  =  $this->mongo_db->customQuery();

        if( $this->input->post() ){

            $postData['travelerUsersFilter'] = $this->input->post(); 
            $this->session->set_userdata($postData);
        }
        $searchDataTraveler = $this->session->userdata('travelerUsersFilter');
        if(!empty($searchDataTraveler['location']) ){
            $findArray['country'] =    $searchDataTraveler['location'];
        }
        
        if($searchDataTraveler['full_name'] != ""){

            $findArray['full_name']  = [ '$regex' => $searchDataTraveler['full_name'], '$options' => 'si']; 
        }
        $findArray['profile_status'] = 'traveler';
        $traveler      =  $db->users->find($findArray);
        $travelerCount =  iterator_to_array($traveler);

        $config['base_url'] = SURL . 'index.php/admin/users/traveler';
        $config['total_rows'] = count($travelerCount);
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        if($page !=0) 
        {
          $page = ($page-1) * $config['per_page'];
        }
        $data["links"] = $this->pagination->create_links($config);

        $condition = array('sort'=>array('created_date'=> -1));
        $condition = array('limit' => $config['per_page'], 'skip' =>  $page); 
        
        $traveler     =  $db->users->find($findArray, $condition);
        $travelerRes  =  iterator_to_array($traveler);

        $data['traveler']    =  $travelerRes;
        $data['total']       =  count($travelerCount);
        $data['getAllCountries'] = getCountry();
        $this->load->view('users/traveler', $data);
    }

    public function resetFilterTravelers(){ 

        $this->session->unset_userdata('travelerUsersFilter');
        $this->traveler();
    }

    public function resetFilterBuyers(){
        
        $this->session->unset_userdata('buyerUsersFilter');
        $this->index();
    }//end

    public function getFullNames(){

        $db = $this->mongo_db->customQuery();
        $name = $db->users->find([]);
        $nameRes = iterator_to_array($name);
        $user_name_array = array_column($nameRes, 'full_name');
        unset($nameRes, $name );
        echo json_encode($user_name_array);
        exit;
    }//end
}
