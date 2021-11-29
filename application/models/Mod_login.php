

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_login extends CI_Model {
    function __construct() {

        parent::__construct();
        
    }
    public function is_user_login(){

        $db = $this->mongo_db->customQuery();
        $admin_id = $this->session->userdata('admin_id');
        if( !empty($admin_id) ) {
                
            return true;

        }else{

            $this->load->view('admin/login');
            redirect(base_url() . 'index.php/admin/login/index');
        }
    }
}
