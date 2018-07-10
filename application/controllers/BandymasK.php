<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class BandymasK extends CI_Controller {

	public function index($kintamasis = "Destroyer Casi")
	{
		//$this->session->set_userdata('Userio_vardas1','AntrasBandymas');	
	
		$content = file_get_contents("https://api.silveress.ie/bns/v3/character/full/eu/".$kintamasis);
		$data =json_decode($content);
		$class = $data ->playerClass;
		$ap = $data ->ap;
		$character_name = $data ->characterName;
		$gemcount=6;
		if($data ->gem1 == null) $gemcount--;
		if($data ->gem2 == null) $gemcount--;
		if($data ->gem3 == null) $gemcount--;
		if($data ->gem4 == null) $gemcount--;
		if($data ->gem5 == null) $gemcount--;
		if($data ->gem6 == null) $gemcount--;
		$crate = $data->critRate*100;
		echo "$character_name's class is $class";
		echo "<br>";
		echo "He has $ap Attack power with $gemcount gems";
		echo "<br>";
		echo "Critical rate $crate%";

		//$this->load->view('headerbns');
		//$this->load->view('bodyBNS');
		//$this->load->view('footerbns');


		$this->session->set_userdata('SesijosRefreshas', 15);
		echo "<br>";
		echo "<pre>";
		print_r($_SESSION); 
		echo "<pre>";
		echo "<br>";


		
		/*echo "<pre>";
		 print_r($data);
		 echo "</pre>"; */
	}

};