<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
	public function __construct()
	{
		$explode = explode('/', $_SERVER['REQUEST_URI']);
		$explode = $explode[count($explode) - 2];

		if ($explode == 'uploadPdf') {
		} else {
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
		}
		parent::__construct();
	}
	public function index() {}
	public function userList()
	{
		$this->load->model('apimodel');
		$data = $this->apimodel->listUser();
		$return = array("status" => "200", "data" => $data);
		return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($return));
	}
	public function getUser($userId)
	{
		$this->load->model('apimodel');
		$data = $this->apimodel->getUserData($userId);
		$return = array("status" => "200", "data" => $data);
		return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($return));
	}
	public function updateUser($userId = null)
	{
		if (isset($userId) && !empty($userId)) {
			$sql = "UPDATE users SET `active` = 1- `active` WHERE `id` = $userId";
			$res = $this->db->query($sql);
			$return = array("status" => "200", "data" => "status");
			return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($return));
		}
	}
	public function updateUserData($userId = null)
	{
		header('Content-Type: application/json');

		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") === 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}

		if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["emailId"]) && !empty($_POST["emailId"])) {
			$data = $data1 = $_POST;

			$data1 = [
				'emailId' => $_POST['emailId'],
				'firstLogin' => 0,
				'updatedOn' => date("Y-m-d H:i:s")
			];
			
			if($_POST['first_login'] == 1){
			    $data1["verificationStatus"] = 'pending';
			    $data1["accountStatus"] = 'verification';
			}
			if($_POST['verificationStatus'] == 'rejected'){
			    $data1["verificationStatus"] = 'pending';
			}
			
			

			$this->db->where('id', $userId);
			$this->db->update('users', $data1);

			$dataProfile = [
				'Designation' => $_POST['designation'],
				'homeAddress' => $_POST['homeAddress'],
				'officeAddress' => $_POST['officeAddress'],
				'Degree' => $_POST['degree'],
				'passoutYear' => $_POST['passoutYear'],
				'yearsOfExperience' => $_POST['yearsOfExperience'],
				'achievements' => isset($_POST['achievements']) ? $_POST['achievements'] : null,
				'bank_name' => isset($_POST['bank_name']) ? $_POST['bank_name'] : null,
				'bank_ac' => isset($_POST['bank_ac']) ? $_POST['bank_ac'] : null,
				'bank_ifsc' => isset($_POST['bank_ifsc']) ? $_POST['bank_ifsc'] : null,
				'instagram_url' => isset($_POST['instagram_url']) ? $_POST['instagram_url'] : null,
				'linkedin_url' => isset($_POST['linkedin_url']) ? $_POST['linkedin_url'] : null,
				'youtube_url' => isset($_POST['youtube_url']) ? $_POST['youtube_url'] : null,
				'facebook_url' => isset($_POST['facebook_url']) ? $_POST['facebook_url'] : null,
				'website_url' => isset($_POST['website_url']) ? $_POST['website_url'] : null,
				'google_map_url' => isset($_POST['google_map_url']) ? $_POST['google_map_url'] : null,
				'alternative_contact' => isset($_POST['alternative_contact']) ? $_POST['alternative_contact'] : null,
			];

			// Handle image data (photos in binary format) if provided
			if (isset($_FILES['self_photo']) && !empty($_FILES['self_photo']['name'])) {
				$imageInfo = $this->uploadAndCompressImage($_FILES['self_photo']);
				$dataProfile['self_photo'] = $imageInfo['imageName'];
				// $dataProfile['self_photo_name'] = $imageInfo['imageName'];  // Store the renamed file name
			}

			if (isset($_FILES['aadhar_photo']) && !empty($_FILES['aadhar_photo']['name'])) {
				$imageInfo = $this->uploadAndCompressImage($_FILES['aadhar_photo']);
				$dataProfile['aadhar_photo'] = $imageInfo['imageName'];
				// $dataProfile['aadhar_photo_name'] = $imageInfo['imageName'];  // Store the renamed file name
			}

			if (isset($_FILES['clinic_photo']) && !empty($_FILES['clinic_photo']['name'])) {
				$imageInfo = $this->uploadAndCompressImage($_FILES['clinic_photo']);
				$dataProfile['clinic_photo'] = $imageInfo['imageName'];
				// $dataProfile['clinic_photo_name'] = $imageInfo['imageName'];  // Store the renamed file name
			}

			if (isset($_FILES['pan_card_photo_front']) && !empty($_FILES['pan_card_photo_front']['name'])) {
				$imageInfo = $this->uploadAndCompressImage($_FILES['pan_card_photo_front']);
				$dataProfile['pan_card_photo_front'] = $imageInfo['imageName'];
				// $dataProfile['pan_card_photo_front_name'] = $imageInfo['imageName'];  // Store the renamed file name
			}

			if (isset($_FILES['pan_card_photo_back']) && !empty($_FILES['pan_card_photo_back']['name'])) {
				$imageInfo = $this->uploadAndCompressImage($_FILES['pan_card_photo_back']);
				$dataProfile['pan_card_photo_back'] = $imageInfo['imageName'];
				// $dataProfile['pan_card_photo_back_name'] = $imageInfo['imageName'];  // Store the renamed file name
			}


			// Check if the user already has a profile entry
			$this->db->where('userId', $_POST['userId']);
			$query = $this->db->get('users_profile');

			// If the user already has a profile, update it
			if ($query->num_rows() > 0) {
				$this->db->where('userId', $_POST['userId']);
				$this->db->update('users_profile', $dataProfile); // Update 'users_profile' table
			} else {
				// If the user doesn't have a profile, insert a new one
				$dataProfile['userId'] = $_POST['userId'];
				$this->db->insert('users_profile', $dataProfile); // Insert into 'users_profile' table
			}

			// Return success response
			$return = array("status" => "200", "data" => "Success", "res" => "success");
			header('Status: 200');
			echo json_encode($return);
		} else {
			// Return error response if required fields are missing or invalid
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}

    public function updateVerificationStatus($userId = null)
    {
        header('Content-Type: application/json');
    
        // Check if the request content type is JSON
        if (stripos($_SERVER["CONTENT_TYPE"], "application/json") === 0) {
            $_POST = json_decode(file_get_contents("php://input"), true);
        }
    
        // Ensure that 'userId', 'verificationStatus', and 'verificationRemark' are present
        if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["verificationStatus"]) && !empty($_POST["verificationStatus"])) {
    
            // Prepare data to update verification status and remark
            $dataToUpdate = [
                'verificationStatus' => $_POST['verificationStatus'],
                'verificationRemark' => isset($_POST['verificationRemark']) ? $_POST['verificationRemark'] : null,
                'updatedOn' => date("Y-m-d H:i:s")
            ];
            
            if($_POST['verificationStatus'] == 'approved' && $_POST['planAmount'] == '0'){
                $dataToUpdate['accountStatus'] = 'active';
            }else{
                $dataToUpdate['accountStatus'] = 'verified';
            }
    
            // Update the 'users' table with the new verification status and remark
            $this->db->where('id', $userId);
            $this->db->update('users', $dataToUpdate);
    
            // Check if the update was successful
            if ($this->db->affected_rows() > 0) {
                $return = array("status" => "200", "data" => "Verification Status and Remark updated successfully", "res" => "success");
                header('Status: 200');
                echo json_encode($return);
            } else {
                // If no rows were affected, it could mean that the userId doesn't exist or no actual changes
                $return = array("status" => "404", "data" => "User not found or no changes made");
                header('Status: 404');
                echo json_encode($return);
            }
        } else {
            // Return error response if required fields are missing or invalid
            $return = array("status" => "401", "data" => "Invalid Data");
            header('Status: 401');
            echo json_encode($return);
        }
    }


	// Function to upload, compress, and rename image
	private function uploadAndCompressImage($file, $maxWidth = 900, $maxHeight = 900)
	{
		// Check if the file is a valid image
		if ($file['error'] !== UPLOAD_ERR_OK) {
			return null;  // Return null if there's an upload error
		}

		// Get image information
		$imageInfo = getimagesize($file['tmp_name']);
		if (!$imageInfo) {
			return null;  // Return null if the file is not a valid image
		}

		list($width, $height) = $imageInfo;

		// Generate a unique filename using timestamp and a random string (or user ID)
		$extension = pathinfo($file['name'], PATHINFO_EXTENSION);  // Get file extension
		$uniqueName = uniqid('img_', true) . '.' . $extension;  // Unique filename with extension

		// Define the upload directory (make sure the directory exists and is writable)
		$uploadDir = 'uploads/images/';
		if (!is_dir($uploadDir)) {
			mkdir($uploadDir, 0777, true);  // Create directory if it doesn't exist
		}

		// Check if image exceeds max dimensions
		if ($width > $maxWidth || $height > $maxHeight) {
			// Calculate aspect ratio
			$aspectRatio = $width / $height;

			// Resize based on the aspect ratio
			if ($width > $height) {
				$newWidth = $maxWidth;
				$newHeight = round($maxWidth / $aspectRatio);
			} else {
				$newHeight = $maxHeight;
				$newWidth = round($maxHeight * $aspectRatio);
			}

			// Create a new image resource
			$image = imagecreatefromstring(file_get_contents($file['tmp_name']));
			$compressedImage = imagecreatetruecolor($newWidth, $newHeight);

			// Preserve transparency for PNG and GIF
			if ($imageInfo['mime'] == 'image/png' || $imageInfo['mime'] == 'image/gif') {
				imagealphablending($compressedImage, false);
				imagesavealpha($compressedImage, true);
			}

			// Resize the image
			imagecopyresampled($compressedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

			// Save the image to the server
			$savePath = $uploadDir . $uniqueName;
			imagejpeg($compressedImage, $savePath, 90);  // Save the image with 90% quality

			// Clean up
			imagedestroy($image);
			imagedestroy($compressedImage);

			return ['imageData' => file_get_contents($savePath), 'imageName' => $uniqueName, 'imagePath' => $savePath];  // Return image data, file name, and file path
		} else {
			// No need to compress if within the size limit, just save the original image
			$savePath = $uploadDir . $uniqueName;
			move_uploaded_file($file['tmp_name'], $savePath);  // Move the file to the desired location

			return ['imageData' => file_get_contents($savePath), 'imageName' => $uniqueName, 'imagePath' => $savePath];  // Return image data, file name, and file path
		}
	}




	private function generateUniqueFileName($fileName)
	{
		$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
		$uniqueFileName = time() . '_' . uniqid() . '.' . $fileExtension;
		return $uniqueFileName;
	}



	public function login()
	{
		header('Content-Type: application/json');
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") === 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}

		if (isset($_POST["phoneno"]) && !empty($_POST["phoneno"]) && isset($_POST["password"]) && !empty($_POST["password"])) {
			$phoneno = $this->input->post('phoneno', true);
			$password = $this->input->post('password', true);

			$query = $this->db->select('*')->where('active', 1)->where('phoneNumber', $phoneno)->where('password', md5($password))->limit(1)->get('users');
			if ($query->num_rows() > 0) {
				$res = $query->row_array();

				unset($res["password"]);
				$return = array("status" => "200", "data" => "Success", "res" => $res);
				header('Status: 200');
				echo json_encode($return);
			} else {
				$return = array("status" => "200", "data" => "Invalid Creds", "res" => 0);
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
	
	public function get_otp_pending_users()
	{
		$this->db->select('users.id, users.name, users.phoneNumber, 
		users.status, users.active, users.addedOn,
		cities.city_name, segments.segement AS segement, users.referral');
		$this->db->from('tempusers as users');
		$this->db->join('cities', 'users.city = cities.id', 'left');
		$this->db->join('segments', 'users.segment = segments.id', 'left');
		$this->db->where('users.active', 1);
		$this->db->where('users.admin', 0);
		$this->db->where('users.status', 'pending');
		$query = $this->db->get();
		$data = $query->result();

		$return = array("status" => "200", "data" => $data);
		header('Status: 200');
		echo json_encode($return);
	}

	public function updatePassword()
	{
		header('Content-Type: application/json');
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") === 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		if (isset($_POST["phoneNumber"]) && !empty($_POST["phoneNumber"]) && isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["password"]) && !empty($_POST["password"]) && isset($_POST["newPass"]) && !empty($_POST["newPass"])) {
			$userId = $this->input->post('userId', true);
			$phoneNumber = $this->input->post('phoneNumber', true);
			$password = $this->input->post('password', true);
			$newPass = $this->input->post('newPass', true);

			$newPass = md5($newPass);
			$password = md5($password);
			$sql = "UPDATE users SET password = '$newPass' WHERE phoneNumber = '$phoneNumber' AND password = '$password' AND `id` = '$userId' LIMIT 1";
			$this->db->query($sql);
			if (1) {
				$res = 1;
				$return = array("status" => "200", "data" => "Success", "res" => $res);
				header('Status: 200');
				echo json_encode($return);
			} else {
				$return = array("status" => "200", "data" => "Invalid Creds", "res" => 0);
				header('Status: 401');
				echo json_encode($return);
			}
		} else {
			// Validation Failed
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}
	public function resetPassword()
	{
		header('Content-Type: application/json');
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") === 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}

		if (isset($_POST["phoneNumber"]) && !empty($_POST["phoneNumber"])) {
			$phoneNumber = $this->input->post('phoneNumber', true);
			// $newPassword = rand(111111, 999999);
			$newPassword = "123456";

			// echo $newPassword;

			$sql = "UPDATE users SET otp = '$newPassword' WHERE phoneNumber = '$phoneNumber' LIMIT 1";
			$res = $this->db->query($sql);
			if ($this->db->affected_rows() == 1) {
				$res = 1;

				$this->load->model('apimodel');
				$this->apimodel->sendOtp($phoneNumber, $newPassword);

				$return = array("status" => "200", "data" => "Success", "res" => $res);
				header('Status: 200');
				echo json_encode($return);
			} else {
				$return = array("status" => "200", "data" => "Invalid Creds", "res" => 0);
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
	public function loadDashboard($user = 0) {}
	public function loadDashboardAdmin()
	{
		// $query = $this->db->query("SELECT COUNT(id) as users FROM users WHERE active = 1 AND status = 1");

		// $query2 = $this->db->query("SELECT SUM(invoiceAmount) as loanAmount FROM invoice WHERE invoiceStatus = 'completed'");

		// $activeCustomers = 0;
		// if ($query->row()) {
		// 	$activeCustomers = $query->row();
		// 	if (isset($activeCustomers->users)) {
		// 		$activeCustomers = $activeCustomers->users;
		// 	} else {
		// 		$activeCustomers = 0;
		// 	}
		// }
		// $loanAmount = 0;
		// if ($query2->row()) {
		// 	$loanAmount = $query2->row();
		// 	if (isset($loanAmount->loanAmount)) {
		// 		$loanAmount = $loanAmount->loanAmount;
		// 	} else {
		// 		$loanAmount = 0;
		// 	}
		// }
		// $data = array('activeCustomers' => $activeCustomers, 'loanAmount' => $loanAmount);
		// $return = array("status" => "200", "data" => "Success", "res" => $data);
		// header('Status: 200');
		// echo json_encode($return);
	}
	public function paymentStatus($invoice = '')
	{
		if ($invoice != '') {
			$query = $this->db->query("SELECT `paymentFile` FROM `invoicepayment` WHERE invoiceId = '$invoice' ORDER BY id DESC LIMIT 1");
			if ($query->row()) {
				$paymentDetails = $query->row();
			} else {
				$paymentDetails = array();
			}
			$data = array('paymentDetails' => $paymentDetails);
			$return = array("status" => "200", "data" => "Success", "res" => $data);
			header('Status: 200');
			echo json_encode($return);
		}
	}
	public function currencyList()
	{
		$data = array("USD", "JOD");
		$return = array("status" => "200", "data" => "Success", "res" => $data);
		header('Status: 200');
		echo json_encode($return);
	}
	public function countryList()
	{
		$this->load->model('countrycodemodel');
		$data = $this->countrycodemodel->listCountryCode();
		$return = array("status" => "200", "data" => "Success", "res" => $data);
		header('Status: 200');
		echo json_encode($return);
	}
	public function deleteUserData($userId = null)
	{
		header('Content-Type: application/json');
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") === 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["delete"]) && !empty($_POST["delete"])) {
			if ($userId == $_POST["userId"]) {
				$data = array("active" => 0, "deletedOn" => date("Y-m-d H:i:s"));
				$this->db->where('customerId', $userId);
				$this->db->update('invoice', $data);

				if ($_POST["delete"] == "all") {
					$this->db->where('id', $userId);
					$this->db->update('users', $data);
				}

				$return = array("status" => "200", "data" => "Success", "res" => "success");
				header('Status: 200');
				echo json_encode($return);
			} else {
				$return = array("status" => "401", "data" => "Invalid Data");
				header('Status: 401');
				echo json_encode($return);
			}
		} else {
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}


	public function get_user_subscription($userId)
	{
		header('Content-Type: application/json');
		if (isset($userId) && !empty($userId)) {
			$this->load->model('apimodel');
			$data = $this->apimodel->get_subscriptions_by_user($userId);
			$return = array("status" => "200", "data" => $data);
			header('Status: 200');
			echo json_encode($return);
		} else {
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}

	public function get_all_subscription()
	{
		header('Content-Type: application/json');
		$this->load->model('apimodel');
		$data = $this->apimodel->get_subscriptions_all();
		$return = array("status" => "200", "data" => $data);
		header('Status: 200');
		echo json_encode($return);
	}

	public function updateStatus()
	{

		header('Content-Type: application/json');
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") === 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		if (isset($_POST["userId"]) && !empty($_POST["userId"])) {

			$this->db->where('id', $_POST["userId"]);
			$this->db->update('users', ['status' => $_POST["status"]]);

			$return = array("status" => "200", "data" => $_POST["status"]);
			header('Status: 200');
			echo json_encode($return);
		} else {
			$return = array("status" => "401", "data" => "Invalid Data");
			header('Status: 401');
			echo json_encode($return);
		}
	}
	public function add_blog() {
		header('Content-Type: application/json');

		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") === 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
	   // if(isset($_POST['name']) && isset($_POST['des']) && isset($_POST['status']) && isset($_POST['url']) && isset($_POST['date'])) {
// 		$data = $data1 = $_POST;
// 		echo $_POST['name']; die();
			$blogData = [
				'name' => $_POST['name'],
				'des' => $_POST['des'],
				'date' => $_POST['date'],
				'status' => $_POST['status'],
				'url' => $_POST['url'],
			];

			if (isset($_FILES['img']) && !empty($_FILES['img']['name'])) {
				$imageInfo = $this->uploadAndCompressImage($_FILES['img']);
				$blogData['img'] = $imageInfo['imageName'];
			}
			$this->db->insert('blog', $blogData); 
			// Return success response
			$return = array("status" => "200", "data" => "Success", "res" => "success");
			header('Status: 200');
			echo json_encode($return);
// 		} else {
// 			// Return error response if required fields are missing or invalid
// 			$return = array("status" => "401", "data" => "Invalid Data");
// 			header('Status: 401');
// 			echo json_encode($return);
// 		}
	}

	public function update_blog($id){
		header('Content-Type: application/json');

		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") === 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		
//         if(isset($_POST['name']) && isset($_POST['des']) && isset($_POST['status']) && isset($_POST['url']) && isset($_POST['date'])) {
// 			$data = $data1 = $_POST;
			$blogData = [
				'name' => $_POST['name'],
				'des' => $_POST['des'],
				'date' => $_POST['date'],
				'status' => $_POST['status'],
				'url' => $_POST['url'],
				'photochanged' => $_POST['photochanged'],
			];
            if($_POST['photochanged'] == 'true'){
                if (isset($_FILES['img']) && !empty($_FILES['img']['name'])) {
    				$imageInfo = $this->uploadAndCompressImage($_FILES['img']);
    				$blogData['img'] = $imageInfo['imageName'];
            	}
            } else {
                $blogData['img'] = $_POST['img'];
            }
			
			$this->db->where('id', $id);
            $this->db->update('blog', $blogData); 
			// Return success response
			$return = array("status" => "200", "data" => "Success", "res" => "success");
			header('Status: 200');
			echo json_encode($return);
// 		} else {
// 			// Return error response if required fields are missing or invalid
// 			$return = array("status" => "401", "data" => "Invalid Data");
// 			header('Status: 401');
// 			echo json_encode($return);
// 		}
	}
	
	public function get_blogs()
	{
		$this->load->model('apimodel');
		$city = $this->apimodel->get_blogs();
		echo json_encode($city);
	}

	public function get_segments()
	{
		$this->load->model('apimodel');
		$city = $this->apimodel->get_segments();
		echo json_encode($city);
	}
	public function get_plans()
	{
		$this->load->model('apimodel');
		$city = $this->apimodel->get_plans();
		echo json_encode($city);
	}
     public function add_segment() {
        // You can add validation or input sanitization here
        $this->load->model('apimodel');
        $data = json_decode(file_get_contents('php://input'), true); // Getting POST data

        if(isset($data['segement']) && isset($data['active'])) {
            $new_segment = array(
                'segement' => $data['segement'],
                'active' => $data['active']
            );
            $insert = $this->apimodel->add_segment($new_segment);
            echo json_encode(array('status' => $insert ? 'success' : 'error'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid input.'));
        }
    }

    // Update a segment
    public function update_segment($id) {
        // Get the data sent via PUT or POST
        $this->load->model('apimodel');
        $data = json_decode(file_get_contents('php://input'), true); // Getting POST data

        if(isset($data['segement']) && isset($data['active'])) {
            $updated_segment = array(
                'segement' => $data['segement'],
                'active' => $data['active']
            );
            $update = $this->apimodel->update_segment($id, $updated_segment);
            echo json_encode(array('status' => $update ? 'success' : 'error'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid input.'));
        }
    }
    
    
    
	public function get_cities()
	{
		$this->load->model('apimodel');
		$city = $this->apimodel->get_cities();
		$state = $this->apimodel->get_states();
		$data = [
			"city" => $city,
			"state" => $state
		];
		echo json_encode($data);
	}
	public function get_city($id)
	{
		$this->load->model('apimodel');
		$city = $this->apimodel->get_city($id);
		echo json_encode($city);
	}

	public function add_city()
	{
		$data = json_decode(file_get_contents("php://input"), true);

		$this->load->model('apimodel');
		$insert_id = $this->apimodel->add_city($data);
		echo json_encode(array('insert_id' => $insert_id));
	}

	public function update_city($id)
	{
		$this->load->model('apimodel');
		$data = json_decode(file_get_contents("php://input"), true);
		$affected_rows = $this->apimodel->update_city($id, $data);
		echo json_encode(array('affected_rows' => $affected_rows));
	}

	public function delete_city($id)
	{
		$this->load->model('apimodel');
		$affected_rows = $this->apimodel->delete_city($id);
		echo json_encode(array('affected_rows' => $affected_rows));
	}
	public function delete_hotel_image($id)
	{
		$this->db->where('id', $id);
		$affected_rows = $this->db->update('hotel_media', ["active" => 0]);
		echo json_encode(array('affected_rows' => $affected_rows));
	}
	
	public function get_vendors_list()
    {
        // Step 1: Fetch all user info including segment ID string
        $this->db->select('
            u.id as user_id,
            u.name as user_name,
            u.emailId,
            u.phoneNumber,
            u.accountStatus as accountStatus,
            u.verificationStatus as verificationStatus,
            u.addedOn,
            u.segment as segment_ids,
            up.Designation,
            up.homeAddress,
            up.officeAddress,
            up.Degree,
            up.passoutYear,
            up.yearsOfExperience,
            c.city_name
        ');
        $this->db->from('users u');
        $this->db->join('users_profile up', 'u.id = up.userId', 'left');
        $this->db->join('cities c', 'u.city = c.id', 'left');
        $this->db->where('u.active', 1);
        $this->db->where('u.admin', 0);
        $this->db->group_by('u.id');
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
    
            // Step 2: Fetch all segments in advance to map IDs to names
            $segments_lookup = [];
            $segments_query = $this->db->get('segments');
            foreach ($segments_query->result_array() as $segment) {
                $segments_lookup[$segment['id']] = $segment['segement'];
            }
    
            // Step 3: Replace segment IDs with names for each user
            foreach ($data as &$user) {
                $segment_ids = explode(',', $user['segment_ids']);
                $segment_names = [];
    
                foreach ($segment_ids as $seg_id) {
                    $seg_id = trim($seg_id);
                    if (isset($segments_lookup[$seg_id])) {
                        $segment_names[] = $segments_lookup[$seg_id];
                    }
                }
    
                $user['segment_name'] = implode(', ', $segment_names);
                unset($user['segment_ids']); // Optional: remove raw segment IDs from output
            }
    
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No users found']);
        }
    }


	public function get_onboarding_list() {
            $this->load->model('apimodel');
            
            $data = $this->apimodel->get_onboarding_list();
    
            // Check if the data exists
            if (!empty($data)) {
                // Return the data as JSON
                $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(['status' => 'success', 'data' => $data]));
            } else {
                // No data found
                $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(404)
                    ->set_output(json_encode(['status' => 'error', 'message' => 'No data found']));
            }
        }
        
        public function update_user_admin() {
        header('Content-Type: application/json');
    
        // Get JSON input data
        $data = json_decode(file_get_contents("php://input"), true);
        $data = $_POST;
        // print_r($data);
    
        if (!isset($data['id'])) {
            echo json_encode(['status' => false, 'message' => 'User ID is required']);
            return;
        }
    
        $userId = $data['id'];
    
        // Prepare user data
        $userData = [
            'name'              => $data['user_name'] ?? null,
            'segment'           => $data['segment_name'] ?? null,
            'city'              => $data['city_name'] ?? null,
            'emailId'           => $data['emailId'] ?? null,
            'phoneNumber'       => $data['phoneNumber'] ?? null
        ];
        $userData = array_filter($userData, function ($value) { return $value !== null; });
    
        // Prepare user profile table update data
        $profileData = [
            'Designation'           => $data['designation'] ?? null,
            'homeAddress'           => $data['homeAddress'] ?? null,
            'officeAddress'         => $data['officeAddress'] ?? null,
            'Degree'                => $data['degree'] ?? null,
            'passoutYear'           => $data['passoutYear'] ?? null,
            'yearsOfExperience'     => $data['yearsOfExperience'] ?? null,
            'instagram_url'         => $data['instagram_url'] ?? null,
            'linkedin_url'          => $data['linkedin_url'] ?? null,
            'youtube_url'           => $data['youtube_url'] ?? null,
            'facebook_url'          => $data['facebook_url'] ?? null,
            'website_url'           => $data['website_url'] ?? null,
            'google_map_url'        => $data['google_map_url'] ?? null,
            'alternative_contact'   => $data['alternative_contact'] ?? null
        ];
        $profileData = array_filter($profileData, function ($value) { return $value !== null; });
    
        // Handle image uploads only if images are provided (photos are optional)
        if (isset($_FILES['self_photo']) && !empty($_FILES['self_photo']['name'])) {
            $profileData['self_photo'] = $this->uploadAndCompressImage($_FILES['self_photo'])['imageName'];
        }
    
        if (isset($_FILES['aadhar_photo']) && !empty($_FILES['aadhar_photo']['name'])) {
            $profileData['aadhar_photo'] = $this->uploadAndCompressImage($_FILES['aadhar_photo'])['imageName'];
        }
    
        if (isset($_FILES['clinic_photo']) && !empty($_FILES['clinic_photo']['name'])) {
            $profileData['clinic_photo'] = $this->uploadAndCompressImage($_FILES['clinic_photo'])['imageName'];
        }
    
        if (isset($_FILES['pan_card_photo_front']) && !empty($_FILES['pan_card_photo_front']['name'])) {
            $profileData['pan_card_photo_front'] = $this->uploadAndCompressImage($_FILES['pan_card_photo_front'])['imageName'];
        }
    
        if (isset($_FILES['pan_card_photo_back']) && !empty($_FILES['pan_card_photo_back']['name'])) {
            $profileData['pan_card_photo_back'] = $this->uploadAndCompressImage($_FILES['pan_card_photo_back'])['imageName'];
        }
    
        // Load the model and update user data
        $this->load->model('apimodel');
        $result = $this->apimodel->update_user_and_profile($userId, $userData, $profileData);
    
        if ($result) {
            echo json_encode(['status' => true, 'message' => 'User updated successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to update user']);
        }
    }
    
    public function addSeoPage() {
        $this->load->helper(['url', 'form']);
        $this->load->library('upload');
    
        // Use raw $_POST instead of $this->input->post()
        $data = $_POST;
    
        $img = '';
    
        // Handle image upload
        if (!empty($_FILES['img']['name'])) {
            $config['upload_path'] = './uploads/seo_images/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
            $config['file_name'] = time() . '_' . $_FILES['img']['name'];
    
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
    
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('img')) {
                $imgData = $this->upload->data();
                $img = $imgData['file_name'];
            } else {
                echo json_encode(['status' => false, 'message' => $this->upload->display_errors()]);
                return;
            }
        }
    
        // Check if required fields exist
        $requiredFields = ['name', 'date', 'des', 'status', 'footer_status', 'url'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                echo json_encode(['status' => false, 'message' => "Missing required field: $field"]);
                return;
            }
        }
    
        $insertData = [
            'name' => $data['name'],
            'date' => $data['date'],
            'img' => $img,
            'des' => $data['des'],
            'status' => ($data['status'] === 'active' ? 1 : 0),
            'footer_status' => ($data['footer_status'] === 'yes' ? 1 : 0),
            'url' => $data['url']
        ];
    
        $this->db->insert('seo_page', $insertData);
        echo json_encode(['status' => true, 'message' => 'SEO Page added successfully']);
    }

    public function updateSeoPage($id) {
        $this->load->helper(['url', 'form']);
        $this->load->library('upload');
    
        // Use raw $_POST
        $data = $_POST;
        // print_r($_POST);
    
        // Fetch existing row
        $existing = $this->db->get_where('seo_page', ['id' => $id])->row();
    
        if (!$existing) {
            echo json_encode(['status' => false, 'message' => 'Record not found']);
            return;
        }
    
        // Default image is existing one
        $img = $existing->img;
    
        // If new image is uploaded
        if (!empty($_FILES['img']['name'])) {
            $config['upload_path'] = './uploads/seo_images/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
            $config['file_name'] = time() . '_' . $_FILES['img']['name'];
    
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
    
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('img')) {
                $imgData = $this->upload->data();
                $img = $imgData['file_name'];
            } else {
                echo json_encode(['status' => false, 'message' => $this->upload->display_errors()]);
                return;
            }
        }
    
        // Validate required fields
        $requiredFields = ['name', 'date', 'des', 'status', 'footer_status', 'url'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                echo json_encode(['status' => false, 'message' => "Missing required field: $field"]);
                return;
            }
        }
    
        // Prepare update data
        $updateData = [
            'name' => $data['name'],
            'date' => $data['date'],
            'des' => $data['des'],
            'status' => ($data['status'] == 'active' ? 1 : 0),
            'footer_status' => ($data['footer_status'] == 'yes' ? 1 : 0),
            'url' => $data['url']
        ];
        
        if($img){
            $updateData["img"] = $img;
        }
    
        $this->db->where('id', $id);
        $this->db->update('seo_page', $updateData);
    
        echo json_encode(['status' => true, 'message' => 'SEO Page updated successfully']);
    }
    
    public function getSeoPages() {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        
    
        $this->load->database();
        $id = $this->input->get('id');
    
        if ($id) {
            $query = $this->db->get_where('seo_page', ['id' => $id]);
            $result = $query->row();
            if ($result) {
                echo json_encode(['status' => true, 'data' => $result]);
            } else {
                echo json_encode(['status' => false, 'message' => 'No record found.']);
            }
        } else {
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get('seo_page');
            $result = $query->result();
            echo json_encode(['status' => true, 'data' => $result]);
        }
    }
    
    
    public function addBlog() {
        $this->load->helper(['url', 'form']);
        $this->load->library('upload');
    
        // Use raw $_POST instead of $this->input->post()
        $data = $_POST;
    
        $img = '';
    
        // Handle image upload
        if (!empty($_FILES['img']['name'])) {
            $config['upload_path'] = './uploads/blogs/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
            $config['file_name'] = time() . '_' . $_FILES['img']['name'];
    
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
    
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('img')) {
                $imgData = $this->upload->data();
                $img = $imgData['file_name'];
            } else {
                echo json_encode(['status' => false, 'message' => $this->upload->display_errors()]);
                return;
            }
        }
    
        // Check if required fields exist
        $requiredFields = ['name', 'date', 'des', 'status', 'footer_status', 'url'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                echo json_encode(['status' => false, 'message' => "Missing required field: $field"]);
                return;
            }
        }
    
        $insertData = [
            'name' => $data['name'],
            'date' => $data['date'],
            'img' => $img,
            'des' => $data['des'],
            'status' => ($data['status'] === 'active' ? 1 : 0),
            'footer_status' => ($data['footer_status'] === 'yes' ? 1 : 0),
            'url' => $data['url']
        ];
    
        $this->db->insert('blog', $insertData);
        echo json_encode(['status' => true, 'message' => 'SEO Page added successfully']);
    }

    public function updateBlog($id) {
        $this->load->helper(['url', 'form']);
        $this->load->library('upload');
    
        // Use raw $_POST
        $data = $_POST;
        // print_r($_POST);
    
        // Fetch existing row
        $existing = $this->db->get_where('blog', ['id' => $id])->row();
    
        if (!$existing) {
            echo json_encode(['status' => false, 'message' => 'Record not found']);
            return;
        }
    
        // Default image is existing one
        $img = $existing->img;
    
        // If new image is uploaded
        if (!empty($_FILES['img']['name'])) {
            $config['upload_path'] = './uploads/blogs/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
            $config['file_name'] = time() . '_' . $_FILES['img']['name'];
    
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
    
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('img')) {
                $imgData = $this->upload->data();
                $img = $imgData['file_name'];
            } else {
                echo json_encode(['status' => false, 'message' => $this->upload->display_errors()]);
                return;
            }
        }
    
        // Validate required fields
        $requiredFields = ['name', 'date', 'des', 'status', 'footer_status', 'url'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                echo json_encode(['status' => false, 'message' => "Missing required field: $field"]);
                return;
            }
        }
    
        // Prepare update data
        $updateData = [
            'name' => $data['name'],
            'date' => $data['date'],
            'des' => $data['des'],
            'status' => ($data['status'] == 'active' ? 1 : 0),
            'footer_status' => ($data['footer_status'] == 'yes' ? 1 : 0),
            'url' => $data['url']
        ];
        
        if($img){
            $updateData["img"] = $img;
        }
    
        $this->db->where('id', $id);
        $this->db->update('blog', $updateData);
    
        echo json_encode(['status' => true, 'message' => 'SEO Page updated successfully']);
    }
    
    public function getBlogs() {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        
    
        $this->load->database();
        $id = $this->input->get('id');
    
        if ($id) {
            $query = $this->db->get_where('blog', ['id' => $id]);
            $result = $query->row();
            if ($result) {
                echo json_encode(['status' => true, 'data' => $result]);
            } else {
                echo json_encode(['status' => false, 'message' => 'No record found.']);
            }
        } else {
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get('blog');
            $result = $query->result();
            echo json_encode(['status' => true, 'data' => $result]);
        }
    }


} 


function get_client_ip()
{
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if (getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if (getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if (getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if (getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if (getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}
