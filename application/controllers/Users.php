<?php defined('__PUDINTEA__') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	protected $data;
	function __construct(){
		parent::__construct();
		$this->data = [];
		$this->pudin_dev->pdn_is_login();
		$this->pudin_dev->pdn_is_admin();
	}
	
    public function ClassNama()		{ return 'users'; }
    public function Author()		{ return 'Pudin Saepudin'; }
	
	public function index()
	{
		$this->data['pdn_title'] 		= 'Data Users';
		$this->data['pdn_url'] 			= $this->ClassNama();
		$this->data[$this->ClassNama()] = 'active';
		$this->template->pdn_load('template/sbadmin', $this->ClassNama().'/table', $this->ClassNama().'/table_kode', $this->data);
	}
	
	public function tambah()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.users_email]',[
			'is_unique' => 'This email has already registered!',
		]);
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]',[
			'matches' => 'Password dont match!',
			'min_length' => 'Password too short!',
		]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
		if ($this->form_validation->run() == FALSE)
        {
			//Tampilkan form input
			$this->data['pdn_title'] 		= 'Tambah - Data Users';
			$this->data['pdn_url'] 			= $this->ClassNama();
			$this->data['pdn_uform'] 		= $this->ClassNama().'/tambah';
			$this->data['pdn_page'] 		= 'Tambah';
			$this->data[$this->ClassNama()] = 'active';
			$this->data['nama'] = [
				'name' 			=> 'nama',
				'id' 			=> 'nama',
				'type' 			=> 'text',
				'class' 		=> 'form-control',
				'placeholder' 	=> 'Nama Lengkap',
				'required' 		=> 'required',
				'value' 		=> $this->form_validation->set_value('nama'),
			];
			$this->data['email'] = [
				'name' 			=> 'email',
				'id' 			=> 'email',
				'type' 			=> 'email',
				'class' 		=> 'form-control',
				'placeholder' 	=> 'Email Address',
				'required' 		=> 'required',
				'value' 		=> $this->form_validation->set_value('email'),
			];
			$this->data['password1'] = [
				'name' 			=> 'password1',
				'id' 			=> 'password1',
				'type' 			=> 'password',
				'class' 		=> 'form-control form-control-user',
				'placeholder' 	=> 'Password',
				'required' 		=> 'required',
			];
			$this->data['password2'] = [
				'name' 			=> 'password2',
				'id' 			=> 'password2',
				'type' 			=> 'Password',
				'class' 		=> 'form-control form-control-user mt-3',
				'placeholder' 	=> 'Repeat Password',
				'required' 		=> 'required',
			];
			// Load Template
			$this->template->load('template/sbadmin', $this->ClassNama().'/tambah', $this->data);
        }else
        {
        	// Panggil Library
        	$this->load->library(['bcrypt']);

			//Prosess input datanya
			$pdn_data['users_nama'] 		= htmlspecialchars($this->input->post('nama', true));
			$pdn_data['users_email'] 		= htmlspecialchars($this->input->post('email', true));
			$pdn_data['users_password'] 	= $this->bcrypt->hash_password($this->input->post('password1'));
			$pdn_data['users_level'] 		= $this->input->post('level', true);
			$pdn_data['users_active'] 		= 1;
			
			$this->load->model('Pdn_crud', 'M_pdn');
			//save($nama_tb, $save_data)
			$addtodb = $this->M_pdn->save('users',$pdn_data);
		
			if ($addtodb){
				$message = "Data berhasil ditambah!";
				$this->session->set_flashdata('success', $message);
				redirect(base_url($this->ClassNama()), 'refresh');
			}else{
				$message = "MAAF, Data tidak berhasil ditambahkan!";
				$this->session->set_flashdata('error', $message);
				redirect(base_url($this->ClassNama().'/tambah'), 'refresh');
			}
        }
	}
	
	public function edit()
	{
		
		
		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		if ($this->form_validation->run() == FALSE)
        {
        	$_id = $this->uri->segment(3);
			$_id_asli = base64_decode($_id);

			//Tampilkan form
			$this->data['pdn_title'] 		= 'Edit - Data Akun';
			$this->data['pdn_url'] 			= $this->ClassNama();
			$this->data['pdn_uform'] 		= $this->ClassNama().'/edit';
			$this->data['pdn_page'] 		= 'Update';
			$this->data[$this->ClassNama()] = 'active';
			$this->load->model('Pdn_crud', 'M_pdn');
			// edit($_id, $nama_id, $nama_tb)
			$this->data['edit_data'] = $this->M_pdn->edit($_id_asli, 'id_users','users');
			$this->data['nama'] = [
				'name' 			=> 'nama',
				'id' 			=> 'nama',
				'type' 			=> 'text',
				'class' 		=> 'form-control',
				'placeholder' 	=> 'Nama Lengkap',
				'required' 		=> 'required',
				'value' 		=> $this->data['edit_data']->users_nama,
			];
			$this->data['email'] = [
				'name' 			=> 'email',
				'id' 			=> 'email',
				'type' 			=> 'email',
				'class' 		=> 'form-control',
				'placeholder' 	=> 'Email Address',
				'required' 		=> 'required',
				'value' 		=> $this->data['edit_data']->users_email,
			];
			// Load Template
			$this->template->load('template/sbadmin', $this->ClassNama().'/edit', $this->data);
        }else
        {
			//Prosess edit datanya
			$id_update						= htmlspecialchars($this->input->post('id', true));
			if (empty($id_update)){
				$message = "MAAF, ID Update Tidak ditemukan!";
				$this->session->set_flashdata('error', $message);
				redirect(base_url($this->ClassNama()), 'refresh');
			}
			
			$pdn_data['users_nama'] 		= htmlspecialchars($this->input->post('nama', true));
			$pdn_data['users_email'] 		= htmlspecialchars($this->input->post('email', true));
			$pdn_data['users_level'] 		= $this->input->post('level', true);
			
			$_id_update_asli = base64_decode($id_update);
			$this->load->model('Pdn_crud', 'M_pdn');
			// update($_id, $nama_id, $nama_tb, $update_data)
			$addtodb = $this->M_pdn->update($_id_update_asli, 'id_users','users', $pdn_data);
			
			if ($addtodb){
				$message = "Data berhasil diupdate!";
				$this->session->set_flashdata('success', $message);
				redirect(base_url($this->ClassNama()), 'refresh');
			}else{
				$message = "MAAF, Data tidak berhasil diupdate!";
				$this->session->set_flashdata('error', $message);
				redirect(base_url($this->ClassNama()), 'refresh');
			}
        }
	}
	
	public function hapus()
	{
		$_id = $this->uri->segment(3);
		$_id_asli = base64_decode($_id);

		if (empty($_id)){
			$message = "MAAF, ID Tidak ditemukan!";
			$this->session->set_flashdata('error', $message);
			redirect(base_url($this->ClassNama()), 'refresh');
		}
		if ($_id_asli == $this->session->userdata('pdn_login')){
			$message = "MAAF, Tidak diizinkan menghapus user ini!";
			$this->session->set_flashdata('error', $message);
			redirect(base_url($this->ClassNama()), 'refresh');
		}
		$this->load->model('Pdn_crud', 'M_pdn');
		// delete($_id, $nama_id,$nama_tb)
		$deletefromdb = $this->M_pdn->delete($_id_asli,'id_users','users');
	
		if ($deletefromdb){
			$message = "Data berhasil dihapus!";
			$this->session->set_flashdata('success', $message);
			redirect(base_url($this->ClassNama()), 'refresh');
		}else{
			$message = "MAAF, Data tidak berhasil dihapus!";
			$this->session->set_flashdata('error', $message);
			redirect(base_url($this->ClassNama()), 'refresh');
		}
	}

	public function reset()
	{
		$_id = $this->uri->segment(3);
		$_id_asli = base64_decode($_id);

		if (empty($_id)){
			$message = "MAAF, ID Tidak ditemukan!";
			$this->session->set_flashdata('error', $message);
			redirect(base_url($this->ClassNama()), 'refresh');
		}


			$pdn_data['users_password'] 	= password_hash('1234567890', PASSWORD_DEFAULT);
			$this->load->model('Pdn_crud', 'M_pdn');
			// update($_id, $nama_id, $nama_tb, $update_data)
			$resetpas = $this->M_pdn->update($_id_asli,'id_users','users',$pdn_data);
	
		if ($resetpas){
			$message = "User berhasil direset!";
			$this->session->set_flashdata('success', $message);
			redirect(base_url($this->ClassNama()), 'refresh');
		}else{
			$message = "MAAF, User tidak berhasil direset!";
			$this->session->set_flashdata('error', $message);
			redirect(base_url($this->ClassNama()), 'refresh');
		}
	}

	function data_json()
	{
		//if($this->input->method(TRUE)=='POST'): // Hanya lewat metode post saja yang di izinkan melihat dan mengambil data
		
			$csrf_name = $this->security->get_csrf_token_name();
			$csrf_hash = $this->security->get_csrf_hash();
				
			$tabel = 'v_users';
			$column_order = array('', 'users_nama','users_email','users_level');
			$column_search = array('users_nama','users_email','users_level');
			$order = array('id_users' => 'DESC');
			//$where = array('admin_level' => 'Operator');
				
				$this->load->model('dt/DatatablesModel' ,'M_najzmi');
				$list = $this->M_najzmi->get_datatables($tabel,$column_order,$column_search,$order);
				$data = array();
				$no = isset($_POST['start']) 	? $_POST['start'] 	: 1;
				
				foreach ($list as $pDn) {
					$no++;
					$row = array();
					$row[] = $no;
					$row[] = $pDn->users_nama;
					$row[] = $pDn->users_email;
					$row[] = $pDn->users_level;
					$row[] = '<div class="btn-group">
								  <a href="'.$this->ClassNama().'/edit/'.base64_encode($pDn->id_users).'"  class="btn btn-success btn-sm">Edit</a>
								  <a href="'.$this->ClassNama().'/hapus/'.base64_encode($pDn->id_users).'" class="btn btn-danger btn-sm tombol-hapus" onclick="return confirm(`Yakin akan dihapus.?`);">Hapus</a>
								  <a href="'.$this->ClassNama().'/reset/'.base64_encode($pDn->id_users).'" class="btn btn-info btn-sm tombol-hapus" onclick="return confirm(`RESET? Password defaultnya: 1234567890`);">Reset</a>
								</div>';
					
					$data[] = $row;
				}
				
				
				$output = array(
								"draw" => isset($_POST['draw']) 	? $_POST['draw'] 	: 'null',
								"recordsTotal" => $this->M_najzmi->count_all($tabel,$column_order,$column_search,$order),
								"recordsFiltered" => $this->M_najzmi->count_filtered($tabel,$column_order,$column_search,$order),
								"data" => $data,
						);
				$output[$csrf_name] = $csrf_hash;
				//output to json format
				header('Content-type: application/json');
				echo json_encode($output);
			// End Json
		//endif;
	}
}
