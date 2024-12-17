<?php if ( ! defined('__PUDINTEA__')) exit('No direct script access allowed');
/*
 * ***************************************************************
 *  Script 		: Belajar Codeigniter
 *  Version 	: 3.1.11
 *  Date 		: 01 Maret 2024
 *  Author 		: Pudin Saepudin Development Ciamis
 *  Email 		: pudin.alazhar@gmail.com
 *  Description : Seorang Petani yang suka dengan teknologi.
 *  Blog 		: https://www.pdn.my.id / https://anibarstudio.blogspot.com.
 *  Github 		: https://github.com/pudintea.
 * ***************************************************************
 */
class Pudin_dev {
	
	// SET SUPER GLOBAL
	var $CI = NULL;
	public function __construct() {
		$this->CI =& get_instance();
	}

	public function pdn_is_login()
	{
		$auth_email 	= $this->CI->session->userdata('pdn_email');
		$auth_id 		= $this->CI->session->userdata('pdn_login');
		$auth_token 	= $this->CI->session->userdata('pdn_token');
		
		if(empty($auth_email) || empty($auth_id ) || empty($auth_token )){
			redirect(base_url('bo/logout'));
		}else{
			$nama_tb = 'users';
			$this->CI->db->select('id_users, users_token');
			$this->CI->db->where('id_users', $auth_id);
			$datatb = $this->CI->db->get($nama_tb)->row();
			//TokendariDB
			$token_db = $datatb->users_token;
			//
			if($auth_token != $token_db){
				redirect(base_url('bo/logout'));
			}
		}
	}
	
	public function pdn_is_admin()
	{
		$auth_level= $this->CI->session->userdata('pdn_level');
		
		if($auth_level != 'Admin'){
			redirect(base_url('bo/logout'));
		}
	}
	
	public function pdn_is_guest()
	{
		$auth_level= $this->CI->session->userdata('pdn_level');
		
		if($auth_level != 'Guest'){
			redirect(base_url('bo/logout'));
		}
	}
	
}