<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Rest\Client;
class Mod_order extends CI_Model {
    
  function __construct() {
      parent::__construct();
      // ini_set("display_errors", 1);
      // error_reporting(1);
  }

  public function getOrders($admin_id){

    $db  =  $this->mongo_db->customQuery();
    $getOrders = [
        [
          '$match' => [
              
            'admin_id' => $admin_id,
          ]
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
            'open_box_check_phisical_apperance'=>   '$open_box_check_phisical_apperance', 
            'product_type'                  =>      '$product_type', 
            'payment_status'                =>      '$payment_status', 
            'estimated_dilivery_fee'        =>      '$estimated_dilivery_fee', 
            'offer_sender_account_ids'      =>      '$offer_sender_account_ids', 
            'Total'                         =>      '$Total', 
            'new_image'                     =>      '$new_image',
            'recipt'                        =>      '$recipt', 
            'rated_admin_id'                =>      '$rated_admin_id'
          ]
        ],
        [
          '$lookup' => [
            'from' => 'accepted_offers',
            'let' => [
              'order_id' =>  '$_id',
            ],
            'pipeline' => [
              [
                '$match' => [
                  '$expr' => [
                    '$eq' => [
                      '$order_id',
                      '$$order_id'
                    ]
                  ],
                  'status' => ['$in' => ['accepted', 'complete']]
                ],
              ],
              
              [
                '$project' => [
                  '_id'           =>  ['$toString' => '$_id'],
                  'traveler_id'   =>  '$traveler_id',
                  'buyer_id'      =>  '$buyer_id'
                ]
              ],
            ],
            'as' => 'traveler_id'
          ]
        ],

        [
          '$lookup' => [
            'from' => 'rating',
            'let' => [
              'order_id' =>  [ '$toString' => '$_id'],
            ],
            'pipeline' => [
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
                  '_id'               =>  ['$toString' => '$_id'],
                  'buyer_admin_id'    =>  '$buyer_admin_id',
                  'traveler_admin_id' =>  '$traveler_admin_id',
                  'order_id'          =>  '$order_id',
                  'rating'            =>  '$rating',
                  'description'       =>  '$description',
                  'image_url'         =>  '$image_url',
                  'video_url'         =>  '$video_url',
                  'created_date'      =>  '$created_date',

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
                        'profile_image' =>  '$profile_image'
                      ]
                    ]
                  ],
                  'as' => 'buyer_user_details'
                ]
              ],
            ],
            'as' => 'review_details'
          ]
        ],
      [
        '$sort' => ['order_created_date' => -1]
      ]
    ];
    $order    =  $db->orders->aggregate($getOrders);
    $orderRes =  iterator_to_array($order);
    return $orderRes;
  }//end

  public function getTravelersOrders($admin_id){

    $db  =  $this->mongo_db->customQuery();
    $getTravelerOrders = [
      [
        '$match' => [
            
          'traveler_id' =>  $admin_id,
          'status'      =>  ['$in' => ['accepted', 'complete']]
        ]
      ],

      [
        '$project' => [
          '_id'           =>  ['$toString' => '$_id'],
          'traveler_id'   =>  '$traveler_id',
          'order_id'      =>  '$order_id',
        ]
      ],
      [
        '$lookup' => [
          'from' => 'orders',
          'let' => [
            'order_id' =>  ['$toObjectId' =>'$order_id'],
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
                'open_box_check_phisical_apperance'=>   '$open_box_check_phisical_apperance', 
                'product_type'                  =>      '$product_type', 
                'payment_status'                =>      '$payment_status', 
                'estimated_dilivery_fee'        =>      '$estimated_dilivery_fee', 
                'offer_sender_account_ids'      =>      '$offer_sender_account_ids', 
                'Total'                         =>      '$Total', 
                'new_image'                     =>      '$new_image',
                'recipt'                        =>      '$recipt', 
                'rated_admin_id'                =>      '$rated_admin_id'

              ]
            ],

            [
              '$lookup' => [
                "from" => "users",
                "let" => [
                  "admin_id" =>  ['$toObjectId' => '$admin_id']
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
                      '_id'           =>  ['$toString' => '$_id'],
                      'full_name'     =>  '$full_name',
                      'profile_image' =>  '$profile_image'
                    ]
                  ],
                ],
                'as' => 'buyer_details'
              ]
            ],

          ],
          'as' => 'orderAsTraveler'
        ]
      ],
      [
        '$sort' => ['created_date' => -1]
      ]
    ];
    $orderTraveler    =  $db->accepted_offers->aggregate($getTravelerOrders);
    $orderTravelerRes =  iterator_to_array($orderTraveler);
    return $orderTravelerRes;
  }

  public function acceptTheOfferAndChangeTheOrderStatus($offerId, $status){

    $db  =  $this->mongo_db->customQuery();
    if($status == 'accept'){

      $getOffer    =  $db->accepted_offers->updateOne(['_id' => $this->mongo_db->mongoId($offerId) ], ['$set' => ['status' => 'accepted']] );

      $getOffer    =  $db->accepted_offers->find(['_id' => $this->mongo_db->mongoId((string)$offerId) ]);
      $getOfferRes =  iterator_to_array($getOffer);

      $this->updateOrderStatusAndUpdateRecord($getOfferRes[0]['order_id'], $getOfferRes[0]['estimateDelivery']);
      $insertBuyerTrasection = [

        'type'         =>  'buyer',
        'created_date' =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
        'offer_id'     =>  $offerId,
        'buyer_id'     =>  $getOfferRes[0]['buyer_id'],
        'traveler_id'  =>  $getOfferRes[0]['traveler_id'],
        'order_id'     =>  $getOfferRes[0]['order_id'],
        'price'        =>  $getOfferRes[0]['total']
      ];

      $db->payment_details->insertOne($insertBuyerTrasection);
      
      $orderId = (string)$getOfferRes[0]['order_id'];

      $lookup = [
          [
          '$match' => [
            '_id' => $this->mongo_db->mongoId($orderId),
          ]
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
              'recipt'                        =>       '$recipt', 
              'rated_admin_id'                =>      '$rated_admin_id'

            ]
          ],

          [
            '$lookup' => [
              'from' => 'accepted_offers',
              'let' => [
                'offer_id' =>    ['$toObjectId' => $offerId],
              ],
              'pipeline' => [
                [
                  '$match' => [
                    '$expr' => [
                      '$eq' => [
                        '$_id',
                        '$$offer_id'
                      ]
                    ],
                    'status' => ['$in' => ['accepted', 'complete']]
                  ],
                ],
                
                [
                  '$project' => [
                    '_id'           =>  ['$toString' => '$_id'],
                    'traveler_id'    =>  '$traveler_id'
                  ]
                ]
              ],
              'as' => 'traveler_id'
            ]
          ],
      ];

      $getOrder = $db->orders->aggregate($lookup);
      $orderResponse = iterator_to_array($getOrder);

      $db->accepted_offers->updateMany(['order_id' => $this->mongo_db->mongoId((string)$getOfferRes[0]['order_id']), 'status' => 'new' ], ['$set' => ['status' => 'rejected']] );
      return $orderResponse;
    }else{

      $getOffer    =  $db->accepted_offers->updateOne(['_id' => $this->mongo_db->mongoId($offerId) ], ['$set' => ['status' => 'rejected']] );

      $getOffer    =  $db->accepted_offers->find(['_id' => $this->mongo_db->mongoId((string)$offerId) ]);
      $getOfferRes =  iterator_to_array($getOffer);
      $orderId = (string)$getOfferRes[0]['order_id'];
      $lookup = [
        [
        '$match' => [
          '_id' => $this->mongo_db->mongoId($orderId),
        ]
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
            'recipt'                        =>       '$recipt', 
            'rated_admin_id'                =>      '$rated_admin_id'

          ]
        ],

        [
          '$lookup' => [
            'from' => 'accepted_offers',
            'let' => [
              'offer_id' =>    ['$toObjectId' => $offerId],
            ],
            'pipeline' => [
              [
                '$match' => [
                  '$expr' => [
                    '$eq' => [
                      '$_id',
                      '$$offer_id'
                    ]
                  ],
                  'status' => ['$in' => ['accepted', 'complete']]
                ],
              ],
              
              [
                '$project' => [
                  '_id'           =>  ['$toString' => '$_id'],
                  'traveler_id'    =>  '$traveler_id'
                ]
              ]
            ],
            'as' => 'traveler_id'
          ]
        ],
      ];

      $getOrder = $db->orders->aggregate($lookup);
      $orderResponse = iterator_to_array($getOrder);
      return $orderResponse;
    }

  }//end

  public function updateOrderStatusAndUpdateRecord($order_id, $newFee){

    $db  =  $this->mongo_db->customQuery();
    $getOrderDetails    =  $db->orders->find([ '_id' => $this->mongo_db->mongoId((string)$order_id) ]);
    $getOrderDetailsRes =  iterator_to_array($getOrderDetails);

    $total          = ( ( (float)$getOrderDetailsRes[0]['Total'] ) - ( (float)$getOrderDetailsRes[0]['estimated_dilivery_fee'] ) + ((float)$newFee) );
    $getOffer    =  $db->orders->updateOne([ '_id' => $this->mongo_db->mongoId((string)$order_id) ], ['$set' => ['status' => 'accepted',  'estimated_dilivery_fee' => (float)$newFee, 'Total' => $total]] );
      
    return true;
  }

  public function offerSaveForPayment($arrayInserted, $order_id, $buyer_id, $traveler_id, $trip_id){ 

    $db  =  $this->mongo_db->customQuery();

    $where['order_id']      =   (string)$order_id;
    $where['buyer_id']      =   (string)$buyer_id;
    $where['traveler_id']   =   (string)$traveler_id;
    $where['trip_id']       =   (string)$trip_id;
    $where['status']        =   'new';

    $getOfferId = $db->accepted_offers->updateOne($where, ['$set' => $arrayInserted], ['upsert' => true] );
    $getOfferId = $db->accepted_offers->find($where);
    $result     = iterator_to_array($getOfferId);
    $OfferId = (string)$result[0]['_id'];
    return (string)$OfferId;
    
  }

  public function getRecentOrders($admin_id){
    $db  =  $this->mongo_db->customQuery();
    $getRecentOrders = [
      [
        '$match' => [
            
          'admin_id' => $admin_id
        ]
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
          'open_box_check_phisical_apperance'=>    '$open_box_check_phisical_apperance', 
          'product_type'                  =>      '$product_type', 
          'payment_status'                =>      '$payment_status', 
          'estimated_dilivery_fee'        =>      '$estimated_dilivery_fee', 
          'offer_sender_account_ids'      =>      '$offer_sender_account_ids', 
          'Total'                         =>      '$Total', 
          'new_image'                     =>      '$new_image',
          'recipt'                        =>      '$recipt', 
          'rated_admin_id'                =>      '$rated_admin_id'

        ]
      ],
      [
        '$lookup' => [
          'from' => 'accepted_offers',
          'let' => [
            'order_id' =>  '$_id',
          ],
          'pipeline' => [
            [
              '$match' => [
                '$expr' => [
                  '$eq' => [
                    '$order_id',
                    '$$order_id'
                  ]
                ],
                'status' => ['$in' => ['accepted', 'complete']]
              ],
            ],
            
            [
              '$project' => [
                '_id'           =>  ['$toString' => '$_id'],
                'traveler_id'    => '$traveler_id'
              ]
            ]
          ],
          'as' => 'traveler_id'
        ]
      ],
    
      [
        '$lookup' => [
          'from' => 'rating',
          'let' => [
            'order_id' =>  [ '$toString' => '$_id'],
          ],
          'pipeline' => [
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
                '_id'               =>  ['$toString' => '$_id'],
                'buyer_admin_id'    =>  '$buyer_admin_id',
                'traveler_admin_id' =>  '$traveler_admin_id',
                'order_id'          =>  '$order_id',
                'rating'            =>  '$rating',
                'description'       =>  '$description',
                'image_url'         =>  '$image_url',
                'video_url'         =>  '$video_url',
                'created_date'      =>  '$created_date',

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
                      'profile_image' =>  '$profile_image'
                    ]
                  ]
                ],
                'as' => 'buyer_user_details'
              ]
            ],
          ],
          'as' => 'review_details'
        ]
      ],
      [
        '$sort' => ['order_created_date' => -1]
      ],
      [
        '$limit' => 10
      ]
    ];

    $orderGet   =  $db->orders->aggregate($getRecentOrders);
    $orderRes   =  iterator_to_array($orderGet);
    return $orderRes;
  }

  public function makeAsCancelled($order_id, $admin_id){

    $db   =  $this->mongo_db->customQuery();
    $time =  $this->mongo_db->converToMongodttime(date('Y-m-d', strtotime('+1 days') ));

    $getStatus = $db->orders->updateOne(['status' => 'new', 'admin_id' => $admin_id, '_id' => $this->mongo_db->mongoId($order_id), 'order_created_date' => ['$lte' => $time] ],  ['$set' => ['status' => 'cancelled']]);

    if($getStatus->getModifiedCount() > 0 ){
      return true;
    }else{

      return false;
    }
  }//end

  public function saveSupport($insertSupport){
    $db   =  $this->mongo_db->customQuery();
    $db->support->insertOne($insertSupport);
    return true;
  }

  public function markCompete($order_id){
    $db   =  $this->mongo_db->customQuery();

    $db->orders->updateOne(['_id' => $this->mongo_db->mongoId($order_id)], ['$set' => ['status' => 'complete']]);
    $db->accepted_offers->updateOne(['order_id' => $order_id, 'status' => 'accepted'], ['$set' => ['status' => 'complete']]);

    return true;
  }

  public function uploadImageAndRecipt($order_id, $image, $recipt){
    $db   =  $this->mongo_db->customQuery();
    $db->orders->updateOne(['_id' => $this->mongo_db->mongoId($order_id)], ['$set' => ['new_image' => $image, 'recipt' => $recipt]]);
    
    return true;
  }

  public function getDetailsForNotification($order_id){
    $db   =  $this->mongo_db->customQuery();
    $offerData =  $db->accepted_offers->find(['order_id' => $order_id, 'status' => 'accepted']);
    $getData   =  iterator_to_array($offerData);
    return $getData;
  }

  public function getOfferDetails($offer_id){
    $db   =  $this->mongo_db->customQuery();

    $offerData =  $db->accepted_offers->find(['_id' => $this->mongo_db->mongoId((string)$offer_id)]);
    $getData   =  iterator_to_array($offerData);
    return $getData;

  }

  public function getOrderName($order_id){

    $db   =  $this->mongo_db->customQuery();

    $offerData =  $db->orders->find(['_id' => $this->mongo_db->mongoId((string)$order_id)]);
    $getData   =  iterator_to_array($offerData);
    return $getData[0]['name'];
  }

  public function getOrderDetails($order_id){

    $db   =  $this->mongo_db->customQuery();
    $getOrders = [
      [
        '$match' => [
            
          '_id' => $this->mongo_db->mongoId((string)$order_id)
        ]
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
          'open_box_check_phisical_apperance'=>    '$open_box_check_phisical_apperance', 
          'product_type'                  =>      '$product_type', 
          'payment_status'                =>      '$payment_status', 
          'estimated_dilivery_fee'        =>      '$estimated_dilivery_fee', 
          'offer_sender_account_ids'      =>      '$offer_sender_account_ids', 
          'Total'                         =>      '$Total', 
          'new_image'                     =>      '$new_image',
          'recipt'                        =>      '$recipt', 
          'rated_admin_id'                =>      '$rated_admin_id'

        ]
      ],
    ];

    $offerData =  $db->orders->aggregate($getOrders);
    $getData   =  iterator_to_array($offerData);
    return $getData[0];
  }


  public function getTreandingOrders(){
    $db  =  $this->mongo_db->customQuery();
    $getRecentOrders = [
      [
        '$match' => [
            
          'order_type' => 'url'
        ]
      ],

      [
        '$group' => [

          '_id'                           =>      '$name',
          'url'                           =>      ['$first' => '$url'], 
          'order_type'                    =>      ['$first' => '$order_type'], 
          'product_image'                 =>      ['$first' => '$product_image'], 
          'name'                          =>      ['$first' => '$name'], 
          'product_price'                 =>     ['$first' => '$product_price'], 
        ]
      ],
      [
        '$sort' => ['created_date' => -1]
      ],
      [
        '$limit' => 10
      ] 
    ];

    $orders   =  $db->orders->aggregate($getRecentOrders);
    $trending =  iterator_to_array($orders);
    return $trending;
  }//end 


  public function calculateCost(){
    $db  = $this->mongo_db->customQuery();

    $startDate =  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s', strtotime('- 30 Days')));
    $aggregateQuery = [
      [
        '$match' => [
          
          'created_date' => ['$gte' => $startDate]
        ]
      ],
      [
        '$group' => [
          '_id'       =>  null,
          'totalCost' =>  ['$sum' => '$price']
        ]
      ]
    ];

    $payment        =   $db->payment_details->aggregate($aggregateQuery);
    $getPaymentData =   iterator_to_array($payment);
    return $getPaymentData[0]['totalCost'];
  }//end

  public function checkStatus($order_id, $admin_id){
    $db = $this->mongo_db->customQuery();

    $getData = $db->orders->find(['order_id' => $order_id, 'buyer_id' =>  $admin_id ]);
    $details = iterator_to_array($getData);
    if(count($details) > 0){
      
      return 'buyer';
    }else{

      $checkOffer = $db->accepted_offers->find(['order_id' => $order_id, 'status' => 'accepted', 'traveler_id' =>  $admin_id ]);
      $OfferDetails = iterator_to_array($checkOffer);
      if(count($OfferDetails) > 0){
        
        return 'traveler';
      }else{

        return 'Order id is wrong';
      }
    }
  }//end
}

