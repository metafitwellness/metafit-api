<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Allow headers for OPTIONS request
    header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow specific methods
    header("Access-Control-Allow-Headers: *"); // Allow headers
    header("Content-Type: application/json"); // Set response content type to JSON
    http_response_code(200); // Respond with 200 OK to OPTIONS request
    exit();
}

// Set headers for actual request
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow specific methods
header("Access-Control-Allow-Headers: *"); // Allow headers
header("Content-Type: application/json"); // Set response content type to JSON


class Subscribe extends CI_Controller
{
	public function add_subscription()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		if (isset($_POST["userId"]) && !empty($_POST["userId"])) {

			$userId = $this->input->post('userId', true);

			$existing_subscription = $this->db->get_where('subscriptions', ['userId' => $userId])->row_array();

			if ($existing_subscription) {
				$data = $existing_subscription;
				$data['rzp_key'] = rzp_key;
			} else {
				$key_id = rzp_key;
				$key_secret = rzp_secret;
				$url = 'https://api.razorpay.com/v1/subscriptions';
				$data = [
    				'plan_id' => isTest ? 'plan_Q5YAauJm2trWDb' : 'plan_Q5YBVwsJyncec4',
					'total_count' => 240,
					'quantity' => 1,
					'customer_notify' => 1,
					'notes' => [
						'userId' => $userId,
					],
					"notify_info" => [
						"notify_phone" => $this->input->post('phoneNo', true)
					]
				];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
				curl_setopt($ch, CURLOPT_HTTPHEADER, [
					'Content-Type: application/json',
				]);
				curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
				$response = curl_exec($ch);
				// print_r($response);
				if ($response === FALSE) {
					die('Curl failed: ' . curl_error($ch));
				}
				curl_close($ch);
				$response_data = json_decode($response, true);
				// print_r($response_data);

				$data = [
					'id' => $response_data['id'],
					'userId' => $userId,
					'planId' => $response_data['plan_id'],
					'subscriptionId' => $response_data['id'],
					'status' => $response_data['status'],
					'current_start' => $response_data['current_start'],
					'current_end' => $response_data['current_end'],
					'auth_attempts' => $response_data['auth_attempts'],
					'total_count' => $response_data['total_count'],
					'paid_count' => $response_data['paid_count'],
					'remaining_count' => $response_data['remaining_count'],
					'short_url' => $response_data['short_url'],
					'dateAdded' => date("Y-m-d H:i:s"),
					'active' => 1
				];
				$this->db->insert('subscriptions', $data);
				$data['id'] = $this->db->insert_id();
				$data['rzp_key'] = rzp_key;
			}
			header('Status: 200');
			$return = array("status" => "200", "data" => $data);
			echo json_encode($return);
		} else {
			header('Status: 403');
			$return = array("status" => "403", "data" => 'not allowed');
			echo json_encode($return);
		}
	}
	function update_subscription()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["subscriptionId"]) && !empty($_POST["subscriptionId"])) {
			$userId = $this->input->post('userId', true);
			$subscription_id = $this->input->post('subscriptionId', true);
			$paymentId = $this->input->post('paymentId', true);
			$status = $this->input->post('status', true);

			$existing_subscription = $this->db->get_where('subscriptions', ['userId' => $userId, 'subscriptionId' => $subscription_id])->row_array();
			if ($existing_subscription && $status === 'active') {
				$data = [
					'status' => $status,
					'paymentId' => $paymentId,
				];
				$this->db->where('id', $existing_subscription['id']);
				$this->db->update('subscriptions', $data);

				$datax = [
					'accountStatus' => 'active',
					'status' => 0,
					'isSubscribed' => 1
				];

				$userId = $existing_subscription['userId'];
				$this->db->where('id', $userId);
				$this->db->update('users', $datax);

				$userData = $this->db->get_where('users', ['id' => $userId])->row_array();
				unset($userData["password"]);
				header('Status: 200');
				$return = array("status" => "200", "data" => $userData);
				echo json_encode($return);
			} else {
				header('Status: 200');
				$return = array("status" => "200", "data" => null, "message" => "Payment not processed, If amount was debited please contact customer service.");
				echo json_encode($return);
			}
		} else {
			header('Status: 403');
			$return = array("status" => "403", "data" => 'not allowed');
			echo json_encode($return);
		}
	}

	public function verify_subscription()
	{
		if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["subscriptionId"]) && !empty($_POST["subscriptionId"])) {

			$userId = $this->input->post('userId', true);
			$subscriptionId = $this->input->post('subscriptionId', true);

			$existing_subscription = $this->db->get_where('subscriptions', ['userId' => $userId, 'subscriptionId' => $subscriptionId])->row_array();

			$key_id = rzp_key;
			$key_secret = rzp_secret;
			$url = 'https://api.razorpay.com/v1/subscriptions/' . $subscriptionId;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'Content-Type: application/json',
			]);
			curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
			$response = curl_exec($ch);
			if ($response === FALSE) {
				die('Curl failed: ' . curl_error($ch));
			}
			curl_close($ch);
			$response_data = json_decode($response, true);

			$data = [
				'id' => $response_data['id'],
				'userId' => $userId,
				'planId' => $response_data['plan_id'],
				'subscriptionId' => $response_data['id'],
				'status' => $response_data['status'],
				'current_start' => $response_data['current_start'],
				'current_end' => $response_data['current_end'],
				'auth_attempts' => $response_data['auth_attempts'],
				'total_count' => $response_data['total_count'],
				'paid_count' => $response_data['paid_count'],
				'remaining_count' => $response_data['remaining_count'],
				'short_url' => $response_data['short_url'],
				'dateAdded' => date("Y-m-d H:i:s"),
				'active' => 1
			];
		}
		header('Status: 200');
		$return = array("status" => "200", "data" => $data);
		echo json_encode($return);
	}
	
	
	public function add_onboarding_order()
    {
        if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
            $_POST = json_decode(file_get_contents("php://input"), true);
        }

        if (isset($_POST["userId"]) && !empty($_POST["userId"]) && isset($_POST["planId"]) && !empty($_POST["planId"])) {
            $userId = $this->input->post('userId', true);
            $planId = $this->input->post('planId', true);
    
            $this->db->select('onboarding');  // Adjust this if you're using 'monthly' or another field for the amount
            $this->db->from('plans');
            $this->db->where('id', $planId);  // Filter by planId
            $this->db->where('active', 1);    // Only consider active plans
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $plan = $query->row();
                $amount = $plan->onboarding; 
            }else{
                header('Status: 403');
                $return = array("status" => "403", "data" => 'Invalid input');
                echo json_encode($return);
            }

            // Check if there's an existing onboarding entry
            $existing_onboarding = $this->db->get_where('onboardings', ['userId' => $userId, 'planId' => $planId])->row_array();

            if ($existing_onboarding) {
                // Mark previous onboarding as inactive
                $this->db->update('onboardings', ['active' => 0], ['userId' => $userId, 'planId' => $planId]);

                // Prepare new onboarding data
                $status = 'created'; // Initial status for the new onboarding
            } else {
                // New onboarding entry, status created
                $status = 'created';
            }

            // Call Razorpay API to create the order
            $key_id = rzp_key;
            $key_secret = rzp_secret;
            $url = 'https://api.razorpay.com/v1/orders';
            
            $amount = $amount * 100;
            
            $data = [
                'amount' => $amount,  // The amount in smallest unit (like paise for INR)
                'currency' => 'INR',
                'notes' => json_encode([
                    'userId' => $userId,
                    'planId' => $planId
                ]),
                'receipt' => 'order_' . $userId .'_'. rand(),
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
            $response = curl_exec($ch);

            if ($response === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            curl_close($ch);
            $response_data = json_decode($response, true);

            $orderData = [
                'userId' => $userId,
                'planId' => $planId,
                'amount' => $amount,
                'rzp_orderId' => $response_data['id'],
                'status' => $status,
                'active' => 1,
                'dateAdded' => date("Y-m-d H:i:s")
            ];

            // Insert new onboarding order into the database
            $this->db->insert('onboardings', $orderData);
            $orderData['id'] = $this->db->insert_id();
            
            
            $orderData['rzp_key'] = rzp_key;

            $return = array("status" => "200", "data" => $orderData);
            echo json_encode($return);

        } else {
            header('Status: 403');
            $return = array("status" => "403", "data" => 'Invalid input');
            echo json_encode($return);
        }
    }

    public function verify_onboarding_payment()
    {
        if (stripos($_SERVER["CONTENT_TYPE"], "application/json") == 0) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}
		
        $razorpay_payment_id = $this->input->post('paymentId', true);
        $razorpay_order_id = $this->input->post('orderId', true);
        $razorpay_signature = $this->input->post('signature', true);
        $userId = $this->input->post('userId', true);

        // Retrieve secret key (use your Razorpay secret key here)
        $key_secret = rzp_secret;

        // Generate the HMAC signature
        $generated_signature = hash_hmac('sha256', $razorpay_order_id . "|" . $razorpay_payment_id, $key_secret);
        // Verify the signature
        if ($generated_signature == $razorpay_signature) {
            // Payment is successful, update payment details in the database

            // Update the payment status in the onboardings table
            $updateData = [
                'rzp_paymentId' => $razorpay_payment_id,
                'rzp_signature' => $razorpay_signature,
                'status' => 'active'
            ];

            // Update the onboarding entry with the userId and rzp_orderId
            $this->db->update('onboardings', $updateData, ['rzp_orderId' => $razorpay_order_id]);
            
            $data = [
                'accountStatus' => 'onboarded'
            ];
            
            $this->db->update('users', $data, ['id' => $userId]);
            
            // Send success response
            $return = array("status" => "200", "data" => $_POST);
            echo json_encode($return);

        } else {
            // Invalid signature, payment failed
            header('Status: 400');
            $return = array("status" => "400", "data" => 'Invalid signature');
            echo json_encode($return);
        }
    }
}
