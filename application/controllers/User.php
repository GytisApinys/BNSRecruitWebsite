<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }
    public function index()
    {
		if(isset($this->session) && $this->session->userdata('loggen_id')>0){
			redirect('bnsrecruit');
		}		
		$rodyti_prisijungimo_forma = false;
		$duomenys_formai = array();
		if(!empty($this->input->post())){
			$login_username = $this->input->post("username");
			$login_password = md5($this->input->post("password"));
			$vartotojas = $this->User_model->login($login_username, $login_password);
			//tikrinam ar gautas vartotojas su toliais loginais
			if(empty($vartotojas)){
				$rodyti_prisijungimo_forma = true;
				$duomenys_formai['login'] = $login_username;
				//password nesetinsiu, nes vis tiek nesimatys
				//dar galima klaidos pranesima perduoti
				$duomenys_formai['klaida'] = "Neteisingi prisijungimo duomenys";
			}
			else{
				$this->session->set_userdata("loggen_id", $vartotojas[0]->user_id);
				$this->session->set_userdata("loggen_nickname", $vartotojas[0]->user_nickname);
				$this->session->set_userdata("character_name", $vartotojas[0]->default_character);
				$this->session->set_userdata("character_id", $vartotojas[0]->default_character_id);
			///	$this->session->set_userdata("character_name", "Casì");
				//redirectinam kazkur ka turi amtyti po login
				redirect("user/profile");
			}
		}else{
			$rodyti_prisijungimo_forma = true;
		}
		if($rodyti_prisijungimo_forma){		
			//vaizduojam login forma
			$this->load->view('bendra/headerbns');
			$this->load->view('user/userLoginFormBNS', $duomenys_formai);
			$this->load->view('bendra/footerbns');
		}
    }
    public function register()
    {
		if(isset($this->session) && $this->session->userdata('loggen_id')>0){
			redirect('bnsrecruit');
		}
		$rodyti_registracijos_forma = false;
		$duomenys_formai = array();
		if(!empty($this->input->post())){	
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[12]|is_unique[users.user_nickname]');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('confirmpassword', 'Password Confirmation', 'required|matches[password]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.user_email]');
			//tikrinam ar visos taisykles tenkinamos
			if($this->form_validation->run() == FALSE){
				$rodyti_registracijos_forma = true;
				$duomenys_formai['login'] = $this->input->post("username");
				$duomenys_formai['pastas'] = $this->input->post("email");
			}
			else{
				//jei geri duomenys - irasom i db
				$this->User_model->user_nickname = $this->input->post("username");
				$this->User_model->user_password = md5($this->input->post("password"));
				$this->User_model->user_email = $this->input->post("email");
				$irasyta = $this->User_model->save_users_info();
				redirect("");
			}
		}else{
			$rodyti_registracijos_forma = true;
		}
		if($rodyti_registracijos_forma){		
			//vaizduojam registracijos forma
			$this->load->view('bendra/headerbns');
			$this->load->view('user/userRegisterFormBNS', $duomenys_formai);
			$this->load->view('bendra/footerbns');
		}				
    } 
	public function logout(){
		$this->session->unset_userdata('loggen_id');
		$this->session->unset_userdata('loggen_nickname');
		//redirectinam i pradini langa
		redirect("");		
	}
	public function profile(){

		redirect("user/characters");
		// $duomenys['prisijunges'] = $this->session->userdata('loggen_nickname');
		// $duomenys['sarasas'] = $this->User_model->gauti_visu_vartotoju_sarasa();
		// $duomenys['characteris'] = 
		// 	$this->User_model->gauti_characterio_info($this->session->userdata('character_name'));
		// $this->load->view('bendra/headerbns');
		// $this->load->view('user/userProfile', $duomenys);
		// $this->load->view('bendra/footerbns');
		
	}
	public function characters(){
		$duomenys['sarasas'] = $this->User_model->get_users_characters($this->session->userdata('loggen_id'));
		$this->load->view('bendra/headerbns');
		$this->load->view('user/userCharacterDisplayBNS', $duomenys);
		$this->load->view('bendra/footerbns');

	}
	public function change($character_id){

		$char_info= $this->User_model->get_characters_info_by_id($character_id);
		$this->session->set_userdata("character_name",$char_info[0]->user_character);
		$this->session->set_userdata("character_id",$character_id);
		$duomenys['default_character']=$char_info[0]->user_character;
		$duomenys['default_character_id']=$character_id;
		$update = $this->User_model->update_user_entry($duomenys,$this->session->userdata('loggen_id'));

		//update DB default character

		$this->load->view('bendra/headerbns');
		$this->load->view('user/userCharacterChange');
		//$this->load->view('bendra/footerbns');

		//redirect('user/characters');

	}
	public function update(){

		$time_of_last_update = time() - $this->session->userdata('update_time');
		$update_delay = 300; //5min
	if($time_of_last_update > $update_delay)
	{
		$allcharacters=$this->User_model->get_users_characters($this->session->userdata('loggen_id'));

		foreach($allcharacters as $character){

			
			$encod = rawurlencode($character->user_character);
			$content = file_get_contents("https://api.silveress.ie/bns/v3/character/full/".$character->region."/".$encod);
			$data =json_decode($content);
			$duomenys['class'] = $data->playerClass;
			$duomenys['charac_ap'] = $data->ap;
			$duomenys['charac_boss_ap'] = $data->ap_boss;
			$duomenys['charac_acc'] = $data->accuracyRate * 100;
			$duomenys['charac_level'] = $data ->playerLevel;
			$duomenys['charac_hmlevel'] = $data ->playerLevelHM;
			$duomenys['charac_hp'] = $data ->hp;
			$duomenys['charac_crit'] = $data ->critRate *100;
			$duomenys['charac_cdamage'] = $data ->critDamageRate * 100;
			$duomenys['image'] = $data ->characterImg;
			$duomenys['flame'] = $data ->flame;
			$duomenys['frost'] = $data ->frost;
			$duomenys['wind'] = $data ->wind;
			$duomenys['earth'] = $data ->earth;
			$duomenys['lightning'] = $data ->lightning;
			$duomenys['shadow'] = $data ->shadow;
			$cid = $character->id;
			$updated=$this->User_model->update_character_entry($duomenys,$cid);

				

					$del = $this->User_model->delete_char_equipment($cid);

					$duomenysEQ2['character_id']=$cid;

						$duomenysEQ2['type']='weapon';
						$duomenysEQ2['name']=$data->weaponName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='necklace';
						$duomenysEQ2['name']=$data->necklaceName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='gloves';
						$duomenysEQ2['name']=$data->gloves;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);

						$duomenysEQ2['type']='ring';
						$duomenysEQ2['name']=$data->ringName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='earing';
						$duomenysEQ2['name']=$data->earringName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);

						$duomenysEQ2['type']='bracelet';
						$duomenysEQ2['name']=$data->braceletName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);

						$duomenysEQ2['type']='belt';
						$duomenysEQ2['name']=$data->beltName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);

						$duomenysEQ2['type']='soul';
						$duomenysEQ2['name']=$data->soulName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='pet';
						$duomenysEQ2['name']=$data->petAuraName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='soul_badge';
						$duomenysEQ2['name']=$data->soulBadgeName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='mystic_badge';
						$duomenysEQ2['name']=$data->mysticBadgeName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='gem1';
						$duomenysEQ2['name']=$data->gem1;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='gem2';
						$duomenysEQ2['name']=$data->gem2;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='gem3';
						$duomenysEQ2['name']=$data->gem3;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='gem4';
						$duomenysEQ2['name']=$data->gem4;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);

						$duomenysEQ2['type']='gem5';
						$duomenysEQ2['name']=$data->gem5;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);

						$duomenysEQ2['type']='gem6';
						$duomenysEQ2['name']=$data->gem6;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);


		}
		
		$this->session->set_userdata('update_time', time());
		$send_to_view['message'] = "Your characters got updated!";
		$this->load->view('bendra/headerbns');
		$this->load->view('user/userCharacterEntryMessage',$send_to_view);



	}else {
		$send_to_view['message'] = "You need to wait 5min between updates";
		$this->load->view('bendra/headerbns');
		$this->load->view('user/userCharacterEntryMessage',$send_to_view);

	}
		
	}

	
	public function addcharacter(){
		//padaryti apsauga nuo URL ivedimo
			$charac_name =  $this->input->post("name");
			$region =  $this->input->post("region");
			$encod = rawurlencode($charac_name);
			$checkup = file_get_contents("http://".$region."-bns.ncsoft.com/ingame/bs/character/data/abilities.json?c=".$encod."");
			$checkup_data =json_decode($checkup);
			if($checkup_data->result == "fail")
			{
				$send_to_view['message'] ="There is no such character.";
				//$send_to_view['message'] = "check_if_already_has = ".$charac_name."";
				
			}else if($checkup_data->result == "success")
			{
				$check_if_already_has = $this->User_model->get_characters_info_by_name_and_region($charac_name,$region); // sita i lygina su ì

					if(empty($check_if_already_has[0]))    // jeigu regionu bus daugiau, reikia keisti
					 
					{
						$content = file_get_contents("https://api.silveress.ie/bns/v3/character/full/".$region."/".$encod);
						$data =json_decode($content);
						$duomenys['class'] = $data->playerClass;
						$duomenys['charac_ap'] = $data->ap;
						$duomenys['charac_boss_ap'] = $data->ap_boss;
						$duomenys['charac_acc'] = $data->accuracyRate * 100;
						$duomenys['charac_level'] = $data ->playerLevel;
						$duomenys['charac_hmlevel'] = $data ->playerLevelHM;
						$duomenys['charac_hp'] = $data ->hp;
						$duomenys['charac_crit'] = $data ->critRate *100;
						$duomenys['charac_cdamage'] = $data ->critDamageRate * 100;
						$duomenys['user_id'] = $this->session->userdata('loggen_id');
						$duomenys['region'] = $region;
						$duomenys['user_character'] = $data->characterName;
						$duomenys['image'] = $data ->characterImg;
						$duomenys['flame'] = $data ->flame;
						$duomenys['frost'] = $data ->frost;
						$duomenys['wind'] = $data ->wind;
						$duomenys['earth'] = $data ->earth;
						$duomenys['lightning'] = $data ->lightning;
						$duomenys['shadow'] = $data ->shadow;

						
						
						$updated=$this->User_model->save_new_character($duomenys);

						$just_added_character=$this->User_model->
								get_characters_info_by_name_and_region($data->characterName, $region);
						$characterID=$just_added_character[0]->id;
			


						$duomenysEQ2['character_id']=$characterID;

						$duomenysEQ2['type']='weapon';
						$duomenysEQ2['name']=$data->weaponName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);

						$duomenysEQ2['type']='necklace';
						$duomenysEQ2['name']=$data->necklaceName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='gloves';
						$duomenysEQ2['name']=$data->gloves;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);

						$duomenysEQ2['type']='ring';
						$duomenysEQ2['name']=$data->ringName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='earing';
						$duomenysEQ2['name']=$data->earringName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);

						$duomenysEQ2['type']='bracelet';
						$duomenysEQ2['name']=$data->braceletName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);

						$duomenysEQ2['type']='belt';
						$duomenysEQ2['name']=$data->beltName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);

						$duomenysEQ2['type']='soul';
						$duomenysEQ2['name']=$data->soulName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='pet';
						$duomenysEQ2['name']=$data->petAuraName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='soul_badge';
						$duomenysEQ2['name']=$data->soulBadgeName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='mystic_badge';
						$duomenysEQ2['name']=$data->mysticBadgeName;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='gem1';
						$duomenysEQ2['name']=$data->gem1;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='gem2';
						$duomenysEQ2['name']=$data->gem2;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='gem3';
						$duomenysEQ2['name']=$data->gem3;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);
						
						$duomenysEQ2['type']='gem4';
						$duomenysEQ2['name']=$data->gem4;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);

						$duomenysEQ2['type']='gem5';
						$duomenysEQ2['name']=$data->gem5;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);

						$duomenysEQ2['type']='gem6';
						$duomenysEQ2['name']=$data->gem6;
						$updated=$this->User_model->insert_char_equiptment_info($duomenysEQ2);







						$send_to_view['message'] = "Your character ".$charac_name." from ".$region." server is saved in your list.";

						//$send_to_view['message'] = "Character ".$charac_name." from ".$check_if_already_has[0]->user_character." server is already in use.";
						
					}else {
						$send_to_view['message'] = "Character ".$charac_name." from ".$region." server is already in use.";
					//	$send_to_view['message'] = " """;

					}
			};
			$this->load->view('bendra/headerbns');
			$this->load->view('user/userCharacterEntryMessage',$send_to_view);
	}
