<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Poster extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('Post_model');
        $this->load->model('User_model');
    }
    public function index($type = 'all')
    {
        if(isset($this->session) && $this->session->userdata('loggen_id')>0)
        {
            if($type == 'all')
            {
                 $data['poster_list'] = $this->Post_model->get_all_posts();
                 $data['type'] = 'all';
            }else if($type == "specific"){
                $char_info = $this->User_model->get_characters_info_by_id($this->session->userdata("character_id"));
                $ap=$char_info[0]->charac_boss_ap;
                $crit=$char_info[0]->charac_crit;
                $cdmg=$char_info[0]->charac_cdamage;
                $hp=$char_info[0]->charac_hp;
                $acc=$char_info[0]->charac_acc;
                $data['poster_list'] =  $this->Post_model->get_posts_for_char($ap,$crit,$cdmg,$hp,$acc);
                $data['type'] = 'specific';
            }
           
            $this->load->view('bendra/headerbns');
            $this->load->view('posts/postAllView',$data);
        }else 
        {
            redirect('user');
        }



    }

    public function write_new()
    {
        $show_form = true;
        if(empty($this->session->userdata("character_name")))
        {
            $send_to_view['message'] = "You can't create group post without setting main character. Do so in characters manager.";
            $this->load->view('bendra/headerbns');
            $this->load->view('user/userCharacterEntryMessage',$send_to_view);
           
        }else if(isset($this->session) && $this->session->userdata('loggen_id')>0)
        {
            $this->load->view('bendra/headerbns');
            $this->load->view('posts/createpost');
        }else 
        {
            redirect('user');
        }

	//	$this->load->view('bendra/footerbns');
    }

    public function add_post()
    {
        $poster_data['user_id']=  $this->session->userdata('loggen_id');
        $poster_data['creater_name']= $this->session->userdata('character_name');
        $poster_data['creater_id']= $this->session->userdata('character_id');
        $poster_data['raid_name']=  $this->input->post("raid_name");
        $poster_data['req_ap']=  $this->input->post("ap");
        $poster_data['req_acc']=  $this->input->post("acc");
        $poster_data['req_crit']=  $this->input->post("c_rate");
        $poster_data['req_crit_dmg']=  $this->input->post("c_dmg");
        $poster_data['req_hp']=  $this->input->post("hp");
        $poster_data['text']=  $this->input->post("message");
        $poster_data['title']=  $this->input->post("title");
        $poster_data['start_time']=  $this->input->post("start_time");
        $poster_data['start_date']=  $this->input->post("start_date");
        $poster_data['status']=  'Pending';
        if (!empty($this->input->post("copy"))) {
            $poster_data['email_notification'] = 'True';
        }else {$poster_data['email_notification'] = 'False';}

        $this->Post_model->addpost($poster_data);
   

        
        $send_to_view['message'] = "Your post was added!";
        $send_to_view['where_to_go'] = "post_manager";
        $this->load->view('bendra/headerbns');
        $this->load->view('posts/postEntryMessage',$send_to_view);
        // $send_to_view['message'] = "Total entries: $total // Updates: $k";
        // $this->load->view('bendra/headerbns');
        // $this->load->view('user/userCharacterEntryMessage',$send_to_view);
       
    }
    public function post_review($post_id)
    {
        $data['raid_info']= $this->Post_model->get_specific_post($post_id);
        $data['invitations']= $this->Post_model->get_all_rooms_invitations($post_id);

        $check_power = $this->Post_model->check_inv($this->session->userdata('character_id'), $post_id);
        // print_r($check_power);
        // die();
        if (empty($check_power[0])) {$data['viewer_status'] = 'view';}
       else if ($check_power[0]->status == 1) {$data['viewer_status'] = 'in the raid';}
       else if ($check_power[0]->status == 2) {$data['viewer_status'] = 'waiting for approval';}

                print_r($data['viewer_status']);
    
        $this->load->view('bendra/headerbns');
		$this->load->view('posts/reviewpost',$data);
		$this->load->view('bendra/footerbns');
    }
    public function post_manager($show = 'created')
    {
        if($this->session->userdata('loggen_id')<=0)
        {
            redirect("user");
        }

        if($show == 'created'){
                $data['users_posts']= $this->Post_model->get_users_posts($this->session->userdata('loggen_id'));
                $temp = $this->Post_model->get_users_posts($this->session->userdata('loggen_id'));
                $data['view_mode'] = 'created';
                foreach($temp as $temp2)
                {
                    $data['status'][$temp2->post_id]['invited'] = $this->Post_model->get_post_invitation_count($temp2->post_id,1);
                    $data['status'][$temp2->post_id]['waiting'] = $this->Post_model->get_post_invitation_count($temp2->post_id,2);
                }
        }else if($show == 'joined')
        {
            $data['users_posts'] = $this->Post_model->get_users_all_joined_rooms($this->session->userdata('loggen_id'));
            $data['view_mode'] = 'joined';

            foreach( $data['users_posts'] as $temp2)
            {
                $data['status_of_invite'][$temp2->post_id]['invited'] = $this->Post_model->get_post_invitation_count($temp2->post_id,1);
            }

        }
       

        $this->load->view('bendra/headerbns');
		$this->load->view('posts/personal_post_list', $data);
		$this->load->view('bendra/footerbns');
    }


    public function delete_post($warning = 't',$post_id)
    {
        
	$post_info = $this->Post_model->get_specific_post($post_id);
    $post_to_delete_title= $post_info[0]->title;
    echo $warning;
    if(isset($this->session) && $this->session->userdata('loggen_id')==$post_info[0]->user_id){
	
        if($warning == 't'){
            $data['post_id'] = $post_id;
            $data['post_title'] = $post_to_delete_title;
            $this->load->view('bendra/headerbns');
            $this->load->view('posts/postDeleteConfirm',$data);
        }
        if($warning == 'f'){
            
            $this->Post_model->delete_post($post_id);
            $send_to_view['message'] = "Your ".$post_to_delete_title." post was deleted.";
            $send_to_view['where_to_go'] = "post_manager";
            $this->load->view('bendra/headerbns');
            $this->load->view('posts/postEntryMessage',$send_to_view);
        
        }
    }else 
    {
        redirect('bnsrecruit');
    }

    }

    public function raid_apply($post_id)
    {
         $post_info = $this->Post_model->get_specific_post($post_id);
            if($post_info[0]->user_id == $this->session->userdata('loggen_id'))
            {
                $data['inv']=$this->Post_model->invitations($post_id,2);
                $check = $this->Post_model->get_post_invitation_count($post_id,2);
                if($check==0) 
                {
                    redirect('poster/post_manager');
                }
                else
                { 
                    $data['title']=$post_info[0]->title;
                    $this->load->view('bendra/headerbns');
                    $this->load->view('posts/postApplyReq',$data);
                    $this->load->view('bendra/footerbns');
                }
                
               
            }else redirect('bnsrecruit');
        
    }
    public function invite($post_id,$inv_id)
    {
        $post_info = $this->Post_model->get_specific_post($post_id);
        
        if($post_info[0]->user_id == $this->session->userdata('loggen_id'))
            {
                $update_status['status'] = 1;
                $update_inv= $this->Post_model->update_inv($update_status,$inv_id);

                $data['inv']=$this->Post_model->invitations($post_id,2);
                $check = $this->Post_model->get_post_invitation_count($post_id,2);
                if($check==0)  redirect('poster/post_manager');
                
                $data['title']=$post_info[0]->title;
                $this->load->view('bendra/headerbns');
                $this->load->view('posts/postApplyReq',$data);
                $this->load->view('bendra/footerbns');
            }else redirect('bnsrecruit');
    }
    public function delete_inv($post_id,$inv_id)
    {
        $post_info = $this->Post_model->get_specific_post($post_id);
        
        if($post_info[0]->user_id == $this->session->userdata('loggen_id'))
            {
                $update_inv= $this->Post_model->del_inv($inv_id);
                $data['inv']=$this->Post_model->invitations($post_id,2);
                $check = $this->Post_model->get_post_invitation_count($post_id,2);
                if($check==0)  redirect('poster/post_manager');
                
                $data['title']=$post_info[0]->title;
                $this->load->view('bendra/headerbns');
                $this->load->view('posts/postApplyReq',$data);
                $this->load->view('bendra/footerbns');
            }else redirect('bnsrecruit');
    }
    public function apply($post_id)
    {
        $character_id = $this->session->userdata("character_id");
        $check_if_is = $this->Post_model->check_inv($character_id,$post_id);

        if(empty($check_if_is) 
            || $check_if_is[0]->character_user_id != $this->session->userdata("loggen_id") )
            {
                $duomenys['room_id'] = $post_id;
                $duomenys['character_user_id'] =  $this->session->userdata("loggen_id");
                $duomenys['character_name'] = $this->session->userdata("character_name");
                $duomenys['char_id'] = $character_id ;
                $duomenys['status'] = 2;
                $add=$this->Post_model->create_inv($duomenys);
                  $send_to_view['message'] = "You asked to join a room. Wait to be accepted";
                

            }else if($check_if_is[0]->status == 2  
            || $check_if_is[0]->character_user_id != $this->session->userdata("loggen_id"))  
            {
                $send_to_view['message'] = "You already asked to join or this is your raid.";
            }else if($check_if_is[0]->status == 1  
            || $check_if_is[0]->character_user_id != $this->session->userdata("loggen_id"))  
            {
                $send_to_view['message'] = "You already in this raid";
            }
            $send_to_view['where_to_go'] = "post_manager";
            $this->load->view('bendra/headerbns');
            $this->load->view('posts/postEntryMessage',$send_to_view);
     }
     public function chatroom($post_id)
     {
         $open_chat_room = false;
         $user_id = $this->session->userdata('loggen_id');
         $character_id = $this->session->userdata('character_id');
         $data['raid_info']= $this->Post_model->get_specific_post($post_id);
         $data['messages'] = $this->Post_model->get_chat_msg($post_id);

         $check_if_is = $this->Post_model->check_inv($character_id,$post_id);
         if($data['raid_info'][0]->creater_id == $character_id) 
            {
             $open_chat_room = true;
            }
        else if(empty($check_if_is) || $check_if_is[0]->status == 2)
         {
             redirect('poster/post_manager');
         }else if ($check_if_is[0]->status == 1)
         {
             $open_chat_room = true; 
         }

         if($open_chat_room == true)
         {
            $data['raid_info']= $this->Post_model->get_specific_post($post_id);
            $data['messages'] = $this->Post_model->get_chat_msg($post_id);
            // print_r($data);
            // die();
            $this->load->view('bendra/headerbns');
            $this->load->view('posts/postChatroom',$data);

         }
           
         

     }
     public function message($post_id)
     {
        $char_info = $this->User_model->get_characters_info_by_id($this->session->userdata('character_id'));
        $message =  $this->input->post("zinute");

        if(!empty($message))
        {
        $data['post_id'] = $post_id;
        $data['character_name'] = $char_info[0]->user_character;
        $data['char_id'] =$this->session->userdata('character_id');
        $data['time'] = date("Y-m-d H:i:s");
        $data['msg'] = $message;

        $this->Post_model->add_message($data);
        }

       // echo "Laikinai - irasyta";
        
     }
     public function chat_display($post_id)
     {
         
        $open_chat_room = true;
        if($open_chat_room == true)
        {
           $data['raid_info']= $this->Post_model->get_specific_post($post_id);
           $data['messages'] = $this->Post_model->get_chat_msg($post_id);
           // print_r($data);
           // die();
           $this->load->view('posts/chatboxm',$data);
        }
    }
    public function delete_invitation($inv_id)
         {
            $update_inv= $this->Post_model->del_inv($inv_id);
            redirect("poster/post_manager/joined");
         }
     
}
   
