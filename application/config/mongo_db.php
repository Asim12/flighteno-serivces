<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$config['mongo_db']['active'] = 'default';
$config['mongo_db']['default']['no_auth'] = true;
$config['mongo_db']['default']['hostname'] = 'flightenocluster.irdgi.mongodb.net';
$config['mongo_db']['default']['port'] = '27017';
$config['mongo_db']['default']['username'] = 'asim';
$config['mongo_db']['default']['password'] = '95bcqr1Tech';
$config['mongo_db']['default']['database'] = 'flighteno';
$config['mongo_db']['default']['db_debug'] = TRUE;
$config['mongo_db']['default']['return_as'] = 'array';
$config['mongo_db']['default']['write_concerns'] = (int) 1;
$config['mongo_db']['default']['journal'] = TRUE;
$config['mongo_db']['default']['read_preference'] = 'primary';
$config['mongo_db']['default']['read_concern'] = 'local'; //'local', 'majority' or 'linearizable'
$config['mongo_db']['default']['legacy_support'] = TRUE;
/* End of file database.php */
/* Location: ./application/config/database.php */