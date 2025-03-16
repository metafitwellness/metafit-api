<?php class CountryCodeModel extends CI_Model
{
	public function get_all_states() {
        $query = $this->db->get('states');
		$this->db->where('states.active', 1);
        
        return $query->result();
    }
    public function get_cities_by_state($state_id) {
        $this->db->select('cities.id, cities.city_name');
        $this->db->from('cities');
        $this->db->where('cities.state_id', $state_id);
		$this->db->where('cities.active', 1);
        $query = $this->db->get();
        return $query->result();
    }
	public function get_all_cities() {
        $this->db->select('*');
        $this->db->from('cities');
        $this->db->where('cities.active', 1);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_all_segements() {
        $this->db->select('*');
        $this->db->from('segments');
        $this->db->where('active', 1);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_all_plans() {
        $this->db->select('*');
        $this->db->from('plans');
        $this->db->where('active', 1);
        $this->db->order_by('onboarding', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
	public function get_all_hotel_categories(){
		$this->db->select('*');
        $this->db->from('hotel_categories');
        $this->db->where('hotel_categories.active', 1);
        $query = $this->db->get();
        return $query->result();
	}
	public function get_all_hotel_type() {
        $this->db->select('*');
        $this->db->from('hotel_type');
        $this->db->where('active', 1);
        $query = $this->db->get();
        return $query->result();
    }
	function listCountryCode()
	{
		$arr = [
			[
				"name" => "India",
				"flag" => "🇮🇳",
				"code" => "IN",
				"dial_code" => "+91",
				"currency" => [
					"code" => "INR",
					"name" => "Indian rupee",
					"symbol" => "₹",
				],
			],
		];
		$arrx["countries"] = $arr;
		$arrx["cities"] = $this->get_all_cities();
		$arrx["segments"] = $this->get_all_segements();
		$arrx["plans"] = $this->get_all_plans();
		return $arrx;
	}
}
