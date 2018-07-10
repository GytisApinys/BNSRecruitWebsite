<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {
        public $user_id;
        public $user_nickname;
        public $user_password;
		public $user_email;


        public function get_users_characters($id) 
        {
            $this->db->where("user_id",$id);
            $this->db->from("characters");
            $query = $this->db->get();
            return $query->result();
        }

		public function login($username, $password){
			$this->db->where("user_nickname", $username);
			$this->db->where("user_password", $password);
			$this->db->from("users");
			$query = $this->db->get();
            return $query->result();
		}
		
		public function get_user_by_id($id){
			$this->db->where("user_id", $id);
			$this->db->from("users");
			$query = $this->db->get();
            return $query->result();
        }
		public function get_user_info_by_name($name){
			$this->db->where("user_nickname", $name);
			$this->db->from("users");
			$query = $this->db->get();
            return $query->result();
        }

        // public function gauti_characterio_info($charac_name){
        //     $this->db->where("user_character",$charac_name);
        //     $this->db->from("characters");
        //     $query = $this->db->get();
        //     return $query->result();
        // }

        public function get_characters_info_by_name_and_region($charac_name, $region){
            // $this->db->where("user_character",$charac_name);
            // $this->db->where("region",$region);
            // $this->db->like("Hex(LCASE(user_character))","Hex(LCASE('$charac_name'))");
            // $this->db->from("characters");
            // $query = $this->db->get();
            $query = $this->db->query("SELECT * FROM `characters` 
            WHERE `user_character` = '$charac_name' 
            AND `region` = 'EU' AND Hex(LCASE(user_character)) 
            LIKE Hex(LCASE('$charac_name'))");
            return $query->result();
        }

        public function get_characters_info_by_id($charac_id){
            $this->db->where("id",$charac_id);
            $this->db->from("characters");
            $query = $this->db->get();
            return $query->result();
        }





        public function save_users_info()
        {
            $this->db->insert('users', $this);
        }
        public function save_new_character($info)
        {
            $this->db->insert('characters',$info);
        }


        public function update_user_entry($duomenys, $id)
        {
            $this->db->update('users', $duomenys, array('user_id' => $id));
        }
        public function update_character_entry($duomenys, $id)
        {
            $this->db->update('characters', $duomenys, array('id' => $id));
        }

        public function delete_char_equipment($id)
        {
            $this->db->delete('equipment_character_info', array('character_id' => $id)); 
        }
		
		// public function salinti_vartotoja($id){
		// 	$this->db->delete('users', array('user_id' => $id)); 
        // }
        public function delete_character($id){
			$this->db->delete('characters', array('id' => $id)); 
			$this->db->delete('equipment_character_info', array('character_id' => $id)); 
			$this->db->delete('chat_msg', array('char_id' => $id)); 
			$this->db->delete('poster', array('creater_id' => $id)); 
			$this->db->delete('room_invitation', array('char_id' => $id)); 
        }

//////Store images
        
        public function insert_equiptment($info)
        {
            $this->db->insert('equiptment',$info);
        }
		public function check_if_eqipment_exist($name, $type){
			$this->db->where("name", $name);
			$this->db->where("type", $type);
			$this->db->from("equiptment");
			$query = $this->db->get();
            return $query->result();
        }

///////


        public function insert_char_equiptment_info($info)
        {
            if (!empty($info['name']))
            { 
                $this->db->insert('equipment_character_info',$info);
            }
        }
        public function get_equipment_info_and_image($id)
        {
         /*   $this->db->query("SELECT equipment_character_info.*, equiptment.image  FROM `equipment_character_info`,equiptment 
            where equipment_character_info.name = equiptment.name 
            and equipment_character_info.character_id = $id");*/

            $this->db->select("equipment_character_info.*, equiptment.image");
            $this->db->from('equipment_character_info');
            $this->db->join('equiptment', 'equipment_character_info.name = equiptment.name');
            $this->db->where("equipment_character_info.character_id", $id);

			$query = $this->db->get();
            return $query->result();
            
        }
}
?>