<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FlagUsers extends CI_Controller {
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

            $postData['flagBuyerUsers'] = $this->input->post();
            $this->session->set_userdata($postData);
        }
        $flagBuyerUsers = $this->session->userdata('flagBuyerUsers');


        if($flagBuyerUsers['start_date'] !="" && $flagBuyerUsers['end_date'] != ""){

            $startDate = $this->mongo_db->converToMongodttime($flagBuyerUsers['start_date']);
            $endDate   = $this->mongo_db->converToMongodttime($flagBuyerUsers['end_date']);
            $findArray['created_date'] = ['$gte' => $startDate,  '$lte' => $endDate];
        }  
        if($flagBuyerUsers['full_name'] != ""){

            $findArray['full_name']  = [ '$regex' => $flagBuyerUsers['full_name'], '$options' => 'si']; 
        }
        $findArray['profile_status'] = 'buyer';
        
        $flag      =  $db->users->find($findArray);
        $flagCount =  iterator_to_array($flag);

        $config['base_url'] = SURL . 'index.php/admin/FlagUsers/index';
        $config['total_rows'] = count($flagCount);
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = 'Next<i class="fa fa-long-arrow-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>Previous';
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

        // $condition = array();
        $condition = ['skip' =>  $page, 'limit' => $config['per_page'], ['sort'=> ['created_date'=> -1]] ]; 
        
        $flag     =  $db->users->find($findArray, $condition);
        $flagRes  =  iterator_to_array($flag);

        $data['flagUsers'] =  $flagRes;
        $data['total']     =  count($flagCount);

        $this->load->view('flagusers/buyer', $data);
    }

    public function flagTraveler(){ 

        $this->Mod_login->is_user_login();
        $db  =  $this->mongo_db->customQuery();
        if( $this->input->post() ){

            $postData['flagTravelerUser'] = $this->input->post();
            $this->session->set_userdata($postData);
        }
        $searchDataTraveler = $this->session->userdata('flagTravelerUser');
       
        if($searchDataTraveler['start_date'] !="" && $searchDataTraveler['end_date'] != ""){

            $startDate = $this->mongo_db->converToMongodttime($searchDataTraveler['start_date']);
            $endDate   = $this->mongo_db->converToMongodttime($searchDataTraveler['end_date']);
            $findArray['created_date'] = ['$gte' => $startDate,  '$lte' => $endDate];
        }  

        if($searchDataTraveler['full_name'] != ""){
            $findArray['full_name']  = [ '$regex' => $searchDataTraveler['full_name'], '$options' => 'si']; 
        }
        $findArray['profile_status'] = 'traveler';
        
        $flag      =  $db->users->find($findArray);
        $flagCount =  iterator_to_array($flag);

        $config['base_url'] = SURL . 'index.php/admin/FlagUsers/flagTraveler';
        $config['total_rows'] = count($flagCount);
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 4;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = 'Next<i class="fa fa-long-arrow-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>Previous';
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

        $condition = ['skip' =>  $page, 'limit' => $config['per_page'], ['sort' => ['created_date'=> -1 ]] ]; 
        
        $flagData =  $db->users->find($findArray, $condition);
        $flagRes  =  iterator_to_array($flagData);

        $data['flagTravelerUsers'] =  $flagRes;
        $data['total']     =  count($flagCount);

        $this->load->view('flagusers/traveler', $data);
    }

    public function resetFilterBuyers(){
        
        $this->session->unset_userdata('flagBuyerUsers');
        $this->index();
    }

    public function resetFilterTravel(){
        
        $this->session->unset_userdata('flagTravelerUser');
        $this->resetFilterBuyers();
    }

    
}