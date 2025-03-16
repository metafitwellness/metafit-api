<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
	public function __construct()
	{
		$headers = apache_request_headers();
		if (isset($headers["api-key"])) {
			if ($headers["api-key"] == 'dsnvjkn2398jfsd9c803lm') {
			} else {
				$return = array("status" => "401", "data" => "INVALID API KEY");
				header('Status: 401');
				echo json_encode($return);
				die;
			}
		} else {
			$return = array("status" => "401", "data" => "API KEY NOT FOUND");
			header('Status: 401');
			echo json_encode($return);
			die;
		}
		// header('Access-Control-Allow-Origin: *');
		// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		// header("Access-Control-Allow-Headers: Origin,X-Requested-With,Content-Type,Accept,Access-Control-Request-Method,Authorization,Cache-Control")
		parent::__construct();
	}
	public function index() {}

	public function register()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		if (isset($_POST["phoneNumber"]) && !empty($_POST["phoneNumber"]) && isset($_POST["name"]) && !empty($_POST["name"]) && isset($_POST["segment"]) && !empty($_POST["segment"])) {

			$phoneNumber = $this->input->post('phoneNumber', true);
			$city = $this->input->post('city', true);
			$name = $this->input->post('name', true);
			$segment = $this->input->post('segment', true);
			$password = $this->input->post('password', true);
			$referral = $this->input->post('referral', true);
			$onboardingAmount = $this->input->post('onboardingAmount', true);
			$planId = $this->input->post('planId', true);
			$password = md5($password);
			$otp = rand(111111, 999999);

			$data_delete = [
				'status' => 'deleted',
				'active' => 0
			];
			
			if($onboardingAmount > 0){
			    $rStatus = 'registered';
			}else{
			    $rStatus = 'onboarded';
			}
            
            $rStatus = 'registered'; //new added for handling
            
			$res = $this->db->select('id')->where('phoneNumber', $phoneNumber)->where('active', 1)->where('status', $rStatus)->order_by('id', 'desc')->limit(1)->get('tempusers')->row();
			if ($res) {
				header('Status: 200');
				$return = array("status" => "200", "data" => $rStatus);
				echo json_encode($return);
				die;
			}

			$this->db->where('phoneNumber', $phoneNumber);
			$this->db->where('status', 'pending');
			$this->db->where('active', 1);
			$this->db->update('tempusers', $data_delete);
            
            $otp = 123456;

			$data = array(
				'name' => $name,
				'segment' => $segment,
				'city' => $city,
				'phoneNumber' => $phoneNumber,
				'otp' => $otp,
				'addedOn' => date("Y-m-d H:i:s"),
				'updatedOn' => date("Y-m-d H:i:s"),
				'status' => 'pending',
				'onboardingAmount' => $onboardingAmount,
				'planId' => $planId,
				'active' => 1,
				'referral' => $referral,
				'password' => $password
			);

			$this->load->model('apimodel');
// 			$this->apimodel->sendOtp($phoneNumber, $otp);

			$res = $this->db->insert('tempusers', $data);
			if ($res) {
				header('Status: 200');
				$insert_id = $this->db->insert_id();
				$return = array("status" => "200", "data" => $insert_id);
				echo json_encode($return);
			} else {
				header('Status: 401');
				$return = array("status" => "401", "data" => "Invalid Data");
				echo json_encode($return);
			}
		} else {
			// Validation Failed
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}



	public function verifyotp()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		// print_r($_POST);
		if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["phoneNumber"]) && !empty($_POST["phoneNumber"]) && isset($_POST["otp"]) && !empty($_POST["otp"])) {

			$userId = $this->input->post('userId', true);
			$phoneNumber = $this->input->post('phoneNumber', true);
			$otp = $this->input->post('otp', true);


			$res = $this->db->select('*')->where('id', $userId)->where('phoneNumber', $phoneNumber)->where('active', 1)->where('status', 'pending')->order_by('id', 'desc')->limit(1)->get('tempusers')->row();
			if ($res && $res->otp === $otp) {
				$data = array(
                    'status' => 'registered'
                );
                
                $this->db->where('id', $res->id);
                $updated = $this->db->update('tempusers', $data);
                // $res->status = 'registered';
				// $res->status = 'active';
				
				if($res->onboardingAmount > 0){
    			    $rStatus = 'registered';
    			}else{
    			    $rStatus = 'onboarded';
    			    
    			    $planId = $res->planId;
    			    
    			    $data = array(
                        'userId' => $userId,
                        'planId' => $planId,
                        'amount' => 0,
                        'dateAdded' => date('Y-m-d'),
                        'status' => 'active',
                        'active' => 1
                    );
                    
                    $this->db->insert('onboardings', $data);


                    $data = array(
                        'userId' => $userId,
                        'planId' => $planId,
                        'subscriptionId' => 'FREE PLAN',  // You mentioned this should be 'FREE PLAN'
                        'status' => 'active',  // Assuming status should be 'active', adjust as needed
                        'total_count' => 12,
                        'paid_count' => 12,
                        'remaining_count' => 0,
                        'dateAdded' => date('Y-m-d'),
                        'active' => 1
                    );
                    
                    $this->db->insert('subscriptions', $data);

                    
                    

    			}
    			$res->status = $rStatus;

				$data = array(
					'name' => $res->name,
					'segment' => $res->segment,
					'city' => $res->city,
					'countryCode' => $res->countryCode,
					'phoneNumber' => $res->phoneNumber,
					'password' => $res->password,
					'referral' => $res->referral,
					'onboardingAmount' => $res->onboardingAmount,
				    'planId' => $res->planId,
					'isSubscribed' => 0,
					'addedOn' => date("Y-m-d H:i:s"),
					'updatedOn' => date("Y-m-d H:i:s"),
					'accountStatus' => $rStatus,
					'status' => 0,
					'active' => 1
				);

				$this->db->insert('users', $data);
				$insert_id = $this->db->insert_id();
				
				
				$res = $this->db->select('*')->where('id', $insert_id)->where('phoneNumber', $phoneNumber)->where('active', 1)->order_by('id', 'desc')->limit(1)->get('users')->row();
				unset($res->password);
				
				$data = array(
					'userId' => $insert_id,
				);

				$this->db->insert('users_profile', $data);
				$this->db->insert_id();


				$return = array("status" => "200", "data" => "success", 'datax' => $res);
				echo json_encode($return);
			} else {
				if ($res->attempt == 2) {
					$dateAdded = date("Y-m-d H:i:s");
					$this->db->set('status', "'deleted'", FALSE);
					$this->db->set('active', "0", FALSE);
					$this->db->set('deletedOn', $dateAdded);
				}
				$this->db->set('attempt', "attempt+1", FALSE);
				$this->db->where('id', $res->id);
				$this->db->update('tempusers');
				header('Status: 200');
				$return = array("status" => "200", "data" => "Invalid OTP", "attempt" => $res->attempt + 1);
				echo json_encode($return);
			}
		} else {
			// Validation Failed
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}
	public function verifyotp_login()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		// print_r($_POST);
		if (isset($_POST["phoneNumber"]) && !empty($_POST["phoneNumber"]) && isset($_POST["otp"]) && !empty($_POST["otp"])) {

			$phoneNumber = $this->input->post('phoneNumber', true);
			$otp = $this->input->post('otp', true);


			$res = $this->db->select('*')->where('phoneNumber', $phoneNumber)->where('active', 1)->limit(1)->get('users')->row();
			if ($res->otp === $otp) {
				$return = array("status" => "200", "data" => "success", 'datax' => $res->id);
				echo json_encode($return);
			} else {
				$return = array("status" => "200", "data" => "Invalid OTP");
				header('Status: 200');
				echo json_encode($return);
			}
		} else {
			// Validation Failed
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}
	public function resendotp()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["phoneNumber"]) && !empty($_POST["phoneNumber"])) {
			$userId = $this->input->post('userId', true);
			$phoneNumber = $this->input->post('phoneNumber', true);
			$res = $this->db->select('id, otp')->where('id', $userId)->where('phoneNumber', $phoneNumber)->where('active', 1)->where('status', 'pending')->order_by('id', 'desc')->limit(1)->get('tempusers')->row();
			if ($res) {

				$this->load->model('apimodel');
				$this->apimodel->sendOtp($phoneNumber, $res->otp);

				$this->db->set('attempt', "'0'", FALSE);
				$this->db->where('phoneNumber', $phoneNumber);
				$this->db->where('status', 'pending');
				$this->db->update('tempusers');

				header('Status: 200');
				$return = array("status" => "200", "data" => "success");
				echo json_encode($return);
			} else {
				header('Status: 401');
				$return = array("status" => "401", "data" => "Invalid Data");
				echo json_encode($return);
			}
		} else {
			// Validation Failed
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}

	////////////////////////////////////////////////
	////////////////////////////////////////////////
	////////////////////////////////////////////////
	////////////////////////////////////////////////
	public function userList($userId = null, $invoiceId = null)
	{
		$this->load->model('apimodel');
		$data = $this->apimodel->listTempUsers($userId, $invoiceId);
		$return = array("status" => "200", "data" => $data);
		return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($return));
	}


	public function confirmRegister()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		// print_r($_POST);
		if (isset($_POST["countryCode"]) && !empty($_POST["countryCode"]) && isset($_POST["emailId"]) && !empty($_POST["emailId"]) && isset($_POST["phoneNumber"]) && !empty($_POST["phoneNumber"]) && isset($_POST["designatoryName"]) && !empty($_POST["designatoryName"]) && isset($_POST["country"]) && !empty($_POST["country"]) && isset($_POST["currency"]) && !empty($_POST["currency"]) && isset($_POST["expectedCreditLimit"]) && !empty($_POST["expectedCreditLimit"])) {

			$phoneCode = $this->input->post('countryCode', true);
			$email = $this->input->post('emailId', true);
			$phoneNumber = $this->input->post('phoneNumber', true);
			$designatory = $this->input->post('designatoryName', true);
			$businessName = $this->input->post('businessName', true);
			$businessType = $this->input->post('businessType', true);
			$country = $this->input->post('country', true);
			$currency = $this->input->post('currency', true);
			$annualTurnOver = $this->input->post('annualTurnover', true);
			$expectedCredit = $this->input->post('expectedCreditLimit', true);
			$otherBusinessType = $this->input->post('otherBusinessType', true);
			$id = $this->input->post('id', true);

			$newPassword = generateRandomString(32);
			$dateAdded = date("Y-m-d H:i:s");

			$data = array(
				'name' => $designatory,
				'designatoryName' => $designatory,
				'businessName' => $businessName,
				'businessType' => $businessType,
				'otherBusinessType' => $otherBusinessType,
				'annualTurnover' => $annualTurnOver,
				'currency' => $currency,
				'country' => $country,
				'expectedCreditLimit' => $expectedCredit,
				'emailId' => $email,
				'countryCode' => $phoneCode,
				'phoneNumber' => $phoneNumber,
				'firstLogin' => 1,
				'addedOn' => date("Y-m-d H:i:s"),
				'updatedOn' => date("Y-m-d H:i:s"),
				'password' => md5($newPassword),
				'accountStatus' => 'kyc_pending',
				'active' => 1,
				'status' => 1
			);




			$res = $this->db->insert('users', $data);

			if ($res) {
				$insert_id = $this->db->insert_id();
				$string = 'We' . $insert_id . '_' . $newPassword . '---';

				$to      = $email;
				$subject = 'Registration Accepted';
				$message = 'Dear user your registration is successfull and Your Reset Link is : ' . portalAddress . 'first-login/' . $string;
				$headers = 'From: no-reply@togglefinance.com' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
				mail($to, $subject, $message, $headers);
				header('Status: 200');

				$this->db->set('userId', $insert_id);
				$this->db->where('emailId', $email);
				$this->db->where('id', $id);
				$this->db->update('tempusers');


				$return = array("status" => "200", "data" => $insert_id, "link" => $string);
				echo json_encode($return);
			} else {
				header('Status: 401');
				$return = array("status" => "401", "data" => "Invalid Data");
				echo json_encode($return);
			}
		} else {
			// Validation Failed
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}



	public function updateUserDetails()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		if (isset($_POST["countryCode"]) && !empty($_POST["countryCode"]) && isset($_POST["emailId"]) && !empty($_POST["emailId"]) && isset($_POST["phoneNumber"]) && !empty($_POST["phoneNumber"]) && isset($_POST["designatoryName"]) && !empty($_POST["designatoryName"]) && isset($_POST["country"]) && !empty($_POST["country"]) && isset($_POST["currency"]) && !empty($_POST["currency"]) && isset($_POST["expectedCreditLimit"]) && !empty($_POST["expectedCreditLimit"])) {

			$id = $this->input->post('id', true);
			$isTemp = $this->input->post('isTemp', true);
			$dateAdded = date("Y-m-d H:i:s");

			$_POST["updatedOn"] = $dateAdded;

			unset($_POST["isTemp"]);
			unset($_POST["id"]);
			unset($_POST["accountStatus"]);
			unset($_POST["status"]);


			if ($isTemp) {
				$this->db->where('id', $id);
				$res = $this->db->update('tempusers', $_POST);
				// print_r($res);
			} else {
				$this->db->where('id', $id);
				$res = $this->db->update('users', $_POST);
				$this->db->where('userId', $id);
				$res = $this->db->update('tempusers', $_POST);
			}

			if ($res) {
				header('Status: 200');
				$return = array("status" => "200", "data" => 1);
				echo json_encode($return);
			} else {
				header('Status: 401');
				$return = array("status" => "401", "data" => "Invalid Data");
				echo json_encode($return);
			}
		} else {
			// Validation Failed
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}
	function verifyLink()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		if (isset($_POST["link"]) && !empty($_POST["link"]) && isset($_POST["timestamp"]) && !empty($_POST["timestamp"])) {

			$timestamp = $this->input->post('timestamp', true);
			$link = $this->input->post('link', true);

			$data = explode('_', $link);
			if (isset($data[0]) && isset($data[1])) {
				$userId = str_replace('We', '', $data[0]);
				$pass = $password = str_replace('---', '', $data[1]);
				$password = md5($password);

				$res = $this->db->select('emailId')->where('id', $userId)->where('password', $password)->where('active', 1)->limit(1)->get('users')->row();
				$res->key = $pass;
				// print_r($res);
				if ($res) {
					header('Status: 200');
					$return = array("status" => "200", "data" => $res);
					echo json_encode($return);
				} else {
					header('Status: 401');
					$return = array("status" => "401", "data" => "Invalid Data");
					echo json_encode($return);
				}
			} else {
				header('Status: 401');
				$return = array("status" => "401", "data" => "Invalid Data");
				echo json_encode($return);
			}
		} else {
			// Validation Failed
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}


	function updateUserStatus()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		if (isset($_POST["accountStatus"]) && !empty($_POST["accountStatus"]) && isset($_POST["userId"]) && !empty($_POST["userId"])) {

			$accountStatus = $this->input->post('accountStatus', true);
			$userId = $this->input->post('userId', true);
			$dateAdded = date("Y-m-d H:i:s");

			$updatedOn = $dateAdded;

			$data = array(
				"accountStatus" => $accountStatus,
				"updatedOn" => $updatedOn
			);

			$this->db->where('id', $userId);

			$res = $this->db->update('users', $data);

			if ($res) {
				header('Status: 200');
				$return = array("status" => "200", "data" => 1);
				echo json_encode($return);
			} else {
				header('Status: 401');
				$return = array("status" => "401", "data" => "Invalid Data");
				echo json_encode($return);
			}
		} else {
			// Validation Failed
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}
}
function generateRandomString($length = 10)
{
	return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}
