<?PHP
class CreditModel extends CI_Model {
	function listLandingPartner(){
		$sql = "SELECT * FROM landingpartner WHERE active = 1 ORDER BY name ASC ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function listUserCreditDetails($userId){
		$sql = "SELECT * FROM creditdetails WHERE active = 1 AND userId = '$userId' AND status IN ('active', 'pending') ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}	
}

?>
