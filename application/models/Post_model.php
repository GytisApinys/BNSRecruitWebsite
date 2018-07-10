<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post_model extends CI_Model {
        public $user_id;
        public $user_nickname;
        public $user_password;
		public $user_email;

        public function get_all_posts()
        {
            $this->db->from('poster');
         //   $this->db->where('creater_name !=',"Akrium");
          //  $this->db->where('raid_name ',"BT");
         //   $this->db->order_by('req_ap', 'ASC');
         //   $this->db->where('req_ap',1000);
            $query = $this->db->get();
           //$query = $this->db->query("SELECT * FROM `poster` WHERE `req_ap` < 1000");

            
            return $query->result();
        }
        public function get_posts_for_char($ap,$crit,$cdmg,$hp,$acc)
            {
                $this->db->where('req_ap <=', $ap);
                $this->db->where('req_crit <=', $crit);
                $this->db->where('req_acc <=', $acc);
                $this->db->where('req_hp <=', $hp);
                $this->db->where('req_crit_dmg <=', $cdmg);
                $this->db->from('poster');
                $query = $this->db->get();
                return $query->result();
                
            }
        public function get_specific_post($id) //?
        {
            $this->db->where("post_id",$id);
            $this->db->from("poster");
            $query = $this->db->get();
            return $query->result();
        }

        public function addpost($entry)
        {
            $this->db->insert('poster',$entry);
        }
        // public function specific_search()
        // {
        //     $this->db->query;
        // }
        public function get_users_posts($id)
        {
            $this->db->from('poster');
            $this->db->where('user_id', $id);
            $query = $this->db->get();
            return $query->result();
            
        }       
         public function get_post_invitation_count($id,$status)
        {
            $this->db->from('room_invitation');
            $this->db->where('room_id', $id);
            $this->db->where('status', $status);
            $query = $this->db->count_all_results();
            return $query;
            
        }
        public function invitations($post_id,$status)
        {
            $this->db->from('room_invitation');
            $this->db->where('room_id', $post_id);
            $this->db->where('status', $status);
            $query = $this->db->get();
            return $query->result();
        }
        public function delete_post($id)
        {
            $this->db->delete('poster', array('post_id' => $id)); 
            $this->db->delete('chat_msg', array('post_id' => $id)); 
            $this->db->delete('room_invitation', array('room_id' => $id)); 
        }
        public function update_inv($update, $id)
        {
            $this->db->update('room_invitation', $update, array('id' => $id));
        }
        public function del_inv($id)
        {
            $this->db->delete('room_invitation', array('id' => $id));
        }
        public function check_inv($char_id,$room_id)
        {
            $this->db->where('char_id',$char_id);
            $this->db->where('room_id',$room_id);
            $this->db->from('room_invitation');
            $query = $this->db->get();
            return $query->result();

        }
        public function create_inv($data)
        {
            $this->db->insert('room_invitation',$data);
        }
        public function get_all_rooms_invitations($post_id)
        {
            $this->db->where('room_id',$post_id);
            $this->db->from('room_invitation');
            $query = $this->db->get();
            return $query->result();
        }
        public function get_chat_msg($room_id)
        {
            $this->db->from('chat_msg');
            $this->db->where('post_id',$room_id);
            $this->db->order_by('time','asc');
            $query = $this->db->get();
            return $query->result();
        }
        public function add_message($data)
        {
                $this->db->insert('chat_msg',$data);
        }
        public function get_users_all_joined_rooms($user_id)
        {
        //  $query = $this->db->query("SELECT * FROM `room_invitation` ri join poster p on ri.room_id = p.post_id where ri.character_user_id = $user_id");
         $query = $this->db->query("SELECT 
         ri.id, 
         ri.room_id, 
         ri.character_user_id, 
         ri.character_name, 
         ri.char_id,
         ri.status, 
         p.post_id,
         p.user_id,
         p.creater_name,
         p.creater_id,
         p.raid_name,
         p.title,
         p.start_date,
         p.start_time 
         FROM room_invitation ri join poster p on ri.room_id = p.post_id where ri.character_user_id = $user_id");
         return $query->result();
        }
}
?>