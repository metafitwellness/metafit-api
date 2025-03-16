<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Credit extends CI_Controller
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
	public function index()
	{
	}
	public function addLimit()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		// print_r($_POST);
		if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["appliedLimit"]) && !empty($_POST["appliedLimit"]) && isset($_POST["creditLimit"]) && !empty($_POST["creditLimit"]) && isset($_POST["landingPartner"]) && !empty($_POST["landingPartner"]) && isset($_POST["riskCategory"]) && !empty($_POST["riskCategory"])) {
			$userId = $this->input->post('userId', true);
			$creditLimit = $this->input->post('creditLimit', true);
			$appliedLimit = $this->input->post('appliedLimit', true);
			$landingPartner = $this->input->post('landingPartner', true);
			$riskCategory = $this->input->post('riskCategory', true);
			$addedBy = $this->input->post('addedBy', true);


			$this->db->set('active', 0)->where('userId', $userId)->where('userId', $userId)->update('creditdetails');

			$data = array(
				'userId' => $userId,
				'creditLimit' => $creditLimit,
				'appliedLimit' => $appliedLimit,
				'landingPartner' => $landingPartner,
				'riskCategory' => $riskCategory,
				'active' => 1,
				'status' => 'pending',
				'addedBy' => $addedBy
			);

			$res = $this->db->insert('creditdetails', $data);

			if ($res) {
				$insert_id = $this->db->insert_id();
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
	public function approveLimit()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		// print_r($_POST);
		if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["status"]) && !empty($_POST["status"]) && isset($_POST["reason"]) && isset($_POST["verifiedBy"]) && !empty($_POST["verifiedBy"]) && isset($_POST["creditId"]) && !empty($_POST["creditId"])) {
			$userId = $this->input->post('userId', true);
			$status = $this->input->post('status', true);
			$reason = $this->input->post('reason', true);
			$verifiedBy = $this->input->post('verifiedBy', true);
			$creditId = $this->input->post('creditId', true);
			$creditLimit = $this->input->post('creditLimit', true);


			$data = array(
				'active' => 1,
				'reason' => $reason,
				'verifiedBy' => $verifiedBy,
				'status' => $status,
				'verifiedOn' => date("Y-m-d H:i:s")
			);
			$this->db->where('userId', $userId)->where('id', $creditId)->update('creditdetails', $data);


			$data = array(
				'creditLimit' => $creditLimit
			);
			$this->db->where('id', $userId)->update('users', $data);

			$res = 1;
			if ($res) {
				header('Status: 200');
				$return = array("status" => "200", "data" => "success");
				echo json_encode($return);
			} else {
				header('Status: 401');
				$return = array("status" => "401", "data" => "Invalid Data - A");
				echo json_encode($return);
			}
		} else {
			// Validation Failed
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}

	public function landingPartner()
	{
		// if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
		// 	$_POST = json_decode(file_get_contents("php://input"), true);
		// }
		header('Content-Type: application/json');
		// if (isset($_GET["userId"]) && !empty($_GET["userId"])) {
		$this->load->model('creditmodel');
		$data = $this->creditmodel->listLandingPartner();
		$return = array("status" => "200", "data" => $data);
		return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($return));
		// } else {
		// 	$return = array("status" => "401", "data" => "Invalid Data");
		// 	header('Status: 401');
		// 	echo json_encode($return);
		// }
	}
	public function creditDetails()
	{
		// if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
		// 	$_POST = json_decode(file_get_contents("php://input"), true);
		// }
		header('Content-Type: application/json');
		if (isset($_GET["userId"]) && !empty($_GET["userId"])) {
			$userId = $this->input->get('userId', true);
			$this->load->model('creditmodel');
			$data = $this->creditmodel->listUserCreditDetails($userId);
			$return = array("status" => "200", "data" => $data);
			return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($return));
		} else {
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}
}
