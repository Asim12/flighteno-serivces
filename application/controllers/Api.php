<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Rest\Client;
class Api extends CI_Controller{
	
	private function setupTwilio(){
		$sid = $this->config->item('sid');
        $token = $this->config->item('twilio_token');
     	$twilio = new Client($sid, $token);
     	return $twilio;
	}
	

	public function SendVerificationCode(){ // done
		
		if($this->input->post('phoneNumber') ){
			
			$phoneNumber = $this->input->post('phoneNumber');
			$twilio = $this->setupTwilio();
			$verification = $twilio->verify->v2->services($this->config->item('service_id'))
									->verifications
									->create($phoneNumber, "sms");
			if($verification->sid){
				http_response_code(200);
				$data = new stdClass;
				$data->Status = 200;
				$data->Message = 'SMS sent Successfully';
				echo json_encode($data);
			}else{
				http_response_code(400);
				$data = new stdClass;
				$data->Status = 400;
				$data->Message = 'SMS sending Failed';
				echo json_encode($data);
			}
			
		}else{

			http_response_code(400);
			$data = new stdClass;
			$data->Status = 400;
			$data->Message = 'phone Number is missing in payload!!!!!!!!';
			echo json_encode($data);

		}
	}


	public function CheckUserAndSendVerificationCode(){ // done

		$phoneNumber = (string)$this->input->post('phoneNumber');

		$twilio = $this->setupTwilio();
		$verification = $twilio->verify->v2->services($this->config->item('service_id'))->verifications->create($phoneNumber, "sms");

		if($verification->sid){

			http_response_code(200);
			$data = new stdClass;
			$data->Status = 200;
			$data->Message = 'SMS sent Successfully';
			echo json_encode($data);
		}else{
				
			http_response_code(400);
			$data = new stdClass;
			$data->Status = 400;
			$data->Message = 'SMS sending Failed';
			echo json_encode($data);
		}

	}


	public function verifyCode(){  //done

		$code   = $this->input->post('code');
		$phone  = $this->input->post('phoneNumber');

		$twilio = $this->setupTwilio();
		$verification_check = $twilio->verify->v2->services($this->config->item('service_id'))->verificationChecks
                                         ->create($code, // code
											["to" => $phone]);

		if($verification_check->status == 'approved'){
			http_response_code(200);
			$data = new stdClass;
			$data->Status = 200;
			$data->Message = 'Phone Verified';
			echo json_encode($data);
		}
		else{
			http_response_code(400);
			$data = new stdClass;
			$data->Status = 400;
			$data->Message = 'Phone not Vverified';
			echo json_encode($data);
		}
	}


	public function test2(){
		$phone = '+923216364123';
		$twilio = $this->setupTwilio();
		$verification = $twilio->verify->v2->services($this->config->item('service_id'))
                                   ->verifications
                                   ->create($phone, "sms");
        echo $verification->sid;
	}


	public function resetPasswordSendCode(){

		$db = $this->mongo_db->customQuery();
        $usernameAuth = md5($this->input->server('PHP_AUTH_USER'));
        $passwordAuth = md5($this->input->server('PHP_AUTH_PW'));

		$validateCredentials = varify_basic_auth($passwordAuth, $usernameAuth);
		if($validateCredentials == true || $validateCredentials == 1){

			$type   = $this->input->post('type');
			$data   = $this->input->post('data');

			if($type  == 'email'){

				$userData    =  $db->users->find([ 'email_address' => $data]);
				$resUserData =  iterator_to_array($userData);
				if(count($resUserData) > 0 ){
					if($resUserData[0]['signup_source'] == 'google' || $resUserData[0]['signup_source'] == 'facebook' ){

						http_response_code(200);
						$data = new stdClass;
						$data->Status = 400;
						$data->Message = 'Your account is associated with social login you can not reset your password.';
						echo json_encode($data);
					}else{
				
						$phoneNumber = $resUserData[0]['phone_number'];
						$twilio = $this->setupTwilio();
						$verification = $twilio->verify->v2->services($this->config->item('service_id'))
												->verifications
												->create($phoneNumber, "sms");
						if($verification->sid){
							http_response_code(200);
							$data = new stdClass;
							$data->Status = 200;
							$data->phoneNumber = $phoneNumber;
							$data->Message = 'SMS sent Successfully';
							echo json_encode($data);
						}else{ 
							http_response_code(400);
							$data = new stdClass;
							$data->Status = 400;
							$data->Message = 'SMS sending Failed';
							$data->phone   =  $phoneNumber;
							echo json_encode($data);
						}
					}
				}else{

					http_response_code(200);
					$data = new stdClass;
					$data->Status = 400;
					$data->Message = 'Your email or phone number is not associated with any account please try again';
					echo json_encode($data);
				}

			}elseif($type == 'phone'){

				$phoneNumber = $data;
				$twilio = $this->setupTwilio();
				$verification = $twilio->verify->v2->services($this->config->item('service_id'))
										->verifications
										->create($phoneNumber, "sms");
				if($verification->sid){
					http_response_code(200);
					$data = new stdClass;
					$data->Status = 200;
					$data->Message = 'SMS sent Successfully';
					echo json_encode($data);
				}else{
					http_response_code(400);
					$data = new stdClass;
					$data->Status = 400;
					$data->Message = 'SMS sending Failed';
					echo json_encode($data);
				}

			}else{

				http_response_code(400);
				$data = new stdClass;
				$data->Status = 400;
				$data->Message = 'Type is incorrect please check';
				echo json_encode($data);
			}
		}else{

			http_response_code(400);
			$data = new stdClass;
			$data->Status = 400;
			$data->Message = 'Authentication Failed';
			echo json_encode($data);
		}
	}//end function


	public function testing222(){

		$data = [

			'status'  => 'testing222'
		];
		$db = $this->mongo_db->customQuery();

		$db->temp->insertOne($data);
	}


	public function testing111(){

	
		$data = [

			'status'  => 'testing111'
		];
		$db = $this->mongo_db->customQuery();

		$db->temp->insertOne($data);
	}

}