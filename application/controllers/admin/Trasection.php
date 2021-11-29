<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Trasection extends CI_Controller {
	function __construct(){
		parent :: __construct();
        
        // ini_set("display_errors", 1);
        // error_reporting(1);
        $this->load->model('Mod_login');

	}
  public function index(){

    $this->Mod_login->is_user_login();
    $db  =  $this->mongo_db->customQuery();
    if( $this->input->post() ){

      $filterData['buyerUsersFilter'] = $this->input->post();
      $this->session->set_userdata($filterData);
    }
    $filterDataBuyer = $this->session->userdata('buyerUsersFilter');

    if($filterDataBuyer['start_date'] != "" && $filterDataBuyer['end_date'] != ""){
      $startDate =  $this->mongo_db->converToMongodttime($filterDataBuyer['start_date']);
      $endDate   =  $this->mongo_db->converToMongodttime($filterDataBuyer['end_date']);
      
      $findArray['created_date'] = ['$gte' => $startDate, '$lte' => $endDate];
    } 
    
    if(!empty($filterDataBuyer['price'])){

      $findArray['price'] = $filterDataBuyer['price'];
    }
   
    $findArray['type'] = 'buyer';
    
    $buyer_trasections    =  $db->payment_details->find($findArray);
    $buyerRes_trasections =  iterator_to_array($buyer_trasections);

    $config['base_url'] = SURL . 'index.php/admin/Trasection/index';
    $config['total_rows'] = count($buyerRes_trasections);
    $config['per_page'] = 20;
    $config['num_links'] = 4;
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

    $getData = [
      [
        '$match' => $findArray
      ],
      [
        '$project' => [
          '_id'            =>  ['$toString' => '$_id'],
          'type'          =>  '$type',
          'created_date'  =>  '$created_date',
          'offer_id'      =>  '$offer_id',
          'buyer_id'      =>  '$buyer_id',
          'traveler_id'   =>  '$raveler_id',
          'order_id'      =>  '$order_id',
          'price'         =>  '$price',
        ]
      ],

      [
        '$lookup' => [
          'from' => 'users',
          'let' => [
            'admin_id' =>  ['$toObjectId' => '$buyer_id'],
          ],
          'pipeline' => [
            [
              '$match' => [
                '$expr' => [
                  '$eq' => [
                    '$_id',
                    '$$admin_id'
                  ]
                ],
              ],
            ],
            [
              '$project' => [
                '_id'             =>  ['$toString' => '$_id'],
                'profile_image'   =>  '$profile_image',
                'full_name'       =>  '$full_name'
              ]
            ],

          ],
          'as' => 'profileData'
        ]
      ],

      [
        '$skip' =>  $page
      ],
      [
        '$limit' =>  $config['per_page'], 
      ],
      [
        '$sort' => [ 'created_date'=> -1]
      ]
    ];
    $buyer_trasec     =  $db->payment_details->aggregate($getData);
    $buyerRes_trasec  =  iterator_to_array($buyer_trasec);

    // echo "<pre>";print_r($buyerRes_trasec);exit;

    $data['buyers_payment']    =  $buyerRes_trasec;
    $this->load->view('trasection/buyer', $data);
  }
  public function trasectionTraveler(){
    $this->Mod_login->is_user_login();
    $db  =  $this->mongo_db->customQuery();
    if( $this->input->post() ){

      $filterData['travelerUsersFilter'] = $this->input->post();
      $this->session->set_userdata($filterData);
    }
   
    $filterData = $this->session->userdata('travelerUsersFilter');

    if($filterData['start_date'] !="" && $filterData['end_date'] != ""){
      $startDate = $this->mongo_db->converToMongodttime($filterData['start_date']);
      $endDate   = $this->mongo_db->converToMongodttime($filterData['end_date']);
      $findArray['created_date'] = ['$gte' => $startDate,  '$lte' => $endDate];
    }   

    if(!empty($filterData['price']) ){

      $findArray['price'] = $filterData['price'];
    }

    $findArray['status'] = 'traveler';
    
    $buyer    =  $db->payment_details->find($findArray);
    $buyerRes =  iterator_to_array($buyer);
    $config['base_url'] = SURL . 'index.php/admin/Trasection/index';
    $config['total_rows'] = count($buyerRes);
    $config['per_page'] = 20;
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

    $getData = [
      [
        '$match' => $findArray
      ],
      [
        '$project' => [
          '_id'            =>  ['$toString' => '$_id'],
          'type'          =>  '$type',
          'created_date'  =>  '$created_date',
          'offer_id'      =>  '$offer_id',
          'buyer_id'      =>  '$buyer_id',
          'traveler_id'   =>  '$raveler_id',
          'order_id'      =>  '$order_id',
          'price'         =>  '$price',
        ]
      ],

      [
        '$lookup' => [
          'from' => 'users',
          'let' => [
            'admin_id' =>  ['$toObjectId' => '$buyer_id'],
          ],
          'pipeline' => [
            [
              '$match' => [
                '$expr' => [
                  '$eq' => [
                    '$_id',
                    '$$admin_id'
                  ]
                ],
              ],
            ],
              
            [
              '$project' => [
                '_id'             =>  ['$toString' => '$_id'],
                'profile_image'   =>  '$profile_image',
                'full_name'       =>  '$full_name'
              ]
            ],

          ],
          'as' => 'profileData'
        ]
      ],
      [
        '$skip' =>  $page
      ],
      [
        '$limit' => $config['per_page'] , 
      ],
      [
        '$sort' => [ 'created_date'=> -1]
      ],
    ];

    $traveler     =  $db->payment_details->aggregate($getData);
    $travelerRes  =  iterator_to_array($traveler);

    // echo "<pre>";print_r($travelerRes);exit;
    $data['traveler_res']    =  $travelerRes;

    $this->load->view('trasection/traveler', $data);
  }

  public function resetFilterTravelers(){ 

    $this->session->unset_userdata('travelerUsersFilter');
    $this->trasectionTraveler();
  }

  public function resetFilterBuyers(){
      
    $this->session->unset_userdata('buyerUsersFilter');
    $this->index();
  }//end
}