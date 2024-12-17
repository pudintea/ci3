<?php
defined('__PUDINTEA__') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	protected $data;
	function __construct()
	{
		parent::__construct();
		$this->data = [];
		date_default_timezone_set('Asia/Jakarta');
		$this->pudin_dev->pdn_is_login();
		$this->pudin_dev->pdn_is_admin();
	}

	public function author()	{return 'Pudin Saepudin';}
	public function MainModel()	{return 'Dashboard_Models';}
	public function contact()	{return 'pudin.alazhar@gmail.com';}
	public function ClassNama()	{return 'dashboard';}

	public function index()
	{
		$this->data['pdn_title'] 		= 'Dashboard';
		$this->data[$this->ClassNama()] = 'active';
		$this->template->pdn_load('template/sbadmin',$this->ClassNama().'/dashboard',$this->ClassNama().'/kode',$this->data);
	}
}