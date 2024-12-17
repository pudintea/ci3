<?php
defined('__PUDINTEA__') OR exit('No direct script access allowed');

class Bo extends CI_Controller {
	protected $data;
	function __construct()
	{
		parent::__construct();
		$this->data = [];
		date_default_timezone_set('Asia/Jakarta');
	}

	public function author()	{return 'Pudin Saepudin';}
	public function MainModel()	{return 'Bo_Models';}
	public function contact()	{return 'pudin.alazhar@gmail.com';}
	public function ClassNama()	{return 'bo';}

	public function index()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		
		if($this->form_validation->run() == FALSE){
			$this->data['pdn_title'] 		= ' Login Page'; // Title untuk setiap Halaman
			$this->data[$this->ClassNama()] = 'active'; // Status Untuk Menu
			$this->data['pdn_url'] 			= base_url($this->ClassNama());

			$this->data['email'] = [
				'name' 				=> 'email',
				'id' 				=> 'email',
				'type' 				=> 'email',
				'class' 			=> 'form-control form-control-user',
				'placeholder' 		=> 'Enter Email Address...',
				'required' 			=> 'required',
				'aria-describedby' 	=> 'emailHelp',
				'value' 			=> $this->form_validation->set_value('nama'),
			];
			$this->data['password'] = [
				'name' 			=> 'password',
				'id' 			=> 'password',
				'type' 			=> 'password',
				'class' 		=> 'form-control form-control-user',
				'placeholder' 	=> 'Password',
				'required' 		=> 'required',
				'value' 		=> $this->form_validation->set_value('password'),
			];

			$this->load->view('bo/login', $this->data);
		}else{
			// Validasi berhasil
			$this->_login();
		}
	}

	private function _login(){
		$email 		= $this->input->post('email', true);
		$password 	= $this->input->post('password', true);

		// Load Library Bcrypt
		$this->load->library(['bcrypt']);
		
		$where_user = ['users_email' => $email];
		$this->load->model($this->MainModel(), 'M_najzmi');
		$user = $this->M_najzmi->db_get_where($where_user);
		$create_token = md5(date('Y-m-d').'https://t.me/pudin_ira'.base_url().'-'.$email.'-'.time());
		$token_user = array('users_token' => $create_token);
		if($user){
			// Jika user ada
			if($user['users_active'] == 1){
				// User aktiv
				if($this->bcrypt->check_password($password, $user['users_password'])){
					//password benar/sama
					if ($user['users_level'] == 'Admin'){
						//ADMIN
						$this->M_najzmi->update_token($token_user,$where_user);
						$create_session['pdn_email'] 		= $user['users_email'];
						$create_session['pdn_nama'] 		= $user['users_nama'];
						$create_session['pdn_level'] 		= $user['users_level'];
						$create_session['pdn_login'] 		= $user['id_users'];
						$create_session['pdn_token'] 		= $create_token;
						//BUAT SESSION
						$this->session->set_userdata($create_session);

						//REDIRECT
						redirect(base_url('dashboard'), 'refresh');
					}elseif($user['users_level'] == 'Guest'){
						//GUEST
						$this->M_najzmi->update_token($token_user,$where_user);
						$create_session['pdn_email'] 		= $user['users_email'];
						$create_session['pdn_nama'] 		= $user['users_nama'];
						$create_session['pdn_level'] 		= $user['users_level'];
						$create_session['pdn_login'] 		= $user['id_users'];
						$create_session['pdn_token'] 		= $create_token;
						//BUAT SESSION
						$this->session->set_userdata($create_session);
						//REDIRECT
						redirect(base_url('dashboard'), 'refresh');
					}else{
						//Level tidak terdaftar
					$message = "Level tidak Terdaftar!";
					$this->session->set_flashdata('error', $message);
					redirect(base_url('bo/logout'), 'refresh');
					}
				}else{
					//password salah
					$message = "Wrong password!";
					$this->session->set_flashdata('error', $message);
					redirect(base_url('bo'), 'refresh');
				}
			}else{
				// User tidak aktiv
				$message = "This email has not been activated!";
				$this->session->set_flashdata('error', $message);
				redirect(base_url('bo'), 'refresh');
			}
		}else{
			// Jika tidak user ada
			$message = "Email is not registered!";
			$this->session->set_flashdata('error', $message);
			redirect(base_url('bo'), 'refresh');
		}
		
	}
	
	public function logout(){
		$this->session->unset_userdata(
			array(
				'pdn_email',
				'pdn_nama',
				'pdn_login',
				'pdn_level',
				'pdn_token'
			)
		);

		//$this->session->sess_destroy();
		$message = "You have been logged out!";
		$this->session->set_flashdata('success', $message);
		redirect(base_url('bo'), 'refresh');
	}
}
