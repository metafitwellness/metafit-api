<?PHP
class KycModel extends CI_Model {
	function listKycDocument(){
		$sql = "SELECT * FROM kycdocuments WHERE active = 1 ORDER BY orderBy ASC ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function listUserKycDocument($userId){
		$sql = "SELECT * FROM kycdata WHERE active = 1 AND userId = '$userId' GROUP BY documentId ORDER BY id ASC ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}	
}

?>
