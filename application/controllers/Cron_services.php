
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_services extends CI_Controller {
	function __construct(){
		parent :: __construct();

        // ini_set("display_errors", 1);
        // error_reporting(1); 
	}

    public function makeUserTripCompleted(){

        echo "Cron Script Running!";
        $db = $this->mongo_db->customQuery();
        $currentDateTime = $this->mongo_db->converToMongodttime(date('Y-m-d'));

        $getResult = $db->user_trip->find([ 'depart_date' => ['$lte' => $currentDateTime], 'status' => 'new']);
        $result    = iterator_to_array($getResult); 

        if(count($result) > 0){

            $ids = array_column($result, '_id');
            $upadate  = $db->user_trip->updateMany( ['_id' => ['$in' => $ids]], ['$set' => ['status' => 'complete' ]] );  
        }
        echo "<br>Crone Script End!";
    }//end function


    public function makeOrderExpired(){
        echo "Cron Script Running!";
        $db = $this->mongo_db->customQuery();
        $currentDateTime = $this->mongo_db->converToMongodttime(date('Y-m-d'));

        $getResult = $db->orders->find([ 'product_dilivery_date' => ['$lte' => $currentDateTime], 'status' => 'new']);
        $result    = iterator_to_array($getResult); 

        if(count($result) > 0){

            $ids = array_column($result, '_id');
            $upadate  = $db->orders->updateMany( ['_id' => ['$in' => $ids]], ['$set' => ['status' => 'expired' ]] );  
        }
        echo "<br>Crone Script End!";
    }

}//end crone controller