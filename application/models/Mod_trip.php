
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_trip extends CI_Model {
    
  function __construct() {
    parent::__construct();
    
    // ini_set("display_errors", 1);
    // error_reporting(1);
  }

  public function getUserTrips($admin_id){

    $db = $this->mongo_db->customQuery();
    $getLookUp = [
        [
          '$match' => [

            'admin_id' => (string)$admin_id 
          ]
        ],
        [
          '$project' => [
            '_id'               =>   ['$toString' => '$_id'],
            'admin_id'          =>   '$admin_id',
            'Traveling_from'    =>   '$Traveling_from',
            'city'              =>   '$city',
            'Traveling_to'      =>   '$Traveling_to',
            'cityTo'            =>   '$cityTo',
            'depart_date'       =>   '$depart_date',
            'return_date'       =>   '$return_date',
            'status'            =>   '$status',
            'created_date'      =>   '$created_date',
          ]
        ],
        [
          '$lookup' => [
            'from' => 'accepted_offers',
            'let' => [
              'admin_id' =>  '$admin_id',
              'trip_id'  =>   '$_id'
            ],
            'pipeline' => [
              [
                '$match' => [
                  '$expr' => [
                    '$eq' => [
                      '$traveler_id',
                      '$$admin_id'
                    ]
                  ],

                  '$expr' => [
                    '$eq' => [
                      '$trip_id',
                      '$$trip_id'
                    ]
                  ],
                  'status'    => ['$in' => ['accepted', 'complete']],
                ],
              ],
              
              [
                '$project' => [
                  '_id'           =>  ['$toString' => '$_id'],
                  'order_id'      =>  '$order_id'
                ]
              ],

              [
                '$lookup' => [
                  'from' => 'orders',
                  'let' => [
                    'order_id' =>  [ '$toObjectId' => '$order_id'],
                  ],
                  'pipeline' => [
                    [
                      '$match' => [
                        '$expr' => [
                          '$eq' => [
                            '$_id',
                            '$$order_id'
                          ]
                        ],
                        'status' => ['$in' => ['accepted', 'complete']]
                      ],
                    ],
                    
                    [
                      '$project' => [
                        '_id'                           =>      ['$toString' => '$_id'],
                        'url'                           =>      '$url', 
                        'order_type'                    =>      '$order_type', 
                        'product_image'                 =>      '$product_image', 
                        'name'                          =>      '$name', 
                        'admin_id'                      =>      '$admin_id', 
                        'preferred_date'                =>      '$preferred_date', 
                        'preferred_dilivery_start_time' =>      '$preferred_dilivery_start_time', 
                        'preferred_dilivery_end_time'   =>      '$preferred_dilivery_end_time', 
                        'quantity'                      =>      '$quantity', 
                        'box_status'                    =>      '$box_status', 
                        'vip_service_status'            =>      '$vip_service_status', 
                        'vip_service_fee'               =>      '$vip_service_fee', 
                        'product_price'                 =>      '$product_price', 
                        'product_discription'           =>      '$product_discription', 
                        'product_weight'                =>      '$product_weight', 
                        'product_buy_country_name'      =>      '$product_buy_country_name', 
                        'product_buy_city_name'         =>      '$product_buy_city_name', 
                        'product_dilivery_country_name' =>      '$product_dilivery_country_name', 
                        'product_dilivery_city_name'    =>      '$product_dilivery_city_name', 
                        'product_dilivery_date'         =>      '$product_dilivery_date', 
                        'flighteno_cost'                =>      '$flighteno_cost', 
                        'status'                        =>      '$status', 
                        'tax'                           =>      '$tax', 
                        'order_created_date'            =>      '$order_created_date', 
                        'use_item_for_testing'          =>      '$use_item_for_testing', 
                        'open_box_check_phisical_apperance'=>       '$open_box_check_phisical_apperance', 
                        'product_type'                  =>      '$product_type', 
                        'payment_status'                =>      '$payment_status', 
                        'estimated_dilivery_fee'        =>      '$estimated_dilivery_fee', 
                        'offer_sender_account_ids'      =>      '$offer_sender_account_ids', 
                        'Total'                         =>      '$Total', 
                        'new_image'                     =>      '$new_image',
                        'recipt'                        =>      '$recipt', 
                      ]
                    ],
                    [
                      '$lookup' => [
                        'from' => 'users',
                        'let' => [
                          'admin_id' =>  [ '$toObjectId' => '$admin_id'],
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
                                'profile_image' => '$profile_image'
                                
                              ]
                          ],

                        ],
                        'as' => 'buyer_details'
                      ]
                    ],
                  ],
                  'as' => 'traveler_orders'
                ]
              ],

            ],
            'as' => 'offers'
          ]
        ],
        [ 
          '$sort' => ['created_date' => -1 ]
        ]
    ];

    $trip       =   $db->user_trip->aggregate($getLookUp);
    $userTrips  =   iterator_to_array($trip);

    return $userTrips;
  }
}
