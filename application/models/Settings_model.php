<?php 

class Settings_model extends CI_Model{

	const MAIN_TABLE = "tb_settings";

    function __construct() {
        
        //$this->tableName = 'user_account'; 
        $this->load->database();

    }


    public function get_settings($name) {

        $this->db->select("value");

        $query = $this->db->get_where(self::MAIN_TABLE, array('name' => $name));

        return $query->row_array()['value'];

    }



}

?>