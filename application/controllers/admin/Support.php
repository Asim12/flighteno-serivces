<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends CI_Controller {
	
	function __construct() {

		parent::__construct();
		ini_set("display_errors", 1);
        error_reporting(1);
		$this->load->model('Mod_isValidUser');
		$this->load->model('Mod_login');
        
	}


    public function index(){
        $this->Mod_login->is_user_login();
        $db  =  $this->mongo_db->customQuery();

        $findArray['profile_status'] = 'buyer';
        $buyerComplains    =  $db->support->find($findArray);
        $buyerComplainsRes =  iterator_to_array($buyerComplains);
  
        $config['base_url'] = SURL . 'index.php/admin/Support/index';
        $config['total_rows'] = count($buyerComplainsRes);
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

        $aggregateQuery = [
            [
                '$match' => $findArray
            ],

            [
                '$project' => [

                    '_id'           =>   ['$toString' => '$_id'],
                    'order_number'  =>  '$order_number',
                    'subject'       =>  '$subject',
                    'message'       =>  '$message',
                    'image'         =>  '$image',
                    'admin_id'      =>  '$admin_id',
                    'created_date'  =>  '$created_date',
                    'status'        =>  '$status',
                    'video'         =>  '$video',
                ]
            ],
            [
                '$lookup' => [
                    'from' => 'users',
                    'let' => [
                        'admin_id' =>  ['$toObjectId' => '$admin_id'],
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
                '$limit' => $config['per_page'] 
            ],

            [ 
                '$sort'=> [ 'created_date' => -1]
            ]
        ];
        $buyerData        =  $db->support->aggregate($aggregateQuery);
        $supportBuyerRes  =  iterator_to_array($buyerData);
        
        $data['buyer_res']    =  $supportBuyerRes;
        $this->load->view('support/buyer', $data);
    }//end

    public function travelerSupport(){
        $this->Mod_login->is_user_login();
        $db  =  $this->mongo_db->customQuery();

        $findArray['profile_status'] = 'traveler';
        $buyer_trasections    =  $db->support->find($findArray);
        $buyerRes_trasections =  iterator_to_array($buyer_trasections);
  
        $config['base_url'] = SURL . 'index.php/admin/Support/travelerSupport';
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

        $aggregateQuery = [
            [
                '$match' => $findArray
            ],

            [
                '$project' => [

                    '_id'           =>   ['$toString' => '$_id'],
                    'order_number'  =>  '$order_number',
                    'subject'       =>  '$subject',
                    'message'       =>  '$message',
                    'imageUrl'      =>  '$imageUrl',
                    'admin_id'      =>  '$admin_id',
                    'created_date'  =>  '$created_date',
                    'status'        =>  '$status',
                    'videoUrl'      =>  '$videoUrl',
                ]
            ],
            [
                '$lookup' => [
                    'from' => 'users',
                    'let' => [
                        'admin_id' =>  ['$toObjectId' => '$admin_id'],
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
                '$limit' => $config['per_page'] 
            ],

            [ 
                '$sort'=> [ 'created_date' => -1]
            ]
        ];
        $supportTraveler     =  $db->support->aggregate($aggregateQuery);
        $supportTravelerRes  =  iterator_to_array($supportTraveler);
        
        $data['traveler_res']    =  $supportTravelerRes;
        $this->load->view('support/traveler', $data);
    }//end

    public function tickets(){
        $this->Mod_login->is_user_login();
        $db  =  $this->mongo_db->customQuery();

        if($this->input->get('profile') == 'traveler'){

            $search['profile_status'] = 'traveler';
            $this->session->set_userdata('tab', 'traveler');
        }else{
            $this->session->set_userdata('tab', 'buyer');
            $search['profile_status'] = 'buyer';
        }
        $totalTickets  =  $db->ticket->count($search);

        $config['base_url']         =   SURL . 'index.php/admin/Support/tickets';
        $config['total_rows']       =   $totalTickets;
        $config['per_page']         =   15;
        $config['num_links']        =   2;
        $config['use_page_numbers'] =   TRUE;
        $config['uri_segment']      =   4;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"]   =   '<li>';
        $config["first_tag_close"]  =   '</li>';
        $config["last_tag_open"]    =   '<li>';
        $config["last_tag_close"]   =   '</li>';
        $config['next_link']        =   'Next<i class="fa fa-long-arrow-right"></i>';
        $config['next_tag_open']    =   '<li>';
        $config['next_tag_close']   =   '</li>';
        $config['prev_link']        =   '<i class="fa fa-long-arrow-left"></i>Previous';
        $config['prev_tag_open']    =   '<li>';
        $config['prev_tag_close']   =   '</li>';
        $config['full_tag_open']    =   '<ul class="pagination">';
        $config['full_tag_close']   =   '</ul>';
        $config['cur_tag_open']     =   '<li class="active"><a href="#"><b>';
        $config['cur_tag_close']    =   '</b></a></li>';
        $config['num_tag_open']     =   '<li>';
        $config['num_tag_close']    =   '</li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        if($page !=0) 
        {
        $page = ($page-1) * $config['per_page'];
        }
        $data["links"] = $this->pagination->create_links();

        $getTickets = [
            [
                '$match' => $search

            ],
    
            [
                '$project' => [
                    '_id'           =>  ['$toString' => '$_id'],
                    'admin_id'      =>  '$admin_id',
                    'message'       =>  '$message',
                    'subject'       =>  '$subject',
                    'status'        =>  '$status',
                    'image'         =>  '$image',
                    'video'         =>  '$video',
                    'order_number'  =>  '$order_number',
                    'created_date'  =>  '$created_date'
                ]
            ],
            // [
            //     '$lookup' => [
            //         'from' => 'ticket_reply',
            //         'let' => [
            //             'ticketId' =>  '$_id',
            //         ],
            //         'pipeline' => [
            //             [
            //             '$match' => [
            //                 '$expr' => [
            //                     '$eq' => [
            //                         '$ticket_id',
            //                         '$$ticketId'
            //                     ]
            //                 ],
            //                 'status' => 'new'
            //             ],
            //         ],
                    
            //         [
            //             '$group' => [
            //                 '_id'    =>  '$ticket_id',
            //                 'count'  =>  ['$sum' => 1] 
                            
            //             ]
            //         ]
            //     ],
            //     'as' => 'unreadMessageCount'
            //     ]
            // ],

            [
                '$lookup' => [
                'from' => 'users',
                'let' => [
                    'admin_id' =>    ['$toObjectId' => '$admin_id'],
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
                            '_id'           =>  1,
                            'full_name'     => '$full_name',
                            'profile_image' => '$profile_image'
                            
                        ]
                    ]
                ],
                'as' => 'ticketUserData'
                ]
            ],

            [
                '$sort' => ['created_date' => -1 ]
            ],
            [
                '$skip' => intval($page)
            ],
            [
                '$limit'  => intval($config['per_page'])
            ],
        ];

        $tickets    = $db->ticket->aggregate($getTickets);
        $ticketData = iterator_to_array($tickets);
        $data['tickets'] = $ticketData;
        $this->load->view('support/support', $data);
    }//end
    
    public function getMessages(){
        $this->Mod_login->is_user_login();
        $db = $this->mongo_db->customQuery();
        $ticketId  =  (string)$this->input->post('ticketId');
        // $db->ticket_reply->updateMany(['ticket_id' => $ticketId, 'status' => "new" ], ['$set' => ['status' => 'read']]);
        $getMessages = [
            [
                '$match' => [

                    '_id' => $this->mongo_db->mongoId($ticketId)
                ]
            ],
    
            [
                '$project' => [
                    '_id'           =>  ['$toString' => '$_id'],
                    'admin_id'      =>  '$admin_id',
                    'image'         =>  '$image',
                    'video'         =>  '$video',
                    'order_number'  =>  '$order_number',
                    'subject'       =>  '$subject',
                    'message'       =>  '$message',
                    'created_date'  =>  [ '$dateToString' => [ 'format' => "%Y:%m:%d:%H:%M:%S:%L%z", 'date' => '$created_date', 'timezone' => "America/New_York"] ],
                    'status'        =>  '$status',
                ]
            ],

            [
                '$lookup' => [
                    'from' => 'users',
                    'let' => [
                        'admin_id' =>    ['$toObjectId' => '$admin_id'],
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
                                '_id'           =>  1,
                                'full_name'     => '$full_name',
                                'profile_image' => '$profile_image',
                                'email_address' =>  '$email_address'
                            ]
                        ]
                    ],
                    'as' => 'profileData'
                ]
            ],

            [
            '$lookup' => [
                'from' => 'ticket_reply',
                'let' => [
                    'ticket_id' => '$_id',
                ],
                'pipeline' => [
                    [
                        '$match' => [
                            '$expr' => [
                                '$eq' => [
                                    '$ticket_id',
                                    '$$ticket_id'
                                ]
                            ],
                        ],
                    ],
                    
                    [
                        '$project' => [
                            '_id'           =>  ['$toString' => '$_id'],
                            'ticket_id'     =>  '$ticket_id',
                            'admin_id'      =>  '$admin_id',
                            'message'       =>  '$message',
                            'created_date'  =>  [ '$dateToString' => [ 'format' => "%Y:%m:%d:%H:%M:%S:%L%z", 'date' => '$created_date', 'timezone' => "America/New_York"] ],
                            'status'        =>  '$status',
                            'file'          =>  '$file',
                            'image'         =>  '$image',
                        ]
                    ],
                    [
                        '$lookup' => [
                            'from' => 'users',
                            'let' => [
                                'admin_id' =>    ['$toObjectId' => '$admin_id'],
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
                                        '_id'           =>  1,
                                        'full_name'     => '$full_name',
                                        'profile_image' => '$profile_image',
                                        'email_address' =>  '$email_address'
                                    ]
                                ]
                            ],
                            'as' => 'userData'
                        ]
                    ],
                    [
                        '$sort' => ['created_date' => 1]
                    ],
                ],
                'as' => 'messages'
                ]
            ],

            [
                '$sort' => ['created_date' => 1 ]
            ],
        ];

        $messages     = $db->ticket->aggregate($getMessages);
        $messagesData = iterator_to_array($messages);
        $messagesData = json_encode((array)$messagesData);
        echo $messagesData;
        // print_r($messagesData);
        exit;
    }//end

    public function sendMessage(){
        $this->Mod_login->is_user_login();
        $db = $this->mongo_db->customQuery();

        $tickerReply = [
            'ticket_id'    =>  (string)$this->input->post('ticketId'),
            'message'      =>  (string)$this->input->post('sendMessage'),
            'admin_id'     =>  $this->session->userdata('admin_id'),
            'status'       =>  'new',
            'created_date' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
        ];
        $db = $this->mongo_db->customQuery();
        $db->ticket_reply->insertOne($tickerReply); 
        return true;
    }//end message

    public function imageSendUpload(){

        if($_FILES['image']['name'] != '' && $this->input->post('ticketId') ){
			$uploadImagePath = FCPATH.'assets/uploads/';

			$orignal_file_name = $_FILES['image']['name'];

			$config['upload_path']   = $uploadImagePath;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png';
			$config['max_size']	     = '6000';
			$config['overwrite']     = true;
            $config['encrypt_name']  =  TRUE;
			$config['file_name']     = $orignal_file_name;
			$this->load->library('upload', $config);
            $this->upload->initialize($config);

			if(!$this->upload->do_upload('image')){
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;

			}else{
			
                $data = array('upload_data' => $this->upload->data());
			    $imagePath = $data['upload_data']['full_path'];
                $imagePath = str_replace("/var/www/html/","http://3.120.159.133/", $imagePath);
                print_r($imagePath);
                $tickerReply = [
                    'image'        =>  $imagePath,
                    'ticket_id'    =>  (string)$this->input->post('ticketId'),
                    'admin_id'     =>  $this->session->userdata('admin_id'),
                    'status'       =>  'new',
                    'created_date' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                ];
                $db = $this->mongo_db->customQuery();
                $db->ticket_reply->insertOne($tickerReply); 

                return $imagePath;
		        exit;
            }
        }
    }//end
    
    public function fileSendUpload(){


        if($_FILES['file']['name'] != '' && $this->input->post('ticketId') ){
			
            $fileUploadPath = FCPATH.'assets/uploads/';
			$orignal_file_name = $_FILES['file']['name'];

			$config['upload_path']   = $fileUploadPath;
			$config['allowed_types'] = 'pdf|doc|csv|ppt|docx|txt|tex';
			$config['max_size']	     = '6000';
			$config['overwrite']     = true;
            $config['encrypt_name']  =  TRUE;
			$config['file_name']     = $orignal_file_name;
			$this->load->library('upload', $config);
            $this->upload->initialize($config);

			if(!$this->upload->do_upload('file')){
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;

			}else{
			
                $data = array('upload_data' => $this->upload->data());
			    $filePathFinal = $data['upload_data']['full_path'];

                $filePathFinal = str_replace("/var/www/html/", "http://3.120.159.133/", $filePathFinal);
                print_r($filePathFinal);

                $tickerReply = [
                    'file'         =>  $filePathFinal,
                    'ticket_id'    =>  (string)$this->input->post('ticketId'),
                    'admin_id'     =>  $this->session->userdata('admin_id'),
                    'status'       =>  'new',
                    'created_date' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                ];
                $db = $this->mongo_db->customQuery();
                $db->ticket_reply->insertOne($tickerReply); 

                return $filePathFinal;
		        exit;
            }
        }
    }//end
}