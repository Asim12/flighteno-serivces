<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Rest\Client;
class Mod_chat extends CI_Model {
    
  function __construct() {

    parent::__construct();
    // ini_set("display_errors", 1);
    // error_reporting(1);
  }

  public function getUserChats($sender_id){

    $db  =  $this->mongo_db->customQuery();

    $getMessages = [
      [
        '$match' => [
            
          '$or' =>[
          ['sender_id'   =>  $sender_id],
          ['reciver_id'  =>  $sender_id],
          ],
        ]
      ],
      [
        '$project' => [
          '_id'         =>  ['$toString' => '$_id'],
          'general' => [
            '$cond' => [
              'if' => ['$eq' => ['$sender_id', $sender_id]],
              'then' => 'sender_id',
              'else' => 'reciver_id'
            ]
          ],

          'sender_id'   =>  '$sender_id',
          'reciver_id'  =>  '$reciver_id',
          'order_id'    =>  '$order_id',
          'time'        =>  '$time',
        ]
      ],

      [
        '$lookup' => [
          "from" => "accepted_offers",
          "let" => [

            'order_id' => '$order_id',
          ],
          "pipeline" => [
            [
              '$match' => [
                '$expr' => [
                  '$eq' => [
                    '$order_id',
                    '$$order_id'
                  ]
                ],
              ],
            ],
            
            [
              '$project' => [
                '_id'  => ['$toString' => '$_id'],
                'offer_id' => ['$toString' => '$_id'],
                'status'   => '$status',
              ]
            ]
          ],
          'as' => 'offer_id'
        ]
      ],

      [
        '$lookup' => [
          "from" => "orders",
          "let" => [
            'order_id' => ['$toObjectId' => '$order_id'],
          ],
          "pipeline" => [
            [
              '$match' => [
                '$expr' => [
                  '$eq' => [
                      '$_id',
                      '$$order_id'
                    ]
                ],
              ],
            ],
            
            [
              '$project' => [
                '_id'            => ['$toString' => '$_id'],
                'order_name'      => '$name',
              ]
            ]
          ],
          'as' => 'order_name'
        ]
      ],

      [
        '$lookup' => [
          "from" => "users",
          "let" => [

            'admin_id' => [
              '$cond' => [
                'if' => ['$eq' => ['$general', 'sender_id']],
                'then' => ['$toObjectId' => '$reciver_id'],
                'else' => ['$toObjectId' => '$sender_id']
              ]
            ],
          ],
          "pipeline" => [
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
                '_id'            => ['$toString' => '$_id'],
                'full_name'      => '$full_name',
                'profile_image'  => '$profile_image'
              ]
            ]
          ],
          'as' => 'reciverImageName'
        ]
      ],

      [
        '$lookup' => [
          "from" => "chat_messages",
          "let" => [

            "chat_id"     =>    '$_id',
          ],
          "pipeline" => [
            [
              '$match' => [
                '$expr' => [
                  '$eq' => [
                      '$chat_id',
                      '$$chat_id'
                    ]
                ],
              ],
            ],
            
            [
              '$sort' => ['time' => -1]
            ]
          ],
          'as' => 'messages'
        ]
      ],
    ];

    $messages    =  $db->chat->aggregate($getMessages);
    $messagesRes =  iterator_to_array($messages);

    return $messagesRes;
  }//end

  public function getUserChatsUsingId($buy_admin_id, $traveler_admin_id, $order_id){
    $db  =  $this->mongo_db->customQuery();

    $getMessages = [
      [
        '$match' => [
          'order_id'   =>  $order_id,
          'sender_id'  =>  $traveler_admin_id,
          'reciver_id' =>  $buy_admin_id,
        ]
      ],
      [
        '$project' => [
          '_id'         =>  ['$toString' => '$_id'],
          'sender_id'   =>  '$sender_id',
          'reciver_id'  =>  '$reciver_id',
          'order_id'    =>  '$order_id',
          'time'        =>  '$time',
        ]
      ],

      [
        '$lookup' => [
          "from" => "accepted_offers",  
          "let" => [

            'order_id' => '$order_id',
          ],
          "pipeline" => [
            [
              '$match' => [
                '$expr' => [
                  '$eq' => [
                    '$order_id',
                    '$$order_id'
                  ],
                ],
                'buyer_id'  =>  $buy_admin_id,
                'traveler_id' => $traveler_admin_id
              ],
            ],
            
            [
              '$project' => [
                '_id'  => ['$toString' => '$_id'],
                'offer_id' => ['$toString' => '$_id'],
                'status'   => '$status',
              ]
            ]
          ],
          'as' => 'offer_id'
        ]
      ],

      [
        '$lookup' => [
          "from" => "orders",
          "let" => [
            'order_id' => ['$toObjectId' => '$order_id'],
          ],
          "pipeline" => [
            [
              '$match' => [
                '$expr' => [
                  '$eq' => [
                      '$_id',
                      '$$order_id'
                    ]
                ],
              ],
            ],
            
            [
              '$project' => [
                '_id'            => ['$toString' => '$_id'],
                'order_name'      => '$name',
              ]
            ]
          ],
          'as' => 'order_name'
        ]
      ],

      [
        '$lookup' => [
          "from" => "users",
          "let" => [

            'admin_id' => ['$toObjectId' => $traveler_admin_id ]
             
          ],
          "pipeline" => [
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
                '_id'            => ['$toString' => '$_id'],
                'full_name'      => '$full_name',
                'profile_image'  => '$profile_image'
              ]
            ]
          ],
          'as' => 'reciverImageName'
        ]
      ],

      [
        '$lookup' => [
          "from" => "chat_messages",
          "let" => [

            "chat_id"     =>    '$_id',
          ],
          "pipeline" => [
            [
              '$match' => [
                '$expr' => [
                  '$eq' => [
                      '$chat_id',
                      '$$chat_id'
                    ]
                ],
              ],
            ],
            
            [
              '$sort' => ['time' => -1]
            ]
          ],
          'as' => 'messages'
        ]
      ],
    ];

    $messages    =  $db->chat->aggregate($getMessages);
    $messagesRes =  iterator_to_array($messages);
    return $messagesRes;
  }//end
}