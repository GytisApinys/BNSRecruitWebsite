<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {


    public $user_id;
    public $user_nickname;
    public $user_password;
    public $user_email;
    public $user;


    public function login_affirmation($user_nickname, $user_password)
    {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('user_nickname',$user_nickname);
        $this->db->where('user_password',$user_password);
        $user = $this->db->get();
        return  $user->result();

    }
     public function insert_user()
    {

    };
    public function update_user()
    {

    };
     public function get_all_posts()
    {
        $query = $this->db->get('posts');
        return $query->result();
    };
    public function get_all_post_for_specific()
    {
        $this->db->select();
        $this->db->from('posts');
        

        return $query->result();
    };
           