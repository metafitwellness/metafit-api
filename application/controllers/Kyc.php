<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kyc extends CI_Controller
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
	public function saveDocument()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		// print_r($_POST);
		if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["documentId"]) && !empty($_POST["documentId"]) && isset($_POST["documentPath"]) && !empty($_POST["documentPath"])) {
			$userId = $this->input->post('userId', true);
			$documentId = $this->input->post('documentId', true);
			$documentPath = $this->input->post('documentPath', true);


			$this->db->set('active', 0)->where('userId', $userId)->where('documentId', $documentId)->update('kycdata');

			$data = array(
				'userId' => $userId,
				'documentId' => $documentId,
				'documentPath' => $documentPath,
				'active' => 1,
				'status' => 'pending'
			);

			$res = $this->db->insert('kycdata', $data);



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

	public function getDocuments()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		if (isset($_POST["userId"]) && !empty($_POST["userId"])) {
			$userId = $this->input->post('userId', true);
			$this->load->model('kycmodel');
			$data = $this->kycmodel->listUserKycDocument($userId);
			$return = array("status" => "200", "data" => $data);
			return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($return));
		} else {
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}

	public function removeDocument()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		// print_r($_POST);
		if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["documentId"]) && !empty($_POST["documentId"])) {
			$userId = $this->input->post('userId', true);
			$documentId = $this->input->post('documentId', true);
			$this->db->set('active', 0)->where('userId', $userId)->where('documentId', $documentId)->update('kycdata');
			$res = 'success';
			if ($res) {
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
	public function updateKyc()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		header('Content-Type: application/json');
		// print_r($_POST);
		if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["userDocumentId"]) && !empty($_POST["userDocumentId"]) && isset($_POST["status"]) && !empty($_POST["status"])) {
			$userId = $this->input->post('userId', true);
			$userDocumentId = $this->input->post('userDocumentId', true);
			$status = $this->input->post('status', true);
			$reason = $this->input->post('reason', true);

			$this->db->set('status', $status)->set('reason', $reason)->where('userId', $userId)->where('id', $userDocumentId)->update('kycdata');
			$res = 'success';
			if ($res) {
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
	public function kycDocumentList()
	{
		$this->load->model('kycmodel');
		$data = $this->kycmodel->listKycDocument();

		$newArr = array();
		$arrayType = array();
		foreach ($data as $key => $value) {
			$arrayType[] = $value["type"];
			$newArr[$value["type"]][] = $value;
		}
		$arrayType = array_unique($arrayType);

		$data = array("types" => $arrayType, "data" => $newArr);

		$return = array("status" => "200", "data" => $data);
		return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($return));
	}
}
