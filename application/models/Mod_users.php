
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_users extends CI_Model {
    
  function __construct() {
    parent::__construct();
    
    // ini_set("display_errors", 1);
    // error_reporting(1);
  }

  public function active_InactiveUsers(){

      $db = $this->mongo_db->customQuery();

      $startingTime   =  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-2 month') ));
      $endingTime     =  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-1 month') ));

      $lookUp = [
          [
              '$match' => [ 

                'created_date'  =>  ['$gte' =>   $startingTime,  '$lte' =>  $endingTime],
              ]
          ],
          [
            '$group' => [
            
              '_id'  => '$admin_id'
            ]
          ],
      ];

      $usersCount  =  $db->users->aggregate($lookUp);
      $usersAll    =  iterator_to_array($usersCount);
      return count($usersAll);
  }

  public function findActivePercentage(){
      
    $db = $this->mongo_db->customQuery();
    $startingTimeLast   =  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-3 month') ));
    $endingTimeLast     =  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-2 month') ));

    $startingTimeCurrent   =  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-2 month') ));
    $endingTimeCurrent     =  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-1 month') ));

    $lastCreated = [
        [
            '$match' => [
                
                'created_date' =>  [ '$gte' => $startingTimeLast  , '$lte' => $endingTimeLast ] 
            ]
        ],
        [

          '$group' => [
              '_id'    =>  '$admin_id',
              'count'  =>   ['$sum' => 1]
          ]
        ]
    ];
    $currentCreated = [
        [
            '$match' => [
                
                'created_date' =>  [ '$gte' => $startingTimeCurrent  , '$lte' => $endingTimeCurrent] 
            ]
        ],
        [

            '$group' => [
                '_id'    =>  '$admin_id',
                'count'  =>   ['$sum' => 1]
            ]
        ]
    ];

    $lastMonth =  $db->payment_details->aggregate($lastCreated);
    $lastResp  =  iterator_to_array($lastMonth);

    $prevMonth    =  $db->payment_details->aggregate($currentCreated);
    $previouResp  =  iterator_to_array($prevMonth);
    
    
    if($previouResp  &&  $lastResp){

        $activePercentage =  ( ($lastResp[0]['count'] / $previouResp[0]['count'] ) * 100) ;
    }else{

        $activePercentage = 0;
    }
    
    if( $previouResp[0]['count'] >= $lastResp[0]['count']){

        $activePerColor   =  'text-success';
    }elseif($previouResp[0]['count'] < $lastResp[0]['count']){

        $activePerColor   =  'text-danger';
    }else{

        $activePerColor   =  'text-success';
    }

    return ['activePercentage' => (float)$activePercentage,  'activeColor' => $activePerColor, 'preMonthAtiveUsers' => (float)$previouResp[0]['count'], 'lastMonthActiveUsers' => (float)$lastResp[0]['count'] ];
  
  }

  public function findSignedUpUsers(){
      $db = $this->mongo_db->customQuery();


      $startingTimeLast   =  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-3 month') ));
      $endingTimeLast     =  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-2 month') ));

      $startingTimeCurrent   =  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-2 month') ));
      $endingTimeCurrent     =  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('-1 month') ));

      $getPreviousMonthUser = [
          'created_date'  =>  ['$gte' => $startingTimeLast , '$lte' => $endingTimeLast],
          'user_role'     =>  2,
          'status'        =>  'user'
      ]; 
      
      $getLastMonthUser = [
          'created_date'  =>  ['$gte' => $startingTimeCurrent , '$lte' => $endingTimeCurrent],
          'user_role'     =>  2,
          'status'        =>  'user'
      ]; 
      
      $countUsersSignedUpLast = $db->users->count($getLastMonthUser);
      $countUsersSignedUpPre  = $db->users->count($getPreviousMonthUser);

      $percentageSignedUp = ( !empty($countUsersSignedUpLast) && !empty($countUsersSignedUpPre) ) ? ( ($countUsersSignedUpLast / $countUsersSignedUpPre) * 100) : 0;

      $signedUpUsersColor = ($countUsersSignedUpLast > $countUsersSignedUpPre) ? 'text-success' : 'text-danger';

      return [ 'signedUpUserColor' => $signedUpUsersColor,  'percentageSignedUp' => $percentageSignedUp];
  }  

  public function getUserLocation(){

    $ip = getenv('HTTP_CLIENT_IP') ?:
    getenv('HTTP_X_FORWARDED_FOR') ?:
    getenv('HTTP_X_FORWARDED') ?:
    getenv('HTTP_FORWARDED_FOR') ?:
    getenv('HTTP_FORWARDED') ?:
    getenv('REMOTE_ADDR');            
    $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    $detail  = (array) $details;
    return $detail;
  }

  public function checkTripAlreadyExists($admin_id, $TravelingFrom, $TravelingTo, $depart_date){

      $db = $this->mongo_db->customQuery();

      $where['admin_id']       =  $admin_id; 
      $where['Traveling_from'] =  $TravelingFrom;
      $where['Traveling_to']   =  $TravelingTo;
      $where['status']         =  'new';
      $where['depart_date' ]   =  $this->mongo_db->converToMongodttime(date($depart_date));

      $getData = $db->user_trip->find($where);
      $records = iterator_to_array($getData);

      if(count($records) > 0){

          return true;
      }else{

          return false;
      }
  }//end model function

  public function getUserDetail($admin_id){
      $db = $this->mongo_db->customQuery();

      $getUserData = [
        [
          '$match' => [

            '_id'  => $this->mongo_db->mongoId((string)$admin_id)
          ]
        ],

        [
          '$project' => [
              '_id'               =>    ['$toString' => '$_id'],
              'profile_image'     =>    '$profile_image',
              'full_name'         =>    '$full_name',
          ]
        ],
        [
            '$lookup' => [
              'from' => 'rating',
              'let' => [
                'admin_id' =>  '$_id',
              ],
              'pipeline' => [
                [
                  '$match' => [
                    '$expr' => [
                      '$eq' => [
                        '$traveler_admin_id',
                        '$$admin_id'
                      ]
                    ],
                  ],
                ],
                
                [
                  '$project' => [
                    '_id' => ['$toString'=>    '$_id'],
                    'buyer_admin_id'     =>    '$buyer_admin_id',
                    'traveler_admin_id'  =>    '$traveler_admin_id',
                    'order_id'           =>    '$order_id',
                    'rating'             =>    '$rating',
                    'description'        =>    '$description',
                    'image_url'          =>    '$image_url',
                    'video_url'          =>    '$video_url',
                    'created_date'       =>    '$created_date',
                  ]
                ],


                [
                  '$lookup' => [
                    'from' => 'users',
                    'let' => [
                      'admin_id' =>  ['$toObjectId' => '$buyer_admin_id'],
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
                          '_id' => ['$toString'=>    '$_id'],
                          'full_name'     =>  '$full_name',
                          'profile_image' =>      '$profile_image'
                        ]
                      ],
                    ],
                    'as' => 'buyer_user_details'
                  ]
                ],

                [
                  '$sort' => ['created_date' => -1]
                ]
              ],
              'as' => 'traveler_review'
            ]
        ],
        [
          '$lookup' => [
            'from' => 'rating',
            'let' => [
              'admin_id' =>  '$_id',
            ],
            'pipeline' => [
              [
                '$match' => [
                  '$expr' => [
                    '$eq' => [
                      '$traveler_admin_id',
                      '$$admin_id'
                    ]
                  ],
                ],
              ],
              
              [
                '$group' => [
                  '_id'         =>  ['$toString'  => '$traveler_admin_id'],
                  'sumRating'   =>  ['$sum' => '$rating'],
                  'recordCount' =>  ['$sum' => 1]
                ]
              ],

              [
                '$project' => [
                  '_id'             =>  1,
                  'avg_rating'      =>  ['$divide' => [ '$sumRating', '$recordCount']],
                  'total_reviews'   =>  '$recordCount',
                  'recordCount'     =>  ['$sum' => 1]
                ]
              ],

            ],
            'as' => 'traveler_ratting'
          ]
        ],
        [
          '$sort' => ['created_date' => -1]
        ]
      ];
      $getUsers   =  $db->users->aggregate($getUserData);
      $getUserRes =  iterator_to_array($getUsers);
      return $getUserRes;
  }

  public function saveToken($admin_id, $deveice_token){

    $db = $this->mongo_db->customQuery();

    $db->users->updateOne(['_id' => $this->mongo_db->mongoId($admin_id)],  ['$set' => ['device_token' => $deveice_token]] );
    return true;
  }//end function


  public function sendNotification($reciver_admin_id, $message, $type, $sender_admin_id, $status_message = '',  $order_id = ''){
    $db = $this->mongo_db->customQuery();
    
    $tokenUser =  $this->getUserDeviceToken($reciver_admin_id);
    // var_dump($tokenUser);
    if($tokenUser  == false){
      
      return false;
    }else{
      
      $url = 'https://fcm.googleapis.com/fcm/send';
      $serverKey = "AAAAQAL28yY:APA91bFZsSCfQlCKrJvqaDipJgi9THj0AibfSGRPkoEqd9hGUZE7Rn1c9vg620HcEKrQJ7twu8q8QG315pzembQyM9hi8SclGXwrPaWeCUs3GB9qEDlV6sB9vRqlqoxG1jTFMk0xJHzb";
      $headers = array (
        'Authorization:key=' . $serverKey,
        'Content-Type:application/json'
      );
      
      $getFullName =  $this->getUserFullName($sender_admin_id);
      // Add notification content to a variable for easy reference
      $notifData = [
        'title' => $getFullName,
        'body'  => $message,
      ];
      $dataPayload = [

        'other_data' => $type
      ];
		  
      // Create the api body
      $apiBody = [
        'notification' =>  $notifData,
        'data'         =>  $dataPayload, //Optional
        'to'           =>  $tokenUser
      ];
      $ch = curl_init();
      curl_setopt ($ch, CURLOPT_URL, $url);
      curl_setopt ($ch, CURLOPT_POST, true);
      curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));
      $result = curl_exec($ch);
      curl_close($ch);

      $result = json_decode($result);
      if($result->failure == 0){

        $status =  'success'; 
      }else{

        $status =  'error';
      }
      $insertData = [

        'sender_admin_id'      =>   $sender_admin_id,
        'reciver_admin_id'     =>   $reciver_admin_id,
        'message'              =>   $message,
        'title'                =>   $getFullName,
        'created_date'         =>   $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
        'notification_status'  =>   $status,
        'status'               =>   'pending',
        'order_id'             =>   $order_id
      ];

      if($status_message == 'message'){

        return $result;
      }else{

        $db->notifications->insertOne($insertData);
      }

      return $result;

    }//end else
		  
	}//end function


  public function getUserDeviceToken($reciver_admin_id){
    $db = $this->mongo_db->customQuery();

    $user     =  $db->users->find(['_id' => $this->mongo_db->mongoId((string)$reciver_admin_id), 'device_token' => ['$exists' => true] ]);
    $userData =  iterator_to_array($user);

    if(count($userData) > 0){

      return ($userData[0]['device_token']);
    }else{

      return false;
    }

  }//end function


  public function getUserFullName($sender_admin_id){
    $db = $this->mongo_db->customQuery();

    $user     =  $db->users->find(['_id' => $this->mongo_db->mongoId((string)$sender_admin_id)]);
    $userData =  iterator_to_array($user);

    if(count($userData) > 0){

      return ($userData[0]['full_name']);
    }else{

      return false;
    }

  }//end function

  
  public function getNotification($admin_id){
    $db = $this->mongo_db->customQuery();

    $getNotificationData = [
      [
        '$match' => [

          'reciver_admin_id'  => (string)$admin_id
        ]
      ],

      [
        '$project' => [
          '_id'                  =>    ['$toString' => '$_id'],
          'sender_admin_id'      =>   '$sender_admin_id',
          'reciver_admin_id'     =>   '$reciver_admin_id',
          'message'              =>   '$message',
          'title'                =>   '$title',
          'created_date'         =>   '$created_date',
          'notification_status'  =>   '$notification_status',
          'status'               =>   '$status',
          'order_id'             =>   '$order_id',  
        ]
      ],
      [
        '$lookup' => [
          'from' => 'users',
          'let' => [
            'admin_id' =>  ['$toObjectId' => '$sender_admin_id' ],
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
                '_id' => ['$toString'=>    '$_id'],
                'full_name'    =>  '$full_name',
                'profile_image'=>  '$profile_image'
              ]
            ],
          ],
          'as' => 'profile_details'
        ]
      ],
      [
        '$sort'   =>  ['created_date' => -1]
      ],
      ['$limit' => 50]

    ];
    $getNot    =  $db->notifications->aggregate($getNotificationData);
    $getNotRes =  iterator_to_array($getNot);
    return $getNotRes;
  }

  public function notificationStatusMarkAsRead($notification_id = '', $admin_id = ''){
    $db = $this->mongo_db->customQuery();
    if(!empty($notification_id) ){

      $db->notifications->updateOne(['_id' => $this->mongo_db->mongoId((string)$notification_id) ],  ['$set' => ['status' => 'read']]);

    }else{

      $db->notifications->updateMany(['reciver_admin_id' => $admin_id],  ['$set' => ['status' => 'read']]);
    }
    return true;
  }//end function


  public function getUser($admin_id){
    $db = $this->mongo_db->customQuery();

    $getUser = [
      [
        '$match' => [

          '_id'    =>   $this->mongo_db->mongoId((string)$admin_id)
        ]
      ],
      [
        '$project' => [
          '_id'           =>    ['$toString' => '$_id'],
          'first_name'    =>  '$first_name', 
          'last_name'     =>  '$last_name',
          'username'      =>  '$username',
          'email_address' =>  '$email_address',
          'phone_number'  =>  '$phone_number',
          'profile_image' =>  '$profile_image',
          'country'       =>  '$country',
          'full_name'     =>  '$full_name',
          'profile_status'=>  '$profile_status',
          'password'      =>  '$password',
          'conected_account_id' => '$conected_account_id'
        ]
      ]
    ];
    $user =  $db->users->aggregate($getUser);
    $getUser =  iterator_to_array($user);
    return $getUser[0];
  }


  public function updateProfile($admin_id, $full_name, $profile_image){
    $db = $this->mongo_db->customQuery();

    $update = [];
    if(!empty($full_name) && !is_null($full_name) ){

      $update['full_name'] = $full_name;
    }

    if( !empty($profile_image) && !is_null($profile_image) ){
      $update['profile_image'] = $profile_image;
    }

    if( !empty($update) && !is_null($update) ){

      $db->users->updateOne(['_id' => $this->mongo_db->mongoId($admin_id) ], ['$set' => $update ] );
    }
    return true ;
  }

}//end model
