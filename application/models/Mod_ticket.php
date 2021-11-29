<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_ticket extends CI_Model {
    
  function __construct() {
    parent::__construct();
    
    // ini_set("display_errors", 1);
    // error_reporting(1);
  }

  public function create($ticketData, $admin_id){

    $db = $this->mongo_db->customQuery();
    $db->ticket->insertOne($ticketData);
    $getTickets = [
        [
            '$match' => [
                'admin_id' => $admin_id,
            ]
        ],

        [
          '$project' => [
            '_id'           =>  ['$toString' => '$_id'],
            'admin_id'      =>  '$admin_id',
            'message'       =>  '$message',
            'subject'       =>  '$subject',
            'image'         =>  '$image',
            'video'         =>  '$video',
            'order_number'  =>  '$order_number',
            'status'        =>  '$status',
            'created_date'  =>  '$created_date'
          ]
        ],

        [
            '$lookup' => [
              'from' => 'ticket_reply',
              'let' => [
                'ticket_id' =>    ['$toString' => '$_id'],
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
                    'created_date'  =>  '$created_date',
                    'file'          =>  '$file',
                    'image'         =>  '$image'
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
                            'profile_image' => '$profile_image'
                            
                          ]
                        ]
                      ],
                      'as' => 'userData'
                    ]
                  ],
                [
                    '$sort' => ['created_date' => -1]
                ],
              ],
              'as' => 'messages'
            ]
        ],
        [
            '$sort' => ['created_date'  => -1] 
        ],
    ];

    $tickets    = $db->ticket->aggregate($getTickets);
    $ticketData = iterator_to_array($tickets);

    return $ticketData;
  }//end

  public function sendMessage($tickerReply){

    $db = $this->mongo_db->customQuery();
    $db->ticket_reply->insertOne($tickerReply);
    return true;
  }//end


  public function changeTicketStatus($ticket_id, $status){
    $db = $this->mongo_db->customQuery();

    $db->ticket->updateOne(['_id' => $this->mongo_db->mongoId($ticket_id) ], ['$set' => ['status' => $status ]]);
    return true;

  }//end

  public function getTickts($admin_id){
    $db = $this->mongo_db->customQuery();

    $getTickets = [
      [
          '$match' => [
              'admin_id' => $admin_id,
          ]
      ],

      [
        '$project' => [
          '_id'           =>  ['$toString' => '$_id'],
          'admin_id'      =>  '$admin_id',
          'message'       =>  '$message',
          'subject'       =>  '$subject',
          'image'         =>  '$image',
          'video'         =>  '$video',
          'order_number'  =>  '$order_number',
          'status'        =>  '$status',
          'created_date'  =>  '$created_date'
        ]
      ],

      [
          '$lookup' => [
            'from' => 'ticket_reply',
            'let' => [
              'ticket_id' =>    ['$toString' => '$_id'],
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
                  'created_date'  =>  '$created_date',
                  'file'          =>  '$file',
                  'image'         =>  '$image'
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
                          'profile_image' => '$profile_image'
                          
                        ]
                      ]
                    ],
                    'as' => 'userData'
                  ]
                ],
              [
                  '$sort' => ['created_date' => -1]
              ],
            ],
            'as' => 'messages'
          ]
      ],
      [
          '$sort' => ['created_date'  => -1] 
      ],
    ];

    $tickets    = $db->ticket->aggregate($getTickets);
    $ticketData = iterator_to_array($tickets);

    return $ticketData;
  }//end

}