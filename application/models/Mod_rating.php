
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_rating extends CI_Model {
    
  function __construct() {
    parent::__construct();
    
    // ini_set("display_errors", 1);
    // error_reporting(1);
  }

  public function submitRating($ratingArray, $order_id, $buyer_admin_id){
    $db = $this->mongo_db->customQuery();

    $check = $this->checkRatingAlreadyExists($order_id, $buyer_admin_id);
    if($check == true){

      return false ;
    }else{

      $db->rating->insertOne($ratingArray);
      $db->orders->updateOne(['_id' => $this->mongo_db->mongoId($order_id) ],['$push' =>['rated_admin_id' =>  $buyer_admin_id ] ]);
      return true;
    }
  }//end

  public function checkRatingAlreadyExists($order_id, $buyer_admin_id){
      $db = $this->mongo_db->customQuery();

      $get     =  $db->rating->find(['order_id' => $order_id,  'buyer_admin_id' => $buyer_admin_id]);
      $getRes  =  iterator_to_array($get);

      if(count($getRes) > 0){

        return true ;
      }else{
        
        return false ;
      }
  }//end function

  public function getTravelerReviews($traveler_admin_id){

    $db = $this->mongo_db->customQuery();
    $getRatingProfile = [
      [
        '$match' => [

          '_id'  =>  $this->mongo_db->mongoId($traveler_admin_id)
        ]
      ],

      [
        '$project' => [
          '_id'           =>  ['$toString' => '$_id'],
          'full_name'     =>  '$full_name',
          'profile_image' =>  '$profile_image',

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
                'total_reviews'  =>  '$recordCount',
                'recordCount'     =>  ['$sum' => 1]
              ]
            ],

          ],
          'as' => 'traveler_ratting'
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
                      '$buyer_admin_id',
                      '$$admin_id'
                    ]
                  ],
                ],
              ],
              
              [
                  '$project' => [
                    '_id'                 =>  ['$toString' => '$_id'],
                    'buyer_admin_id'      =>   '$buyer_admin_id', 
                    'traveler_admin_id'   =>   '$traveler_admin_id',
                    'order_id'            =>   '$order_id',
                    'rating'              =>   '$rating',
                    'description'         =>   '$description', 
                    'image_url'           =>   '$image_url',
                    'video_url'           =>   '$video_url',
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
                            '_id'           =>  ['$toString' => '$_id'],
                            'full_name'     =>  '$full_name',
                            'profile_image' =>  '$profile_image',
                          ]
                      ],
  
                    ],
                    'as' => 'buyer_details'
                  ]
              ],

            ],
            'as' => 'buyer_ratting'
          ]
      ],
    ];

    $ratting    =  $db->users->aggregate($getRatingProfile);
    $rattingRes =  iterator_to_array($ratting);
    return $rattingRes;
  }//end function


  public function getUserAvgRatting($admin_id){
    $db = $this->mongo_db->customQuery();

    $getRattingQuery = [
      [
        '$match' => [
          
          'traveler_admin_id'   =>  $admin_id
        ]
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
          'total_reviews'  =>  '$recordCount',
          'recordCount'     =>  ['$sum' => 1]
        ]
      ],
    ];

    $ratting    =  $db->rating->aggregate($getRattingQuery);
    $rattingRes =  iterator_to_array($ratting);
    $rattingGet =  $rattingRes[0]['avg_rating'];
    return $rattingGet;

  }

}

