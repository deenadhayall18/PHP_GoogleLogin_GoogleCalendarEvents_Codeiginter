<?php 

class Events_model extends CI_Model {
// to echo the query
	// echo $this->db->last_query(); die;

//select
	function getAllEventsFromDb($user){		
		$query  = $this->db->select("*")->from("events")->where("user",$user)->get()->result_array();
		// echo $this->db->last_query(); die;
		return $query;
	}	
// // get
// 	function getAllEventsFromDb(){		
// 		$res = $this->db->get("events")->result_array();
// 		return $res;
// 	}	
//get count 
	function samplecount() {
		return $this->db->count_all("tbl_sample");
	}

//insert 
	function insert_events($data_to_insert){
		$res = $this->db->insert("events",$data_to_insert);
		return $res; 
	}


//delete 
	function clear_user_events($user){
		$res = $this->db->where("user",$user)->delete("events");
		// echo $this->db->last_query(); die;
		return $res;
	}

}
?>