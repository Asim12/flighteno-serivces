<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Mod_activity extends CI_Model {
    
    function __construct() {
        parent::__construct();
        
        // ini_set("display_errors", 1);
        // error_reporting(1);
    }

    public function saveActivity($data){

        $db = $this->mongo_db->customQuery();
        $db->activities->insertOne($data);
        return true;
    }//end
}