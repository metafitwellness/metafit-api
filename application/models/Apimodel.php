<?PHP
class ApiModel extends CI_Model
{
	function listInvoice($userId = null, $invoiceId = null)
	{
		if ($userId && $userId != null) {
			$users = " AND i.customerId = '$userId' ";
		} else {
			$users = '';
		}
		if ($invoiceId && $invoiceId != null) {
			$invoice = " AND i.referenceNo = '$invoiceId' ";
		} else {
			$invoice = '';
		}
		$sql = "SELECT i.*, u.name, u.currency FROM invoice i JOIN users u on u.id = i.customerId WHERE i.active = 1 $users $invoice ORDER BY i.id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function listTempUsers($userId = null)
	{
		if ($userId && $userId != null) {
			$users = " AND id = '$userId' LIMIT 1 ";
		} else {
			$users = '';
		}
		$sql = "SELECT * FROM `tempusers` WHERE status IN ('verified', 'registered') AND active = 1 $users";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function listUser()
	{
		$this->db->where('status', '1');
		$this->db->where('active', '1');
		$this->db->order_by("name asc");
		$query = $this->db->get('users');
		return $query->result_array();
	}
	function getUserData($id)
	{
        $this->db->select('
            u.id as id, 
            u.name as name, 
            u.emailId, 
            u.phoneNumber, 
            u.firstLogin, 
            u.isSubscribed, 
            u.admin, 
            u.referral, 
            u.addedOn, 
            u.updatedOn, 
            u.deletedOn, 
            u.status as user_status, 
            u.accountStatus, 
            u.onboardingAmount, 
            u.planId, 
            u.otp, 
            u.verificationStatus, 
            u.verificationRemark, 
            u.active as user_active,
            up.Designation, 
            up.homeAddress, 
            up.officeAddress, 
            up.Degree, 
            up.passoutYear, 
            up.yearsOfExperience, 
            up.self_photo, 
            up.aadhar_photo, 
            up.clinic_photo, 
            up.achievements, 
            up.pan_card_photo_front, 
            up.pan_card_photo_back, 
            up.bank_name, 
            up.bank_ac, 
            up.bank_ifsc, 
            up.instagram_url, 
            up.linkedin_url, 
            up.youtube_url, 
            up.facebook_url, 
            up.website_url, 
            up.google_map_url, 
            up.alternative_contact,
            c.city_name, 
            s.segement as segment_name
        ');
        
        // Tables and Joins
        $this->db->from('users u');
        $this->db->join('users_profile up', 'u.id = up.userId', 'left');
        $this->db->join('cities c', 'u.city = c.id', 'left');
        $this->db->join('segments s', 'u.segment = s.id', 'left');
        $this->db->where('u.id', $id);  // Assuming $id is passed as the user ID (e.g., 20)
        $this->db->where('u.active', 1);  // Ensure the user is active
        $this->db->limit(1);  // Only one result is needed
        $query = $this->db->get();
        return $row = $query->row();  // Fetch the
	}
	public function get_subscriptions_by_user($userId)
	{
		$this->db->select('*');
		$this->db->from('subscriptions');
		$this->db->where('userId', $userId);
		$this->db->order_by('dateAdded', 'DESC');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return [];
		}
	}
	public function get_subscriptions_all()
	{
		$this->db->select('subscriptions.*, users.name');
		$this->db->from('subscriptions');
		$this->db->join('users', 'subscriptions.userId = users.id', 'left');
		$this->db->order_by('dateAdded', 'DESC');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return [];
		}
	}
	public function get_cities()
	{
		$query = $this->db->get('cities');
		return $query->result();
	}
	public function get_segments()
	{
		$query = $this->db->where('active', 1)->get('segments');
		return $query->result();
	}
	public function get_plans()
	{
		$query = $this->db->where('active', 1)->get('plans');
		return $query->result();
	}
	public function get_states()
	{
		$query = $this->db->get('states');
		return $query->result();
	}
	public function get_city($id)
	{
		$query = $this->db->get_where('cities', array('id' => $id));
		return $query->row();
	}
	public function add_city($data)
	{
		$this->db->insert('cities', $data);
		return $this->db->insert_id();
	}
	public function update_city($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('cities', $data);
		return $this->db->affected_rows();
	}
	public function delete_city($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('cities');
		return $this->db->affected_rows();
	}


	function sendOtp($phone, $otp) {
	    $url = 'https://api.gupshup.io/wa/api/v1/template/msg';

        // API headers
        $headers = [
            'Cache-Control: no-cache',
            'Content-Type: application/x-www-form-urlencoded',
            'apikey: km0kpg1p0tiqy0rp4siszchvn1vkxwz0',
            'cache-control: no-cache'
        ];
        
        // Request data (same as the -d parameter in the curl request)
        $data = [
            'channel' => 'whatsapp',
            'source' => '919982498555',
            'destination' => '91'.$phone, // Replace with actual phone number
            'src.name' => 'MetafitWellness',
            'template' => json_encode([
                'id' => '45937d18-3d8c-4959-bfc7-1632294427c0',
                'params' => [$otp] // Array with parameters
            ])
        ];
        
        // Initialize cURL session
        $ch = curl_init();
        
        // Set the cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        
        // Execute the request and capture the response
        $response = curl_exec($ch);
        
        // Check for errors
        if(curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Print response (or handle it as needed)
            // echo $response;
        }
        
        // Close the cURL session
        curl_close($ch);
	}
	
    public function add_segment($data) {
        return $this->db->insert('segments', $data);
    }
    
    // Update a segment
    public function update_segment($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('segments', $data);
    }
    public function get_onboarding_list() {
        $this->db->select('
        o.id, o.amount, o.rzp_orderId, o.rzp_paymentId, o.dateAdded, o.status, u.name,
        u.phoneNumber, u.accountStatus, p.plan, p.description');
        $this->db->from('onboardings o');
        $this->db->join('users u', 'u.id = o.userId', 'left');    // Join with users to get user details
        $this->db->join('plans p', 'p.id = o.planId', 'left');     // Join with plans to get plan details
        $this->db->join('segments s', 's.id = u.segment', 'left'); // Join with segments to get the segment details
        $this->db->where('o.active', 1);                           // Only active onboardings
        $this->db->order_by('o.id', 'DESC');  
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function update_user_and_profile($userId, $userData, $profileData) {
        $this->db->trans_start();
        if (!empty($userData)) {
            $this->db->where('id', $userId);
            $this->db->update('users', $userData);
        }
        if (!empty($profileData)) {
            $this->db->where('userId', $userId);
            $this->db->update('users_profile', $profileData);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