public function delete_character($warning = 't',$char_id){

	$char_info = $this->User_model->get_characters_info_by_id($char_id);
	$char_to_delete_name = $char_info[0]->user_character;

	if(isset($this->session) && $this->session->userdata('loggen_id')==$char_info[0]->user_id){
	
	if($warning == 't'){
		$data['char_id'] = $char_id;
		$data['char_name'] = $char_to_delete_name;
		$this->load->view('bendra/headerbns');
		$this->load->view('user/userCharacterDeleteConfirm',$data);
	}
	if($warning == 'f'){
		
		$this->User_model->delete_character($char_id);
		if($this->session->userdata('character_name') == $char_to_delete_name) {$this->session->unset_userdata('character_name');};
		$send_to_view['message'] = "Your character ".$char_to_delete_name." was deleted.";
		$this->load->view('bendra/headerbns');
		$this->load->view('user/userCharacterEntryMessage',$send_to_view);
	
	}
}else 
{
	redirect('bnsrecruit');
}




}

	public function display($char_id)
		{
			$duomenys['CharData'] = $this->User_model->get_characters_info_by_id($char_id);
			$temp = $this->User_model->get_equipment_info_and_image($char_id);
			
			foreach($temp as $using)
			{
				$duomenys[$using->type]['Name'] = $using->name; 
				$duomenys[$using->type]['Image'] = $using->image; 
			}

			if(!isset($duomenys['weapon']['Name'])) 
			{
				$duomenys['weapon']['Name'] = 'Weapon'; 
				$duomenys['weapon']['Image'] = base_url()."images/no-item.png"; 
			}
			if(!isset($duomenys['ring']['Name'])) 
			{
				$duomenys['ring']['Name'] = 'Ring'; 
				$duomenys['ring']['Image'] = base_url()."images/no-item.png"; 
			}
			if(!isset($duomenys['earing']['Name'])) 
			{
				$duomenys['earing']['Name'] = 'Earing'; 
				$duomenys['earing']['Image'] = base_url()."images/no-item.png"; 
			}
			if(!isset($duomenys['necklace']['Name'])) 
			{
				$duomenys['necklace']['Name'] = 'Necklace'; 
				$duomenys['necklace']['Image'] = base_url()."images/no-item.png"; 
			}
			if(!isset($duomenys['bracelet']['Name'])) 
			{
				$duomenys['bracelet']['Name'] = 'Bracelet'; 
				$duomenys['bracelet']['Image'] = base_url()."images/no-item.png"; 
			}
			if(!isset($duomenys['belt']['Name'])) 
			{
				$duomenys['belt']['Name'] = 'Belt'; 
				$duomenys['belt']['Image'] = base_url()."images/no-item.png"; 
			}
			if(!isset($duomenys['gloves']['Name'])) 
			{
				$duomenys['gloves']['Name'] = 'Gloves'; 
				$duomenys['gloves']['Image'] = base_url()."images/no-item.png"; 
			}
			if(!isset($duomenys['soul']['Name'])) 
			{
				$duomenys['soul']['Name'] = 'Soul'; 
				$duomenys['soul']['Image'] = base_url()."images/no-item.png"; 
			}
			if(!isset($duomenys['pet']['Name'])) 
			{
				$duomenys['pet']['Name'] = 'Pet'; 
				$duomenys['pet']['Image'] = base_url()."images/no-item.png"; 
			}
			if(!isset($duomenys['soul_badge']['Name'])) 
			{
				$duomenys['soul_badge']['Name'] = 'Soul Badge'; 
				$duomenys['soul_badge']['Image'] = base_url()."images/no-item.png"; 
			}
			if(!isset($duomenys['mystic_badge']['Name'])) 
			{
				$duomenys['mystic_badge']['Name'] = 'Mystic Badge'; 
				$duomenys['mystic_badge']['Image'] = base_url()."images/no-item.png"; 
			}

			$this->load->view('bendra/headerbns');
			$this->load->view('user/userCharacterPage', $duomenys);
			$this->load->view('bendra/footerbns');

		}
		public function equpdate()
		{
			$k=0;
			$total=0;
			$content = file_get_contents("https://api.silveress.ie/bns/v3/equipment");
			$data =json_decode($content);
			foreach($data as $data_image)
			{
				$check=$this->User_model->check_if_eqipment_exist($data_image->name, $data_image->type);
				if(empty($check)){
				$duomenys['type'] = $data_image->type;
				$duomenys['name'] = $data_image->name;
				$duomenys['image'] = $data_image->img;
				$added = $this->User_model->insert_equiptment($duomenys);
				$k++;
				};
				$total++;
				
			}
			$send_to_view['message'] = "Total entries: $total // Updates: $k";
			$this->load->view('bendra/headerbns');
			$this->load->view('user/userCharacterEntryMessage',$send_to_view);
		}
}
?>